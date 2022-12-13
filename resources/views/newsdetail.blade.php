<x-app-layout>
    @section('content')
        <div class="main-container">
            <div class="flex md:w-10/12 w-full flex-col border-b">
                <div class="flex justify-between flex-wrap">
                    <h1 class="font-bold">
                        {{ $post->post_title }}
                    </h1>
                    @can('isAdmin')
                        <a href="/dashboard/nieuws/{{ $post->post_slug }}" class="c-button c-button__blue">
                            Post aanpassen
                        </a>
                    @endcan
                </div>
                @if($post->post_image)
                    <div class="mt-4">
                        <img src="{{ asset($post->post_image) }}"/>
                    </div>
                @endif
                <div id="content" class="my-4">
                    {!! $post->post_content !!}
                </div>
            </div>
            <div class="w-10/12">
                <h3>
                    Auteur
                </h3>
                <p>
                    {{ $post->author->name }}
                </p>
            </div>
        </div>
    @endsection
</x-app-layout>
