<x-app-layout>
    @section('content')
        <div class="main-container">
            <div class="flex justify-between flex-wrap">
                <h1 class="font-bold">
                    Impressies
                </h1>
                @can('isAdmin')
                    <a href="/dashboard/impressies" class="c-button c-button__blue">
                        Impressies aanpassen
                    </a>
                @endcan
            </div>
            <div class="mt-8">
                <swiper-init></swiper-init>
            </div>
    @endsection
</x-app-layout>
