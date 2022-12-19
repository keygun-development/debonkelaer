<x-app-layout>
    @section('pageTitle', 'Reglement')
    @section('content')
        <div class="main-container">
            <div class="flex justify-between flex-wrap">
                <h1 class="font-bold">
                    Reglement
                </h1>
                @can('isAdmin')
                    <a href="/dashboard/reglementen" class="c-button c-button__blue">
                        Reglement aanpassen
                    </a>
                @endcan
            </div>
            <p class="mt-4">
                T.C. Lievelde Baanreglement tennispark “De Bonkelaer”
            </p>
            @foreach($regulations as $regulation)
                <div class="my-4">
                    <h3 class="font-bold">
                        {{ $regulation->name }}
                    </h3>
                    <p class="mt-2">
                        {!! $regulation->description !!}
                    </p>
                </div>
            @endforeach
        </div>
    @endsection
</x-app-layout>
