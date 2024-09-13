
@props(['icon'])

@php
    $activeClass = isset($activeStepper) ? 'bg-amber-400 text-secondary' : 'bg-secondary text-primary hover:text-secondary hover:bg-amber-400 cursor-pointer'; 
@endphp
<li class="flex w-full items-center border-secondary text-secondary" x-transition.duration.200ms wire:ignore  @if(!isset($activeStepper)) style="display: none;" @endif {{ $attributes }}>
    <i class="{{ $icon }} sm:text-xl text-lg mx-3 {{ $activeClass }} duration-300 flex items-center justify-center w-10 h-10 rounded-full lg:h-12 lg:w-12 shrink-0" stepper-item wire:ignore></i>
</li>

