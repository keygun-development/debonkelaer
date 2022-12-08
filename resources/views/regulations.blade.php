<x-app-layout>
    @section('content')
        <div class="main-container">
            <h1 class="font-bold">
                Reglement
            </h1>
            <p class="mt-4">
                T.C. Lievelde Baanreglement tennispark “De Bonkelaer”
            </p>
            @foreach($regulations as $regulation)
                <div class="my-4">
                    <h3 class="font-bold">
                        {{ $regulation->name }}
                    </h3>
                    <p class="mt-2">
                        {{ $regulation->description }}
                    </p>
                </div>
            @endforeach
        </div>
    @endsection
</x-app-layout>
