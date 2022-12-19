@extends('layouts.dashboard')
@section('pageTitle', 'Reservering details')
@section('content')
    <p class="font-bold">
        Let op: Via het dashboard wordt er niet gecontroleerd of er op het geselecteerde moment al wordt gespeeld! (Je
        kunt hierdoor dus dubbele lessen krijgen). Je kunt ook niet extra medespelers toevoegen aan een reservering.
    </p>
    <form class="mt-4" method="POST" action="{{ route('dashboard.reservations.update') }}">
        @csrf
        <div class="flex flex-col md:flex-row justify-between">
            <div class="md:w-5/12 w-full">
                <input type="hidden"
                       name="id"
                       value="{{ $reservation->id }}"
                />
                @foreach($reservation->users()->get() as $key => $user)
                    <div>
                        <label for="participant{{ $key+1 }}">
                            Medespeler {{ $key+1 }}:
                        </label>
                        <select name="participant{{ $key+1 }}" class="c-form__input-float">
                            <option></option>
                            @foreach($users as $userd)
                                <option value="{{ $userd->id }}">
                                    {{ $userd->name }} - {{ $userd->membership_id }}
                                </option>
                            @endforeach
                            @foreach($reservation->users()->get() as $userd)
                                <option {{ $user->id === $userd->id ? 'selected' : '' }} value="{{ $userd->id }}">
                                    {{ $userd->name }} - {{ $userd->membership_id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
            <div class="md:w-5/12 w-full">
                <div>
                    <label>
                        Baan:
                    </label>
                    <select
                        name="track"
                        class="c-form__input-float">
                        <option {{ $reservation->track === 1 ? 'selected' : '' }}>
                            1
                        </option>
                        <option {{ $reservation->track === 2 ? 'selected' : '' }}>
                            2
                        </option>
                    </select>
                </div>
                <div class="mt-4">
                    <label>
                        Datum:
                    </label>
                    <input class="c-form__input-float"
                           type="date"
                           name="date"
                           value="{{ $reservation->date }}"
                    />
                </div>
                <div class="mt-4">
                    <label>
                        Tijd:
                    </label>
                    <select
                        name="time"
                        class="c-form__input-float">
                        @foreach($times as $time)
                            <option {{ $reservation->time === $time ? 'selected' : '' }}>{{ $time }}</option>
                        @endforeach
                    </select>
                </div>
                @if($reservation->endtime)
                    <div class="mt-4">
                        <label>
                            Eind tijd:
                        </label>
                        <select
                            name="timeend"
                            class="c-form__input-float">
                            @foreach($times as $time)
                                <option {{ $reservation->endtime === $time ? 'selected' : '' }}>{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            </div>
        </div>
        <input type="submit" value="Opslaan"
               class="c-button c-button__blue cursor-pointer mt-4"
        />
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
