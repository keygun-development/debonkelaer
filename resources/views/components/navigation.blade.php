<ul>
    <x-nav-link :href="route('welcome')" :active="request()->routeIs('welcome')">
        {{ __('Home') }}
    </x-nav-link>
    <x-nav-link :href="route('news')" :active="request()->routeIs('news')">
        {{ __('Nieuws') }}
    </x-nav-link>
    <x-nav-link :href="route('prices')" :active="request()->routeIs('prices')">
        {{ __('Tarieven') }}
    </x-nav-link>
    <x-nav-link :href="route('reservation')" :active="request()->routeIs('reservation')">
        {{ __('Reserveren') }}
    </x-nav-link>
    <x-nav-link :href="route('regulations')" :active="request()->routeIs('regulations')">
        {{ __('Reglement') }}
    </x-nav-link>
    <x-nav-link :href="route('impressions')" :active="request()->routeIs('impressions')">
        {{ __('Impressies') }}
    </x-nav-link>
</ul>
