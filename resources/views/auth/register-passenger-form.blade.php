<x-guest-layout>
    <x-authentication-card >
        <x-slot name="logo">
            <img src="{{asset('img/moto_black_logo.png')}}" alt="Logo Moto Black" class="h-60 w-60">
        </x-slot>

        <x-validation-errors class="mb-4" />
 
        <form method="POST" action="{{ route('createPassenger') }}">
            @csrf

                <div>
                    <x-label for="name" value="{{ __('User Name') }}" class="required"/>
                    <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                </div>
    
                <div class="mt-4">
                    <x-label for="email" value="{{ __('Email') }}" />
                    <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" />
                </div>
    
                <div class="mt-4">
                    <x-label for="telefone" value="{{ __('Phone Number') }}" />
                    <x-phone-input id="telefone" class="block mt-1" name="telefone" />
                </div>
    
                <div class="mt-4">
                    <x-label for="password" value="{{ __('Password') }}" class="required" />
                    <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                </div>


            {{-- <div class="mt-4">
                <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div> --}}

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox name="terms" id="terms" required />

                            <div class="ml-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            @endif

            <div class="flex items-center justify-end mt-4">
                <x-button class="ml-4" type="button" onclick="submitRegister()">
                    {{ __('Register') }}
                </x-button>
                <button id="submit" hidden></button>
            </div>
        </form>
    </x-authentication-card>
    @push('scripts')
        <script>
            function submitRegister(){
                if(!validateTelefone()){
                    Swal.fire({
                        icon: 'warning',
                        title: `{{__('Invalid Fields')}}`,
                        text: `{{__('The given phone number is invalid!')}}`,
                    })
                    return
                }
                document.querySelector('#submit').click()
            }
        </script>
    @endpush
</x-guest-layout>

