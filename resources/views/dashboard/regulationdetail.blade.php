@extends('layouts.dashboard')
@section('content')
    <form method="POST" action="{{ route('dashboard.regulations.update') }}">
        @csrf
        <input type="hidden" value="{{ $regulation->id }}" name="id"/>
        <input
            name="name"
            class="c-form__input-float text-lg font-bold mt-4"
            type="text"
            value="{{ $regulation->name }}"
            placeholder="Tarief naam"
        />
        <editor
            :text="{{ json_encode($regulation->description) }}"
        ></editor>
        <div class="flex justify-end my-4">
            <input class="c-button c-button__blue cursor-pointer" type="submit" value="Opslaan"/>
        </div>
    </form>
@endsection
