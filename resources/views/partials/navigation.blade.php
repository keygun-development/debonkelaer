<div class="bg-blue-50 shadow-sm">
    <div class="main-container">
        <div class="flex justify-between items-center">
            <div class="sm:w-2/12 w-8/12">
                <div class="w-6/12">
                    <a href="/">
                        <img src="{{ asset('images/logo.webp') }}" alt="Tclievelde Logo"/>
                    </a>
                </div>
            </div>
            <div class="c-header__menu flex items-end">
                <div class="hidden lg:flex justify-center w-full">
                    <x-navigation></x-navigation>
                </div>
                <div id="navigation" class="flex lg:hidden justify-end w-full">
                    <mobile-menu
                        ref="mobileMenuRef"
                    >
                        <template v-slot:disclosure="slotProps">
                            <div @click="this.$refs.mobileMenuRef.disclose()"
                                 class="c-header__bars z-10"
                                 :class="slotProps.active ? 'menu-open' : ''">
                                <div class="one"></div>
                                <div class="two my-1"></div>
                                <div class="three"></div>
                            </div>
                        </template>
                        <template #menuopen>
                            <div class="absolute top-0 bottom-0 sm:w-4/12 w-8/12 right-0 bg-blue-50 shadow-lg py-20 z-[2]">
                                <div class="flex flex-col">
                                    <x-navigation></x-navigation>
                                    <div class="block lg:hidden px-4 mt-8">
                                        @if(Auth::check())
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <a class="c-button c-button__blue inline-block cursor-pointer" href="{{ route('logout') }}"
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
                        </template>
                    </mobile-menu>
                </div>
            </div>
            <div class="lg:w-2/12 lg:flex hidden justify-end">
                @if(Auth::check())
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="c-button c-button__blue inline-block cursor-pointer" href="{{ route('logout') }}"
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
