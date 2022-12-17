<popup
    :width="'md:w-10/12 w-full'"
    ref="popupref"
>
    <template #openpopup>
        <button class="c-button c-button__blue"
                @click="this.$refs['popupref'].openPopup({{ json_encode(Auth::id()) }})">
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
                               value="{{ Auth::id() }}"/>
                        <input type="text"
                               class="c-form__input-float"
                               value="{{ Auth::user()->name }}"
                               readonly/>
                    </div>
                    <div class="mt-4">
                        <label for="participant2">
                            Medespeler 2:
                        </label>
                        <input
                            name="participant2"
                            v-model="this.$refs['popupref'].reservation.participant2"
                            type="hidden"
                        />
                        <select class="c-form__input-float"
                                @change="this.$refs['popupref'].update()"
                                v-model="this.$refs['popupref'].reservation.participant2"
                                id="users2">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} - {{ $user->membership_id }}
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
                            v-model="this.$refs['popupref'].reservation.participant3"
                            type="hidden"
                        />
                        <select class="c-form__input-float"
                                v-model="this.$refs['popupref'].reservation.participant3"
                                @change="this.$refs['popupref'].update()"
                                id="users3">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} - {{ $user->membership_id }}
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
                            v-model="this.$refs['popupref'].reservation.participant4"
                            type="hidden"
                        />
                        <select class="c-form__input-float"
                                v-model="this.$refs['popupref'].reservation.participant4"
                                @change="this.$refs['popupref'].update()"
                                id="users4">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }} - {{ $user->membership_id }}
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
                            v-model="this.$refs['popupref'].reservation.track"
                            @change="this.$refs['popupref'].update()"
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
                            v-model="this.$refs['popupref'].reservation.date"
                            @change="this.$refs['popupref'].update()"
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
                                <option v-for="result in slotprops.times">
                                    @{{ result }}
                                </option>
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
