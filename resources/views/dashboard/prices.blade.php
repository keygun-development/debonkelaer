@extends('layouts.dashboard')
@section('content')
    <div class="flex justify-between">
        <h1>
            Tarieven
        </h1>
        <popup
            :width="'w-10/12'"
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
    <div class="mt-4 overflow-scroll max-h-[80%]">
        <table class="w-full">
            @foreach($prices as $price)
                <tr class="border-b">
                    <td>
                        {{ $price->id }}
                    </td>
                    <td>
                        <a class="text-blue-400" href="/dashboard/tarieven/{{ $price->id }}">
                            {{ $price->name }}
                        </a>
                    </td>
                    <td>
                        {{ $price->price }}
                    </td>
                    <td class="py-4">
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
                                        Weet u zeker dat u deze post wilt verwijderen? Hiermee wordt de
                                        post voorgoed verwijderd.
                                    </p>
                                    <div class="flex justify-center mt-4">
                                        <a @click="this.$refs['popupref'].close()"
                                           class="c-button c-button__grey cursor-pointer mr-4">
                                            Annuleren
                                        </a>
                                        <form method="POST" action="{{ route('prices.delete') }}">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $price->id }}"/>
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
