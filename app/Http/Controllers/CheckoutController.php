<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $client = $this->getPaypalClient();

        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => "test_ref_id1",
                "amount" => [
                    "value" => "100.00",
                    "currency_code" => "USD"
                ]
            ]],
            "application_context" => [
                "cancel_url" => url(route('paypal.cancel')),
                "return_url" => url(route('paypal.return')),
            ]
        ];

        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
            //dd($response);
            if ($response->result->status == 'CREATED') {
                session()->put('paypal_order_id', $response->result->id);
                foreach ($response->result->links as $link) {
                    if ($link->rel == 'approve') {
                        return \redirect()->away($link->href);
                    }
                }
            }

            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            dd($response);
        } catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        } catch (Exception $e) {
            print_r($e->getMessage());
        }
    }

    public function paypalReturn()
    {
        $client = $this->getPaypalClient();
        $id = session()->get('paypal_order_id');
        $request = new OrdersCaptureRequest($id);
        $request->prefer('return=representation');
        try {
            // Call API with your client and get a response for your call
            $response = $client->execute($request);
            
            // If call returns body in response, you can get the deserialized version from the result attribute of the response
            dd($response);

            // Complete the checkout process
            if ($response->result->status == 'COMPLETED') {
                
            }

        }catch (HttpException $ex) {
            echo $ex->statusCode;
            print_r($ex->getMessage());
        }
    }

    public function paypalCancel()
    {
        
    }

    protected function getPaypalClient()
    {
        $config = config('services.paypal');
        $environment = new SandboxEnvironment($config['client_id'], $config['secret']);
        $client = new PayPalHttpClient($environment);
        return $client;
    }
}
