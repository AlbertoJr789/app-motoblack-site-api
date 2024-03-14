
@php
    $activeClass = isset($activeStepper) ? 'bg-amber-400 text-secondary' : 'bg-secondary text-primary hover:text-secondary hover:bg-amber-400 cursor-pointer'; 
@endphp
<li class="flex w-full items-center border-secondary text-secondary after:w-full after:h-1 after:border-b after:border-secondary after:border-4 after:inline-block">
    <i {{ $attributes->merge(['class' => "$icon sm:text-xl text-lg mx-3 $activeClass duration-300 flex items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 shrink-0"]) }} stepper-item></i>
</li>

