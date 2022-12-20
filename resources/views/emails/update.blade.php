<x-mail::message>
# Hallo {{ $data['name'] }},

Er is zojuist een reservering aangepast waar u deel aan neemt.
Dit zijn de gegevens van de reservering:

<x-mail::panel>
<b>Datum:</b> {{ $data['date'] }}<br>
<b>Tijd:</b> {{ $data['time'] }}<br>
<b>Baan:</b> {{ $data['track'] }}<br>
</x-mail::panel>

Met Vriendelijke Groet,<br>
TC Lievelde
</x-mail::message>
