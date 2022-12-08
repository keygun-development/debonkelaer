<x-app-layout>
    @section('content')
        <div class="main-container">
            <h1 class="font-bold">
                Nieuws
            </h1>
            <div class="grid grid-cols-2 gap-4 mt-4">
                @foreach($posts as $post)
                    <x-latest-news :post="$post" />
                @endforeach
            </div>
        </div>
    @endsection
</x-app-layout>
