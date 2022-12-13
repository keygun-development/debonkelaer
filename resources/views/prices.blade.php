<x-app-layout>
    @section('content')
        <div class="main-container">
            <div class="flex justify-between flex-wrap">
                <h1>
                    Tarieven
                </h1>
                @can('isAdmin')
                    <a href="/dashboard/tarieven" class="c-button c-button__blue">
                        Tarieven aanpassen
                    </a>
                @endcan
            </div>
            <div class="my-4">
                <h2>
                    Tarieven seizoen: ({{ \Carbon\Carbon::now()->year }})
                </h2>
                <div class="overflow-x-auto relative mt-4">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <tbody>
                        @foreach($prices as $price)
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row"
                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $price->name }}
                                </th>
                                <td class="py-4 px-6">
                                    €{{ $price->price }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    <p>
                        Aanmelden via <a class="text-blue-400 hover:underline" href="mailto:info@tclievelde.nl">info@TCLievelde.nl</a>
                        Er wordt dan contact met je opgenomen. U kunt het digitale inschrijfformulier hieronder
                        downloaden.
                    </p>
                    <div class="mt-4">
                        <a class="c-button c-button__blue"
                           download
                           href="{{ asset('downloads/Inschrijfformulier_TClievelde2021.docx') }}">
                            Downloaden
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endsection
</x-app-layout>
