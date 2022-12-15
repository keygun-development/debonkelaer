<popup
    ref="popupref2"
    :width="'md:w-10/12 w-full'"
>
    <template #openpopup>
        <div class="mt-4">
            <a @click="this.$refs['popupref2'].openPopup({{ $reservation->users()->get() }}, {{ json_encode($reservation) }})"
               class="c-button c-button__blue cursor-pointer">
                Aanpassen
            </a>
        </div>
    </template>
    <template #popup="slotprops">
        <form method="POST" action="{{ route('reservation.change') }}">
            @csrf
            <div class="flex flex-col md:flex-row justify-between">
                <div class="md:w-5/12 w-full">
                    <input type="hidden"
                           name="id"
                           v-model="this.$refs['popupref2'].reservation.id"/>
                    <div>
                        <label for="participant1">
                            Medespeler 1:
                        </label>
                        <input type="hidden"
                               name="participant1"
                               value="{{ $reservation->users()->get()[0]->id }}"
                        />
                        <input type="text"
                               class="c-form__input-float"
                               value="{{ $reservation->users()->get()[0]->name }}"
                               readonly
                        />
                    </div>
                    <div>
                        <label for="participant2">
                            Medespeler 2:
                        </label>
                        <input
                            name="participant2"
                            v-model="this.$refs['popupref2'].reservation.participant2"
                            type="hidden"
                        />
                        <select class="c-form__input-float"
                                v-model="this.$refs['popupref2'].reservation.participant2"
                                @change="this.$refs['popupref2'].update()">
                            <option></option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                            @foreach($reservation->users()->get() as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="participant3">
                            Medespeler 3:
                        </label>
                        <input
                            name="participant3"
                            v-model="this.$refs['popupref2'].reservation.participant3"
                            type="hidden"
                        />
                        <select class="c-form__input-float"
                                v-model="this.$refs['popupref2'].reservation.participant3"
                                @change="this.$refs['popupref2'].update()">
                            <option></option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                            @foreach($reservation->users()->get() as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="participant4">
                            Medespeler 4:
                        </label>
                        <input
                            name="participant4"
                            v-model="this.$refs['popupref2'].reservation.participant4"
                            type="hidden"
                        />
                        <select class="c-form__input-float"
                                v-model="this.$refs['popupref2'].reservation.participant4"
                                @change="this.$refs['popupref2'].update()">
                            <option></option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">
                                    {{ $user->name }}
                                </option>
                            @endforeach
                            @foreach($reservation->users()->get() as $user)
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
                            v-model="this.$refs['popupref2'].reservation.track"
                            name="track"
                            class="c-form__input-float"
                            @change="this.$refs['popupref2'].update()">
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
                               name="date"
                               v-model="this.$refs['popupref2'].reservation.date"
                               @change="this.$refs['popupref2'].update()"
                        />
                    </div>
                    <div class="mt-4">
                        <label>
                            Tijd:
                        </label>
                        <select
                            v-model="this.$refs['popupref2'].reservation.time"
                            name="time"
                            class="c-form__input-float">
                            <option v-for="result in slotprops.times">
                                @{{ result }}
                            </option>
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
