@extends('layouts.dashboard')
@section('content')
    <div class="flex justify-between flex-wrap">
        <h1>
            Gebruikers
        </h1>
        <popup
            :width="'md:w-10/12 w-full'"
            ref="popupref2"
        >
            <template #openpopup>
                <a @click="this.$refs['popupref2'].openPopup()"
                   class="c-button c-button__blue cursor-pointer">
                    Nieuwe gebruiker
                </a>
            </template>
            <template #popup>
                <form method="POST" action="{{ route('dashboard.users.new') }}">
                    @csrf
                    <input class="c-form__input-float" type="text" placeholder="Naam gebruiker" name="name"/>
                    <input class="c-form__input-float mt-4" type="email" placeholder="Email gebruiker" name="email"/>
                    <input class="c-form__input-float mt-4" type="number" placeholder="Lidnummer gebruiker"
                           name="membership_id"/>
                    <select class="c-form__input-float mt-4" name="role_id">
                        <option value="1">Admin</option>
                        <option value="2">Gebruiker</option>
                    </select>
                    <input class="c-form__input-float mt-4" type="password" placeholder="Wachtwoord gebruiker"
                           name="password"/>
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
            @foreach($users as $user)
                <tr class="border-b whitespace-nowrap">
                    <td class="px-4">
                        {{ $user->id }}
                    </td>
                    <td class="px-4">
                        <a class="text-blue-400" href="/dashboard/gebruikers/{{ $user->id }}">
                            {{ $user->name }} - {{ $user->membership_id }}
                        </a>
                    </td>
                    <td class="px-4">
                        {{ $user->role()->first()->name }}
                    </td>
                    <td class="p-4">
                        @if($user->active)
                            <popup
                                ref="popupref"
                                :width="'md:w-8/12 w-full'"
                            >
                                <template #openpopup>
                                    <div class="mt-4">
                                        <a @click="this.$refs['popupref'].openPopupDashboard({{ $user->id }})"
                                           class="c-button c-button__red cursor-pointer">
                                            Deactiveren
                                        </a>
                                    </div>
                                </template>
                                <template #popup="slotprops">
                                    <div class="text-center">
                                        <p class="font-bold whitespace-normal">
                                            Weet u zeker dat u deze gebruiker wilt deactiveren?
                                        </p>
                                        <div class="flex md:justify-center items-center flex-col md:flex-row mt-4">
                                            <div>
                                                <a @click="this.$refs['popupref'].close()"
                                                   class="c-button c-button__grey cursor-pointer md:mr-4">
                                                    Annuleren
                                                </a>
                                            </div>
                                            <form class="mt-4 md:mt-0" method="POST" action="{{ route('users.deactivate') }}">
                                                @csrf
                                                <input type="hidden" name="id" v-model="slotprops.id"/>
                                                <input type="submit" value="Deactiveren"
                                                       class="c-button c-button__red cursor-pointer"/>
                                            </form>
                                        </div>
                                    </div>
                                </template>
                            </popup>
                        @else
                            <popup
                                ref="popupref3"
                                :width="'md:w-8/12 w-full'"
                            >
                                <template #openpopup>
                                    <div class="mt-4">
                                        <a @click="this.$refs['popupref3'].openPopupDashboard({{ $user->id }})"
                                           class="c-button c-button__green cursor-pointer">
                                            Activeren
                                        </a>
                                    </div>
                                </template>
                                <template #popup="slotprops">
                                    <div class="text-center">
                                        <p class="font-bold whitespace-normal">
                                            Weet u zeker dat u deze gebruiker wilt activeren?
                                        </p>
                                        <div class="flex md:justify-center items-center flex-col md:flex-row mt-4">
                                            <div>
                                                <a @click="this.$refs['popupref'].close()"
                                                   class="c-button c-button__grey cursor-pointer md:mr-4">
                                                    Annuleren
                                                </a>
                                            </div>
                                            <form method="POST" class="mt-4 md:mt-0" action="{{ route('users.activate') }}">
                                                @csrf
                                                <input type="hidden" name="id" v-model="slotprops.id"/>
                                                <input type="submit" value="Activeren"
                                                       class="c-button c-button__green cursor-pointer"/>
                                            </form>
                                        </div>
                                    </div>
                                </template>
                            </popup>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
@endsection
