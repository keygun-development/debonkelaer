<x-mail::message>
# Hallo {{ $data['name'] }},

Er is zojuist een baan afgeschermd hierdoor is uw reservering overschreven.
Dit zijn de gegevens van de reservering:

<x-mail::panel>
<b>Datum:</b> {{ $data['date'] }}<br>
<b>Tijd:</b> {{ $data['time'] }}<br>
<b>Baan:</b> {{ $data['track'] }}<br>
</x-mail::panel>
Wij verzoeken u om uw reservering aan te passen naar een andere beschikbare tijd.

Met Vriendelijke Groet,<br>
De bonkelaer
</x-mail::message>
