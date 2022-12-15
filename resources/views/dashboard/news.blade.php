@extends('layouts.dashboard')
@section('content')
    <div class="flex justify-between flex-wrap">
        <h1>
            Nieuws
        </h1>
        <a href="/dashboard/nieuws/nieuwepost" class="c-button c-button__blue">
            Nieuwe post
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="mt-4 w-full">
            @foreach($posts as $post)
                <tr class="border-b">
                    <td class="whitespace-nowrap px-4">
                        {{ $post->id }}
                    </td>
                    <td class="whitespace-nowrap px-4">
                        <a class="text-blue-400" href="/dashboard/nieuws/{{ $post->post_slug }}">
                            {{ $post->post_title }}
                        </a>
                    </td>
                    <td class="whitespace-nowrap px-4">
                        {{ $post->author->name }}
                    </td>
                    <td class="whitespace-nowrap px-4">
                        {{ $post->created_at }}
                    </td>
                    <td class="p-4 whitespace-nowrap">
                        <popup
                            ref="popupref"
                            :width="'md:w-8/12 w-full'"
                        >
                            <template #openpopup>
                                <div class="mt-4">
                                    <a @click="this.$refs['popupref'].openPopupDashboard({{ $post->id }})"
                                       class="c-button c-button__red cursor-pointer">
                                        Verwijderen
                                    </a>
                                </div>
                            </template>
                            <template #popup="slotprops">
                                <div class="text-center">
                                    <p class="font-bold whitespace-normal">
                                        Weet u zeker dat u deze post wilt verwijderen? Hiermee wordt de
                                        post voorgoed verwijderd.
                                    </p>
                                    <div class="flex md:justify-center items-center flex-col md:flex-row mt-4">
                                        <div>
                                            <a @click="this.$refs['popupref'].close()"
                                               class="c-button c-button__grey cursor-pointer md:mr-4">
                                                Annuleren
                                            </a>
                                        </div>
                                        <form method="POST" class="mt-4 md:mt-0" action="{{ route('news.delete') }}">
                                            @csrf
                                            <input type="hidden" name="id" v-model="slotprops.id"/>
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
    </div>
@endsection
