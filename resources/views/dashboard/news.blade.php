@extends('layouts.dashboard')
@section('content')
    <div class="flex justify-between">
        <h1>
            Nieuws
        </h1>
        <a href="/dashboard/nieuws/nieuwepost" class="c-button c-button__blue">
            Nieuwe post
        </a>
    </div>
    <table class="mt-4 w-full">
        @foreach($posts as $post)
            <tr class="border-b">
                <td>
                    {{ $post->id }}
                </td>
                <td>
                    <a class="text-blue-400" href="/dashboard/nieuws/{{ $post->post_slug }}">
                        {{ $post->post_title }}
                    </a>
                </td>
                <td>
                    {{ $post->author->name }}
                </td>
                <td>
                    {{ $post->created_at }}
                </td>
                <td class="py-4">
                    <popup
                        ref="popupref"
                        :width="'w-8/12'"
                    >
                        <template #openpopup>
                            <div class="mt-4">
                                <a @click="this.$refs['popupref'].openPopup()"
                                   class="c-button c-button__red cursor-pointer">
                                    Verwijderen
                                </a>
                            </div>
                        </template>
                        <template #popup>
                            <div class="text-center">
                                <p class="font-bold">
                                    Weet u zeker dat u deze post wilt verwijderen? Hiermee wordt de
                                    post voorgoed verwijderd.
                                </p>
                                <div class="flex justify-center mt-4">
                                    <a @click="this.$refs['popupref'].close()"
                                       class="c-button c-button__grey cursor-pointer mr-4">
                                        Annuleren
                                    </a>
                                    <form method="POST" action="{{ route('news.delete') }}">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $post->id }}"/>
                                        <input type="submit" value="Verwijderen"
                                               class="c-button c-button__red cursor-pointer"/>
                                    </form>
                                </div>
                            </div>
                        </template>
                    </popup>
                </td>
            </tr>
        @endforeach
    </table>
@endsection
