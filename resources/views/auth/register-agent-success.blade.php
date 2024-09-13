<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <img src="{{asset('img/moto_black_logo.png')}}" alt="Logo Moto Black" class="h-60 w-60">
        </x-slot>


        <div class="text-center">
            <h1>Seu cadastro foi efetuado com sucesso! Aguarde enquanto validamos seus documentos.</h1>
            <a href="{{route('login')}}" class="btn-primary mt-4">
                {{ __('Ok') }}
            </a>
        </div>

    </x-authentication-card>
</x-guest-layout>
