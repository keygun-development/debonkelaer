<x-mail::message>
# Hallo {{ $data['name'] }},

Er is zojuist een reservering verwijderd waar u deel aan nam.
Dit zijn de gegevens van de reservering die is verwijderd:

<x-mail::panel>
<b>Datum:</b> {{ $data['date'] }}<br>
<b>Tijd:</b> {{ $data['time'] }}<br>
<b>Baan:</b> {{ $data['track'] }}<br>
</x-mail::panel>
Wilt u weer een nieuwe reservering aanmaken?
<x-mail::button :url="$reserve">
Nieuwe reservering
</x-mail::button>

Met Vriendelijke Groet,<br>
TC Lievelde
</x-mail::message>
