<x-mail::message>
# Welkom {{ $data['name'] }},

We hebben zojuist een account voor je aangemaakt op onze website!
Gebruik de volgende gegevens om in te loggen:
<br>
<x-mail::panel>
<b>Email:</b> {{ $data['email'] }}<br>
<b>Wachtwoord:</b> {{ $data['password'] }}
</x-mail::panel>
<x-mail::button :url="$login">
Log in
</x-mail::button>
Met Vriendelijke Groet,<br>
TC Lievelde
</x-mail::message>
