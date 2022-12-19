@extends('layouts.dashboard')
@section('pageTitle', 'Nieuwe post')
@section('content')
    <form enctype="multipart/form-data" method="POST" action="{{ route('dashboard.news.new') }}">
        @csrf
        <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"/>
        <input
            name="title"
            class="c-form__input-float text-lg font-bold mt-4"
            type="text"
            placeholder="Post titel"
        />
        <div class="mt-4">
            <h2>
                Post content
            </h2>
            <editor></editor>
        </div>
        <div class="flex justify-end my-4">
            <input class="c-button c-button__blue cursor-pointer" type="submit" value="Opslaan"/>
        </div>
        <div class="mt-4">
            @if($errors->any())
                <div class="text-red-500">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
    </form>
@endsection
