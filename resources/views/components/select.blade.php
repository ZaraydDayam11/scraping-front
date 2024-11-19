@props(['disabled' => false])

<select {!! $attributes->merge([
    'class' => 'text-sm border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm w-full',
]) !!}>
    {{ $options }}
</select>
