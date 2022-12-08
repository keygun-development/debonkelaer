<div class="bg-blue-50 shadow-sm">
    <div class="main-container">
        <div class="flex justify-between items-center">
            <div class="w-1/12">
                <a href="/">
                    <img src="{{ asset('images/logo.webp') }}" alt="Tclievelde Logo"/>
                </a>
            </div>
            <div class="c-header__menu flex items-end">
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-navigation></x-navigation>
                </div>
            </div>
            <div class="w-2/12 flex justify-end">
                @if(Auth::check())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="c-button c-button__blue inline-block cursor-pointer" :href="route('logout')"
                           onclick="event.preventDefault();
                                                this.closest('form').submit();">
                            Uitloggen
                        </a>
                    </form>
                @else
                    <a class="c-button c-button__blue inline-block" href="/inloggen">
                        Inloggen
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
