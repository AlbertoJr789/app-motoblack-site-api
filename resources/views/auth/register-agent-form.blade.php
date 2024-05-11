<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{asset('img/moto_black_logo.png')}}" alt="Logo Moto Black" class="h-40 w-80">
        </x-slot>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}">
            @csrf

            @if(request()->query('mototaxista'))
                <input type="text" name="mototaxista" value="true" hidden>
            @endif

            <div>
                <x-label for="name" value="{{ __('Driver\'s License') }}" class="required"/>
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div>
                <x-label for="name" value="{{ __('Vehicle\'s License') }}" class="required"/>
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
