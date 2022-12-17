@extends('layouts.dashboard')
@section('content')
    <form method="POST" action="{{ route('dashboard.prices.update') }}">
        @csrf
        <input type="hidden" value="{{ $price->id }}" name="id"/>
        <input
            name="name"
            class="c-form__input-float text-lg font-bold mt-4"
            type="text"
            value="{{ $price->name }}"
            placeholder="Tarief naam"
        />
        <input
            name="price"
            class="c-form__input-float text-lg font-bold mt-4"
            type="text"
            value="{{ $price->price }}"
            placeholder="Tarief prijs"
        />
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
