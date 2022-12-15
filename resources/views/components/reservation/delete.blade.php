<form method="POST" action="/reservation/delete" class="ml-4">
    @csrf
    <input type="hidden" value="{{ $reservation->id }}"/>
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
                    Weet u zeker dat u uw reservering wilt verwijderen? Hiermee
                    wordt uw
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
                               value="{{ $reservation->id }}"/>
                        <input type="submit" value="Verwijderen"
                               class="c-button c-button__red cursor-pointer"/>
                    </form>
                </div>
            </div>
        </template>
    </popup>
</form>
