@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-kaki-300 focus:border-gold focus:ring-gold rounded-md shadow-sm']) }}>
