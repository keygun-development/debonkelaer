<x-app-layout>
    @section('content')
        <div class="main-container">
            <div class="flex w-10/12 flex-col border-b">
                <h1 class="font-bold">
                    {{ $post->post_title }}
                </h1>
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
                <a href="/user/{{ $post->author->id }}">
                    {{ $post->author->name }}
                </a>
            </div>
        </div>
    @endsection
</x-app-layout>
