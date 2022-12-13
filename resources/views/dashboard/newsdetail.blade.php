@extends('layouts.dashboard')
@section('content')
    <form enctype="multipart/form-data" method="POST" action="{{ route('dashboard.news.save') }}">
        @csrf
        <input type="hidden" value="{{ $post->id }}" name="id"/>
        <img src="{{ asset($post->post_image) }}" alt="{{ $post->post_image }}"/>
        <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"/>
        <input
            name="title"
            class="c-form__input-float text-lg font-bold mt-4"
            type="text"
            value="{{ $post->post_title }}"
            placeholder="Post titel"
        />
        <div class="mt-4">
            <h2>
                Post content
            </h2>
            <editor
                :text="{{ json_encode($post->post_content) }}"
            ></editor>
        </div>
        <div class="flex justify-end my-4">
            <input class="c-button c-button__blue cursor-pointer" type="submit" value="Opslaan"/>
        </div>
    </form>
@endsection
