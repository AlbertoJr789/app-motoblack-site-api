<div
    class="group fixed sm:top-0 m-0 bottom-0 sm:w-20 drop-shadow-xl bg-zinc-900 sm:hover:w-[230px] transition-all duration-300 z-[2]">

    <div class="bg-zinc-900 mx-auto my-4 px-2 sm:block hidden w-20 sm:group-hover:w-[100px] transition-all duration-300">
        <a href="{{ route('admin.dashboard') }}">
            <x-application-mark />
        </a>
    </div>

    <div class="bg-zinc-900 flex sm:flex-col flex-row sm:h-full sm:w-auto w-screen sm:hover:overflow-y-scroll overflow-y-hidden overflow-x-auto sm:pb-[10em] sm:pt-5">
        @include('layouts.menu')
    </div>
</div>