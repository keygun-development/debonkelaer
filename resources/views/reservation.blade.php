<x-app-layout>
    @section('content')
        <div class="main-container">
            <h1 class="font-bold">
                Reserveren
            </h1>
            <div class="flex justify-between mt-4">
                <div class="w-8/12">
                    <h2>
                        Alle reserveringen
                    </h2>
                    <calendar
                        :layout="'listWeek'"
                        :events='[
                @foreach($reservations as $reservation)
                    {
                        id: "{!! $reservation->id !!}",
                        title: "{!! $reservation->user->name !!}",
                        start: "{!! $reservation->date !!}T{!! $reservation->time !!}"
                    },
                @endforeach
                ]'
                    ></calendar>
                </div>
                <div class="w-3/12 flex flex-col items-end">
                    @if($myReservation)
                        <h2>
                            Uw reservering
                        </h2>
                        <div class="flex flex-col">
                            <p class="font-bold">
                                Datum: {{ \Carbon\Carbon::parse($myReservation->date)->format('d F Y') }} {{ $myReservation->time }}
                                - {{ \Carbon\Carbon::make($myReservation->time)->addHour()->format('H:i') }}
                            </p>
                            <p class="font-bold">
                                Baan: {{ $myReservation->track }}
                            </p>
                            <p>
                                Medespeler 1: {{ $myReservation->user->name }}
                            </p>
                            <p>
                                Medespeler 2: {{ $myReservation->participant1->name }}
                            </p>
                            <p>
                                Medespeler 3: {{ $myReservation->participant2->name }}
                            </p>
                            <p>
                                Medespeler 4: {{ $myReservation->participant3->name }}
                            </p>
                            <div class="flex">
                                <popup
                                    ref="popupref2"
                                    :width="'w-10/12'"
                                >
                                    <template #openpopup>
                                        <div class="mt-4">
                                            <a @click="this.$refs['popupref2'].openPopup()"
                                               class="c-button c-button__blue cursor-pointer">
                                                Aanpassen
                                            </a>
                                        </div>
                                    </template>
                                    <template #popup>
                                        <form method="POST" action="/reservation/change">
                                            <div class="flex justify-between">
                                                <div class="w-5/12">
                                                    <input type="hidden" value="{{ $myReservation->id }}"/>
                                                    <div>
                                                        <label for="participant1">
                                                            Medespeler 1:
                                                        </label>
                                                        <input type="text"
                                                               class="c-form__input-float"
                                                               name="participant1"
                                                               value="{{ $myReservation->user->name }}"
                                                               readonly/>
                                                    </div>
                                                    <div class="mt-4">
                                                        <label for="participant2">
                                                            Medespeler 2:
                                                        </label>
                                                        <input
                                                            list="users2"
                                                            name="participant2"
                                                            class="c-form__input-float"
                                                            value="{{ $myReservation->participant1->name }}"
                                                        />
                                                        <datalist id="users2">
                                                            @foreach($users as $user)
                                                                <option
                                                                    value="{{ $user->name }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                    <div class="mt-4">
                                                        <label for="participant3">
                                                            Medespeler 3:
                                                        </label>
                                                        <input
                                                            list="users3"
                                                            name="participant3"
                                                            class="c-form__input-float"
                                                            value="{{ $myReservation->participant2->name }}"
                                                        />
                                                        <datalist id="users3">
                                                            @foreach($users as $user)
                                                                <option
                                                                    value="{{ $user->name }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                    <div class="mt-4">
                                                        <label for="participant4">
                                                            Medespeler 4:
                                                        </label>
                                                        <input
                                                            list="users4"
                                                            name="participant4"
                                                            class="c-form__input-float"
                                                            value="{{ $myReservation->participant3->name }}"
                                                        />
                                                        <datalist id="users4">
                                                            @foreach($users as $user)
                                                                <option
                                                                    value="{{ $user->name }}">{{ $user->name }}</option>
                                                            @endforeach
                                                        </datalist>
                                                    </div>
                                                </div>
                                                <div class="w-5/12">
                                                    <div>
                                                        <label>
                                                            Baan:
                                                        </label>
                                                        <select class="c-form__input-float">
                                                            <option {{ $myReservation->track === 1 ? 'selected' : '' }}>
                                                                1
                                                            </option>
                                                            <option {{ $myReservation->track === 2 ? 'selected' : '' }}>
                                                                2
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="mt-4">
                                                        <label>
                                                            Datum:
                                                        </label>
                                                        <input class="c-form__input-float" type="date"
                                                               value="{{ $myReservation->date }}"/>
                                                    </div>
                                                    <div class="mt-4">
                                                        <label>
                                                            Tijd:
                                                        </label>
                                                        <select class="c-form__input-float">
                                                            @foreach($times as $time)
                                                                <option {{ $time === $myReservation->time ? 'selected' : '' }}>
                                                                    {{ $time }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="submit" value="Aanpassen"
                                                   class="c-button c-button__blue cursor-pointer mt-4"
                                            />
                                        </form>
                                    </template>
                                </popup>
                                <form method="POST" action="/reservation/delete" class="ml-4">
                                    @csrf
                                    <input type="hidden" value="{{ $myReservation->id }}"/>
                                    <popup
                                        ref="popupref"
                                        :width="'w-8/12'"
                                    >
                                        <template #openpopup>
                                            <div class="mt-4">
                                                <a @click="this.$refs['popupref'].openPopup()"
                                                   class="c-button c-button__red cursor-pointer">
                                                    Verwijderen
                                                </a>
                                            </div>
                                        </template>
                                        <template #popup>
                                            <div class="text-center">
                                                <p class="font-bold">
                                                    Weet u zeker dat u uw reservering wilt verwijderen? Hiermee wordt uw
                                                    reservering voorgoed verwijderd.
                                                </p>
                                                <div class="flex justify-center mt-4">
                                                    <a @click="this.$refs['popupref'].close()"
                                                       class="c-button c-button__grey cursor-pointer mr-4">
                                                        Annuleren
                                                    </a>
                                                    <input type="submit" value="Verwijderen"
                                                           class="c-button c-button__red cursor-pointer"/>
                                                </div>
                                            </div>
                                        </template>
                                    </popup>
                                </form>
                            </div>
                        </div>
                    @else
                        <popup
                            :width="'w-10/12'"
                            ref="popupref3"
                        >
                            <template #openpopup>
                                <button class="c-button c-button__blue" @click="this.$refs['popupref3'].openPopup()">
                                    Maak een reservering
                                </button>
                            </template>
                            <template #popup>
                                <form method="POST" action="/reserveren/create">
                                    @csrf
                                    <div class="flex justify-between">
                                        <div class="w-5/12">
                                            <div>
                                                <label for="participant1">
                                                    Medespeler 1:
                                                </label>
                                                <input type="text"
                                                       class="c-form__input-float"
                                                       name="participant1"
                                                       value="{{ Auth::user()->name }}"
                                                       readonly/>
                                            </div>
                                            <div class="mt-4">
                                                <label for="participant2">
                                                    Medespeler 2:
                                                </label>
                                                <input
                                                    list="users2"
                                                    name="participant2"
                                                    class="c-form__input-float"
                                                />
                                                <datalist id="users2">
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->name }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                            <div class="mt-4">
                                                <label for="participant3">
                                                    Medespeler 3:
                                                </label>
                                                <input
                                                    list="users3"
                                                    name="participant3"
                                                    class="c-form__input-float"
                                                />
                                                <datalist id="users3">
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->name }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                            <div class="mt-4">
                                                <label for="participant4">
                                                    Medespeler 4:
                                                </label>
                                                <input
                                                    list="users4"
                                                    name="participant4"
                                                    class="c-form__input-float"
                                                />
                                                <datalist id="users4">
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->name }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="w-5/12">
                                            <div>
                                                <label>
                                                    Baan:
                                                </label>
                                                <select class="c-form__input-float">
                                                    <option>
                                                        1
                                                    </option>
                                                    <option>
                                                        2
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="mt-4">
                                                <label>
                                                    Datum:
                                                </label>
                                                <input class="c-form__input-float" type="date"/>
                                            </div>
                                            <div class="mt-4">
                                                <label>
                                                    Tijd:
                                                </label>
                                                <select class="c-form__input-float">
                                                    @foreach($times as $time)
                                                        {{ $time }}
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="submit" value="Aanmaken"
                                           class="c-button c-button__blue cursor-pointer mt-4"
                                    />
                                </form>
                            </template>
                        </popup>
                    @endif
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
