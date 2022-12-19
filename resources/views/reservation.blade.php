<x-app-layout>
    @section('pageTitle', 'Reserveren')
    @section('content')
        <div class="main-container">
            <h1 class="font-bold">
                Reserveren
            </h1>
            <div class="flex flex-col-reverse lg:flex-row flex-wrap-reverse lg:justify-between mt-4">
                <div class="lg:w-8/12 w-full">
                    <h2>
                        Overzicht alle reserveringen
                    </h2>
                    <calendar
                        :layout="'listWeek'"
                        :events='[
                @foreach($reservations as $reservation)
                    {
                        id: "{!! $reservation->id !!}",
                        title: "{!! $reservation->users[0]->name !!} - Baan: {!! $reservation->track !!}",
                        start: "{!! $reservation->date !!}T{!! $reservation->time !!}"
                    },
                @endforeach
                ]'
                    ></calendar>
                </div>
                <div class="lg:w-3/12 flex flex-col mb-4 md:mb-0">
                    @can('isAdmin')
                        <div class="mb-4">
                            <x-reservation.shield
                                :times="$times"
                            ></x-reservation.shield>
                        </div>
                    @endcan
                    @if($myReservation)
                        @foreach($myReservation->reservation as $reservation)
                            <h2>
                                Uw reservering
                            </h2>
                            <div class="flex flex-col">
                                <p class="font-bold">
                                    Datum: {{ \Carbon\Carbon::parse($reservation->date)->format('d F Y') }} {{ $reservation->time }}
                                    - {{ \Carbon\Carbon::make($reservation->time)->addHour()->format('H:i') }}
                                </p>
                                <p class="font-bold">
                                    Baan: {{ $reservation->track }}
                                </p>
                                @foreach($reservation->users()->get() as $key => $user)
                                    <p>
                                        Medespeler {{ $key+1 }}: {{ $user->name }}
                                    </p>
                                @endforeach
                                <div class="flex">
                                    <x-reservation.update
                                        :reservation="$reservation"
                                        :users="$users"
                                        :myReservation="$myReservation"
                                    ></x-reservation.update>
                                    <x-reservation.delete
                                        :reservation="$reservation"
                                    ></x-reservation.delete>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div>
                            <x-reservation.create
                                :users="$users"
                            ></x-reservation.create>
                        </div>
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
