@extends('layouts.dashboard')
@section('content')
    <div class="flex justify-between flex-wrap">
        <h1>
            Impressies
        </h1>
        <popup
            :width="'md:w-10/12 w-full'"
            ref="popupref2"
        >
            <template #openpopup>
                <a @click="this.$refs['popupref2'].openPopup()"
                   class="c-button c-button__blue cursor-pointer">
                    Nieuwe impressie
                </a>
            </template>
            <template #popup>
                <form enctype="multipart/form-data" method="POST" action="{{ route('dashboard.impressions.new') }}">
                    @csrf
                    <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp"/>
                    <input class="c-button c-button__blue cursor-pointer mt-4" type="submit" value="Opslaan"/>
                </form>
            </template>
        </popup>
    </div>
    <div class="overflow-x-auto">
        <table class="mt-4 w-full">
            @foreach($impressions as $impression)
                <tr class="border-b whitespace-nowrap">
                    <td class="px-4">
                        {{ $impression->id }}
                    </td>
                    <td class="h-[100px] w-[100px]">
                        <img src="{{ asset($impression->image) }}" alt="{{ $impression->image }}"/>
                    </td>
                    <td class="p-4">
                        <popup
                            ref="popupref"
                            :width="'md:w-8/12 w-full'"
                        >
                            <template #openpopup>
                                <div class="mt-4">
                                    <a @click="this.$refs['popupref'].openPopupDashboard({{ $impression->id }})"
                                       class="c-button c-button__red cursor-pointer">
                                        Verwijderen
                                    </a>
                                </div>
                            </template>
                            <template #popup="slotprops">
                                <div class="text-center">
                                    <p class="font-bold whitespace-normal">
                                        Weet u zeker dat u deze foto wilt verwijderen? Hiermee wordt de
                                        foto voorgoed verwijderd.
                                    </p>
                                    <div class="flex md:justify-center items-center flex-col md:flex-row mt-4">
                                        <div>
                                            <a @click="this.$refs['popupref'].close()"
                                               class="c-button c-button__grey cursor-pointer md:mr-4">
                                                Annuleren
                                            </a>
                                        </div>
                                        <form method="POST" class="mt-4 md:mt-0" action="{{ route('impressions.delete') }}">
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
