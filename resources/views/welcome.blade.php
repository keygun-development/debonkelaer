<x-app-layout>
    @section('pageTitle', 'Home')
    @section('content')
        <div class="main-container">
            <div class="w-full md:flex justify-between">
                <div class="md:w-5/12">
                    <div class="flex justify-between flex-wrap">
                        <h1 class="font-bold">
                            Home
                        </h1>
                        @if(Auth::check())
                            <a href="/reserveren" class="c-button c-button__blue">
                                Maak een reservering
                            </a>
                        @endif
                    </div>
                    <p class="lg:leading-7 text-justify my-4">
                        Stichting T.C. Lievelde is eigenaar van Tennispark T.C. Lievelde te Lievelde. Het tennispark kent
                        momenteel twee
                        all-weather kunstgrastennisbanen waarop het gehele jaar te tennissen valt. De banen zijn tevens
                        voorzien van
                        verlichting. Stichting T.C. Lievelde heeft met Tennisclub Lievelde een overeenkomst gesloten tot
                        het
                        gelegenheid geven tot beoefening van de tennissport op Tennispark T.C. Lievelde. Aan Tennisclub
                        Lievelde is
                        door Stichting T.C. Lievelde tevens in bruikleen gegeven het online-reserveringssysteem. Leden
                        van de
                        tennisvereniging kunnen via een online systeem een tennisbaan reserveren op Tennispark T.C. Lievelde.
                        Tennisvereniging Lievelde biedt haar leden tevens de mogelijkheid tot het nemen van
                        tennislessen.
                    </p>
                </div>
                <div class="md:w-6/12">
                    <h2 class="font-bold">
                        Laatste nieuws
                    </h2>
                    <div class="grid grid-cols-1 gap-4 mt-4">
                        @foreach($posts as $post)
                            <x-latest-news :post="$post"/>
                        @endforeach
                    </div>
                    <div class="flex justify-end mt-4">
                        <a class="text-primary hover:underline" href="/nieuws">
                            Lees meer nieuws <i class="fa-solid fa-chevron-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
