@if ($paginator->hasPages())
    <nav class="flex justify-between my-4">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="relative inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                Vorige pagina
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="relative inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 active:bg-gray-100 active:text-gray-800 transition ease-in-out duration-150">
                Vorige pagina
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="relative inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:text-gray-500 focus:z-10 focus:outline-none focus:border-blue-300 active:bg-gray-100 active:text-gray-800 transition ease-in-out duration-150">
                Volgende pagina
            </a>
        @else
            <span class="relative inline-flex items-center px-4 py-2 rounded-md text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5">
                Volgende pagina
            </span>
        @endif
    </nav>
@endif
