@props(['title','opened' => false])

<div x-data="{ isExpanded: {{ $opened ? 'true' : 'false' }} }" class="divide-y divide-neutral-300 dark:divide-neutral-700">
    <button id="controlsAccordionItemOne" type="button" class="flex w-full items-center justify-between gap-4 bg-neutral-50 p-4 text-left underline-offset-2 hover:bg-neutral-50/75 focus-visible:bg-neutral-50/75 focus-visible:underline focus-visible:outline-none dark:bg-neutral-900 dark:hover:bg-neutral-900/75 dark:focus-visible:bg-neutral-900/75" aria-controls="accordionItemOne" @click="isExpanded = ! isExpanded" :class="isExpanded ? 'text-onSurfaceStrong dark:text-onSurfaceDarkStrong font-bold'  : 'text-onSurface dark:text-onSurfaceDark font-medium'" :aria-expanded="isExpanded ? 'true' : 'false'">
       <h1 class="text-xl">{{ $title }}</h1>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke="currentColor" class="size-5 shrink-0 transition" aria-hidden="true" :class="isExpanded  ?  'rotate-180'  :  ''">
           <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
        </svg>
    </button>
    <div x-cloak x-show="isExpanded" id="accordionItemOne" role="region" aria-labelledby="controlsAccordionItemOne" x-collapse>
        <div class="p-4 text-sm sm:text-base text-pretty">
             {{ $slot }}
        </div>
    </div>
</div>