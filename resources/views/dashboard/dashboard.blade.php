@extends('layouts.dashboard')
@section('pageTitle', 'Dashboard')
@section('content')
    <h1>
        Dashboard
    </h1>
    <div class="mt-4">
        <a class="text-gray-400 hover:underline" href="/">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Terug naar home
        </a>
        <form enctype="multipart/form-data"
              method="POST"
              action="{{ route('registrationform.upload') }}"
              class="mt-4">
            @csrf
            <p class="font-bold mb-4">
                Upload hier een nieuwe versie van het digitale inschrijfformulier.<br>
                Let op! Hiermee wordt de oude versie overschreven dit kan niet teruggezet worden
            </p>
            <input type="file" name="form" accept="application/pdf, application/msword" />
            <input class="c-button c-button__blue cursor-pointer" type="submit" value="Opslaan" />
            <div class="mt-4">
                @if(session('success'))
                    <p class="text-green-400">
                        {{ session('success') }}
                    </p>
                @endif
                @if(session('error'))
                    <p class="text-red-400">
                        {{ session('error') }}
                    </p>
                @endif
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
        </form>
    </div>
@endsection
