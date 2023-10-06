@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 dark:border-gray-700 dark:bg-neutral-300 dark:text-neutral-900 focus:border-amber-400 dark:focus:border-amber-400 focus:ring-amber-400 dark:focus:ring-amber-600 rounded-md shadow-sm transition duration-400 ease-in-out']) !!}>
