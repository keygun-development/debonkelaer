@extends('layouts.dashboard')
@section('content')
    <div class="flex justify-between flex-wrap">
        <h1>
            Tarieven
        </h1>
        <popup
            :width="'md:w-10/12 w-full'"
            ref="popupref2"
        >
            <template #openpopup>
                <a @click="this.$refs['popupref2'].openPopup()"
                   class="c-button c-button__blue cursor-pointer">
                    Nieuw tarief
                </a>
            </template>
            <template #popup>
                <form method="POST" action="{{ route('dashboard.prices.new') }}">
                    @csrf
                    <input class="c-form__input-float" type="text" placeholder="Tarief naam" name="name"/>
                    <input class="c-form__input-float mt-4" type="text" placeholder="Tarief prijs" name="price"/>
                    <input class="c-button c-button__blue cursor-pointer mt-4" type="submit" value="Opslaan"/>
                </form>
            </template>
        </popup>
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
            @foreach($prices as $price)
                <tr class="border-b whitespace-nowrap">
                    <td class="px-4">
                        {{ $price->id }}
                    </td>
                    <td class="px-4">
                        <a class="text-blue-400" href="/dashboard/tarieven/{{ $price->id }}">
                            {{ $price->name }}
                        </a>
                    </td>
                    <td class="px-4">
                        {{ $price->price }}
                    </td>
                    <td class="p-4">
                        <popup
                            ref="popupref"
                            :width="'md:w-8/12 w-full'"
                        >
                            <template #openpopup>
                                <div class="mt-4">
                                    <a @click="this.$refs['popupref'].openPopupDashboard({{ $price->id }})"
                                       class="c-button c-button__red cursor-pointer">
                                        Verwijderen
                                    </a>
                                </div>
                            </template>
                            <template #popup="slotprops">
                                <div class="text-center">
                                    <p class="font-bold whitespace-normal">
                                        Weet u zeker dat u deze prijs wilt verwijderen? Hiermee wordt de
                                        prijs voorgoed verwijderd.
                                    </p>
                                    <div class="flex md:justify-center items-center flex-col md:flex-row mt-4">
                                        <div>
                                            <a @click="this.$refs['popupref'].close()"
                                               class="c-button c-button__grey cursor-pointer md:mr-4">
                                                Annuleren
                                            </a>
                                        </div>
                                        <form method="POST" class="mt-4 md:mt-0" action="{{ route('prices.delete') }}">
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
