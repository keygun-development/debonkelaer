@extends('layouts.dashboard')
@section('content')
    <div class="flex justify-between flex-wrap">
        <h1>
            Reglementen
        </h1>
        <popup
            :width="'md:w-10/12 w-full'"
            ref="popupref2"
        >
            <template #openpopup>
                <a @click="this.$refs['popupref2'].openPopup()"
                   class="c-button c-button__blue cursor-pointer">
                    Nieuwe regel
                </a>
            </template>
            <template #popup>
                <form method="POST" action="{{ route('dashboard.regulations.new') }}">
                    @csrf
                    <input class="c-form__input-float" type="text" placeholder="Regel" name="name"/>
                    <editor></editor>
                    <input class="c-button c-button__blue cursor-pointer mt-4" type="submit" value="Opslaan"/>
                </form>
            </template>
        </popup>
    </div>
    <div class="overflow-x-auto">
        <table class="mt-4 w-full">
            @foreach($regulations as $regulation)
                <tr class="border-b">
                    <td class="px-4 whitespace-nowrap">
                        {{ $regulation->id }}
                    </td>
                    <td class="px-4 whitespace-nowrap">
                        <a class="text-blue-400" href="/dashboard/reglementen/{{ $regulation->id }}">
                            {{ $regulation->name }}
                        </a>
                    </td>
                    <td class="line-clamp-3 max-w-[100px] flex flex-wrap px-4">
                        {!! $regulation->description !!}
                    </td>
                    <td class="p-4">
                        <popup
                            ref="popupref"
                            :width="'md:w-8/12 w-full'"
                        >
                            <template #openpopup>
                                <div class="mt-4">
                                    <a @click="this.$refs['popupref'].openPopupDashboard({{ $regulation->id }})"
                                       class="c-button c-button__red cursor-pointer">
                                        Verwijderen
                                    </a>
                                </div>
                            </template>
                            <template #popup="slotprops">
                                <div class="text-center">
                                    <p class="font-bold">
                                        Weet u zeker dat u deze regel wilt verwijderen? Hiermee wordt de
                                        regel voorgoed verwijderd.
                                    </p>
                                    <div class="flex md:justify-center items-center flex-col md:flex-row mt-4">
                                        <div>
                                            <a @click="this.$refs['popupref'].close()"
                                               class="c-button c-button__grey cursor-pointer md:mr-4">
                                                Annuleren
                                            </a>
                                        </div>
                                        <form method="POST" class="mt-4 md:mt-0" action="{{ route('regulations.delete') }}">
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
