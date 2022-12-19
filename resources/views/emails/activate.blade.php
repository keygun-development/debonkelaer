<x-mail::message>
# Hallo {{ $data['name'] }},

We hebben zojuist uw account geactiveerd.
Dit betekend dat u weer kunt inloggen en reserveringen kan maken.<br>

Gebruik het volgende email met bijbehorende wachtwoord om in te loggen:
<br>
<x-mail::panel>
<b>Email:</b> {{ $data['email'] }}<br>
</x-mail::panel>
<x-mail::button :url="$login">
Log in
</x-mail::button>
Bent u uw wachtwoord vergeten? Herstel hem dan via onderstaande link.
<x-mail::button :url="$password">
Wachtwoord herstellen
</x-mail::button>

Met Vriendelijke Groet,<br>
De bonkelaer
</x-mail::message>
