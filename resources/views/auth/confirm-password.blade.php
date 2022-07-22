<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Confirm Password') }}
        </h2>
    </x-slot>

    <x-jet-validation-errors class="mb-4" />

    <form action="{{ route('password.confirm') }}" method="post">
        @csrf
        <div class="mt-4">
            <x-jet-label for="password" value="{{ __('Password') }}" />
            <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required />
        </div>
        <div class="flex items-center justify-end mt-4">
            <x-jet-button>
                {{ __('Confirm Password') }}
            </x-jet-button>
        </div>
    </form>
</x-app-layout>