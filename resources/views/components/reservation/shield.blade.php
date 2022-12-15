<popup
    :width="'md:w-10/12 w-full'"
    ref="popupref3"
>
    <template #openpopup>
        <button class="c-button c-button__blue"
                @click="this.$refs['popupref3'].openPopup()">
            Baan afschermen
        </button>
    </template>
    <template #popup>
        <form method="POST" action="/dashboard/reserveringen/new">
            @csrf
            <div class="flex justify-between">
                <div class="w-full">
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
                            name="date"
                            v-model="this.$refs['popupref3'].reservation.date"
                            @change="this.$refs['popupref3'].update()"
                            class="c-form__input-float"
                            type="date"/>
                    </div>
                    <div class="mt-4">
                        <label>
                            Tijd vanaf:
                        </label>
                        <select
                            name="timestart"
                            class="c-form__input-float">
                            @foreach($times as $time)
                                <option>{{ $time }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mt-4">
                        <label>
                            Tijd tot:
                        </label>
                        <select
                            name="timeend"
                            class="c-form__input-float">
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
