<div>
    <a href="{{$route ?? '/'}}">
        <div class="group/itemMenu flex flex-col items-center sm:flex-row group-hover:justify-start justify-center hover:bg-amber-400 transition-all ease-in-out py-4 sm:px-0 px-4 duration-300 delay-75">
            <i {{ $attributes->merge(['class' => "$icon sm:text-2xl text-3xl mx-3 text-primary group-hover/itemMenu:text-secondary duration-300"]) }}></i>
            <span class="hidden text-primary group-hover:block transition-all ease-in-out my-auto group-hover/itemMenu:text-secondary duration-300">
                {{ $slot }}
            </span>
        </div>
    </a>
</div>
