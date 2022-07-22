<?php

namespace App\View\Components;

use App\Services\OpenWeatherMap;
use Illuminate\View\Component;

class Weather extends Component
{
    public $weather;

    public $city;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->city = 'Gaza';
        $weatherApi = new OpenWeatherMap(config('services.openWeatherMap.key'));
        $this->weather = $weatherApi->currentWeather($this->city);
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.weather');
    }
}
