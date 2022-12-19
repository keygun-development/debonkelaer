<x-app-layout>
    @section('content')
        <div class="main-container">
            <div class="flex justify-between">
                <h1 class="font-bold">
                    Nieuws
                </h1>
                @can('isAdmin')
                    <a href="/dashboard/nieuws/nieuwepost" class="c-button c-button__blue">
                        Nieuwe post
                    </a>
                @endcan
            </div>
            <div class="grid md:grid-cols-2 grid-cols-1 gap-4 mt-4">
                @foreach($posts as $post)
                    <x-latest-news :post="$post"/>
                @endforeach
            </div>
            <div class="mt-4">
                {!! $posts->links() !!}
            </div>
        </div>
    @endsection
</x-app-layout>
