@props(['active'])

@php
    $classes = $active ?
    'current-menu-item'
    : '';
@endphp
<li class="{{ $classes }}">
    <a {{ $attributes }}>
        {{ $slot }}
    </a>
</li>
