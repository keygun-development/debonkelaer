<a class="c-article flex bg-blue-100 rounded-lg shadow-lg" href="/nieuws/{{ $post->post_slug }}">
  <div class="w-2/12">
    <img class="object-cover min-h-full aspect-[3/2] rounded-l-lg overflow-hidden" src="{{ asset($post->post_image) }}" />
  </div>
  <div class="w-10/12 p-4">
    <h3 class="text-lg font-bold">
      {{ $post->post_title }}
    </h3>
    <div class="c-article__content">
      {!! strip_tags($post->post_content) !!}
    </div>
  </div>
</a>
