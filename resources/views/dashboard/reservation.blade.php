@extends('layouts.dashboard')
@section('content')
    <div class="flex justify-between flex-wrap">
        <h1>
            Reserveringen
        </h1>
        <x-reservation.shield
            :times="$times"
        ></x-reservation.shield>
    </div>
    <div class="overflow-x-auto">
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
        <table class="mt-4 w-full">
            @foreach($reservations as $key => $reservation)
                <tr class="border-b whitespace-nowrap">
                    <td class="px-4">
                        {{ $reservation->id }}
                    </td>
                    <td class="px-4">
                        <a class="text-blue-400" href="/dashboard/reserveringen/{{ $reservation->id }}">
                            Reservering {{ $reservation->id }}
                        </a>
                    </td>
                    <td class="px-4">
                        {{ $reservation->date }}
                    </td>
                    <td class="px-4">
                        {{ $reservation->time }}
                    </td>
                    <td class="px-4">
                        {{ $reservation->endtime }}
                    </td>
                    <td class="p-4">
                        <popup
                            ref="popupref"
                            :width="'md:w-8/12 w-full'"
                        >
                            <template #openpopup>
                                <div class="mt-4">
                                    <a @click="this.$refs['popupref'].openPopupDashboard({{ $reservation->id }})"
                                       class="c-button c-button__red cursor-pointer">
                                        Verwijderen
                                    </a>
                                </div>
                            </template>
                            <template #popup="slotprops">
                                <div class="text-center">
                                    <p class="font-bold whitespace-normal">
                                        Weet u zeker dat u deze reservering wilt verwijderen? Hiermee wordt de
                                        reservering voorgoed verwijderd.
                                    </p>
                                    <div class="flex md:justify-center items-center flex-col md:flex-row mt-4">
                                        <div>
                                            <a @click="this.$refs['popupref'].close()"
                                               class="c-button c-button__grey cursor-pointer md:mr-4">
                                                Annuleren
                                            </a>
                                        </div>
                                        <form method="POST" class="mt-4 md:mt-0" action="{{ route('reservations.delete') }}">
                                            @csrf
                                            <input type="hidden" name="id" v-model="slotprops.id"/>
                                            <input type="submit" value="Verwijderen"
                                                   class="c-button c-button__red cursor-pointer"/>
                                        </form>
                                    </div>
                                </div>
                            </template>
                        </popup>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
