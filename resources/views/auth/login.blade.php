<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('messages.EmailOrUser.msg') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" placeholder="{{__('messages.EmailOrUser.placeholder')}}" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4">
                <x-label for="password" value="{{ __('messages.Password.msg') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" placeholder="{{__('messages.Password.placeholder')}}" name="password" required autocomplete="current-password" />
            </div>

            <div class="block mt-4 flex justify-between">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('messages.Remember me') }}</span>
                </label>
                <a href="{{route('register')}}" class="underline text-sm text-gray-400">{{__('messages.Dont have an account')}}</a>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('messages.Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ml-4">
                    {{ __('messages.Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
</x-guest-layout>
