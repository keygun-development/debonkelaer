@extends('layouts.dashboard')
@section('content')
    <form class="mt-4" method="POST" action="{{ route('dashboard.users.update') }}">
        @csrf
        <div class="flex flex-col md:flex-row justify-between">
            <div class="w-full">
                <input type="hidden"
                       name="id"
                       value="{{ $user->id }}"
                />
                <div>
                    <h2>
                        Naam:
                    </h2>
                    <input type="text"
                           name="name"
                           class="c-form__input-float text-lg font-bold mt-4"
                           value="{{ $user->name }}"
                    />
                </div>
                <div class="mt-4">
                    <h2>
                        Email:
                    </h2>
                    <input type="email"
                           name="email"
                           class="c-form__input-float text-lg font-bold mt-4"
                           value="{{ $user->email }}"
                    />
                </div>
                <div class="mt-4">
                    <h2>
                        Lidnummer:
                    </h2>
                    <input type="number"
                           name="membership_id"
                           class="c-form__input-float text-lg font-bold mt-4"
                           value="{{ $user->membership_id }}"
                    />
                </div>
                <div class="mt-4">
                    <h2>
                        Rol:
                    </h2>
                    <select class="c-form__input-float text-lg font-bold mt-4" name="role_id" class="mt-4">
                        <option {{ $user->role_id === 1 ? 'selected' : '' }} value="1">Admin</option>
                        <option {{ $user->role_id === 2 ? 'selected' : '' }} value="2">Gebruiker</option>
                    </select>
                </div>
            </div>
        </div>
        <input type="submit" value="Opslaan"
               class="c-button c-button__blue cursor-pointer mt-4"
        />
    </form>
@endsection
