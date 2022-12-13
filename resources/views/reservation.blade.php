<x-app-layout>
    @section('content')
        <div class="main-container">
            <h1 class="font-bold">
                Reserveren
            </h1>
            <div class="flex flex-col-reverse md:flex-row md:justify-between mt-4">
                <div class="md:w-8/12 w-full">
                    <h2>
                        Overzicht alle reserveringen
                    </h2>
                    <calendar
                        :layout="'listWeek'"
                        :events='[
                @foreach($reservations as $reservation)
                    {
                        id: "{!! $reservation->id !!}",
                        title: "{!! $reservation->user->name !!} - Baan: {!! $reservation->track !!}",
                        start: "{!! $reservation->date !!}T{!! $reservation->time !!}"
                    },
                @endforeach
                ]'
                    ></calendar>
                </div>
                <div class="md:w-3/12 flex flex-col mb-4 md:mb-0">
                    @can('isAdmin')
                        <div class="mb-4">
                            <popup
                                :width="'md:w-10/12 w-full'"
                                ref="popupref4"
                            >
                                <template #openpopup>
                                    <button class="c-button c-button__blue"
                                            @click="this.$refs['popupref4'].openPopup()">
                                        Baan afschermen
                                    </button>
                                </template>
                                <template #popup>
                                    <form method="POST" action="/reserveren/baanafschermen">
                                        @csrf
                                        <div class="flex justify-between">
                                            <div class="w-full">
                                                <div>
                                                    <label>
                                                        Baan:
                                                    </label>
                                                    <select
                                                        v-model="this.$refs['popupref4'].reservation.track"
                                                        @change="this.$refs['popupref4'].update()"
                                                        class="c-form__input-float">
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
                                                    <input
                                                        v-model="this.$refs['popupref4'].reservation.date"
                                                        @change="this.$refs['popupref4'].update()"
                                                        class="c-form__input-float"
                                                        type="date"/>
                                                </div>
                                                <div class="mt-4">
                                                    <label>
                                                        Tijd vanaf:
                                                    </label>
                                                    <select class="c-form__input-float">
                                                        @foreach($times as $time)
                                                            <option>{{ $time }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mt-4">
                                                    <label>
                                                        Tijd tot:
                                                    </label>
                                                    <select class="c-form__input-float">
                                                        @foreach($times as $time)
                                                            <option>{{ $time }}</option>
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
                        </div>
                    @endcan
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
                                    :width="'md:w-10/12 w-full'"
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
                                            <div class="flex flex-col md:flex-row justify-between">
                                                <div class="md:w-5/12 w-full">
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
                                                <div class="md:w-5/12 w-full">
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
                                                    <form method="POST" action="{{ route('reservation.delete') }}">
                                                        @csrf
                                                        <input type="hidden" name="reservation"
                                                               value="{{ $myReservation->id }}"/>
                                                        <input type="submit" value="Verwijderen"
                                                               class="c-button c-button__red cursor-pointer"/>
                                                    </form>
                                                </div>
                                            </div>
                                        </template>
                                    </popup>
                                </form>
                            </div>
                        </div>
                    @else
                        <popup
                            :width="'md:w-10/12 w-full'"
                            ref="popupref3"
                        >
                            <template #openpopup>
                                <button class="c-button c-button__blue"
                                        @click="this.$refs['popupref3'].openPopup({{ json_encode(Auth::user()->name) }})">
                                    Maak een reservering
                                </button>
                            </template>
                            <template #popup="slotprops">
                                <form method="POST" action="/reserveren/create">
                                    @csrf
                                    <div class="flex flex-col md:flex-row justify-between">
                                        <div class="md:w-5/12 w-full">
                                            <div>
                                                <label for="participant1">
                                                    Medespeler 1:
                                                </label>
                                                <input required
                                                       readonly
                                                       name="participant1"
                                                       type="hidden"
                                                       value="{{ Auth::user()->id }}"/>
                                                <input type="text"
                                                       class="c-form__input-float"
                                                       v-model="this.$refs['popupref3'].reservation.participant1"
                                                       readonly/>
                                            </div>
                                            <div class="mt-4">
                                                <label for="participant2">
                                                    Medespeler 2:
                                                </label>
                                                <input
                                                    name="participant2"
                                                    v-model="this.$refs['popupref3'].reservation.participant2"
                                                    type="hidden"
                                                />
                                                <select class="c-form__input-float"
                                                        @change="this.$refs['popupref3'].update()"
                                                        v-model="this.$refs['popupref3'].reservation.participant2"
                                                        id="users2">
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mt-4">
                                                <label for="participant3">
                                                    Medespeler 3:
                                                </label>
                                                <input
                                                    name="participant3"
                                                    v-model="this.$refs['popupref3'].reservation.participant3"
                                                    type="hidden"
                                                />
                                                <select class="c-form__input-float"
                                                        v-model="this.$refs['popupref3'].reservation.participant3"
                                                        @change="this.$refs['popupref3'].update()"
                                                        id="users3">
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="mt-4">
                                                <label for="participant4">
                                                    Medespeler 4:
                                                </label>
                                                <input
                                                    name="participant4"
                                                    v-model="this.$refs['popupref3'].reservation.participant4"
                                                    type="hidden"
                                                />
                                                <select class="c-form__input-float"
                                                        v-model="this.$refs['popupref3'].reservation.participant4"
                                                        @change="this.$refs['popupref3'].update()"
                                                        id="users4">
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}">
                                                            {{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="md:w-5/12 w-full">
                                            <div>
                                                <label>
                                                    Baan:
                                                </label>
                                                <select
                                                    name="track"
                                                    v-model="this.$refs['popupref3'].reservation.track"
                                                    @change="this.$refs['popupref3'].update()"
                                                    class="c-form__input-float">
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
                                                <input
                                                    v-model="this.$refs['popupref3'].reservation.date"
                                                    @change="this.$refs['popupref3'].update()"
                                                    class="c-form__input-float"
                                                    name="date"
                                                    type="date"/>
                                            </div>
                                            <template v-if="Object.keys(slotprops.times).length > 0">
                                                <div class="mt-4">
                                                    <label>
                                                        Tijd:
                                                    </label>
                                                    <select name="time" class="c-form__input-float">
                                                        <option v-for="result in slotprops.times">@{{ result }}</option>
                                                    </select>
                                                </div>
                                            </template>
                                            <template v-if="slotprops.error">
                                                <div class="mt-4">
                                                    <p class="text-red-500">
                                                        @{{ slotprops.error }}
                                                    </p>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                    <input type="submit" value="Aanmaken"
                                           class="c-button c-button__blue cursor-pointer mt-4"
                                    />
                                </form>
                            </template>
                        </popup>
                    @endif
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
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
