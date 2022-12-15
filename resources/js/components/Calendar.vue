<template>
    <div :id="'calendar'+id"></div>
</template>

<script>
import '@fullcalendar/core/vdom'
import {Calendar} from '@fullcalendar/core';
import dayGridPlugin from "@fullcalendar/daygrid";
import listPlugin from "@fullcalendar/list";
import allLocales from '@fullcalendar/core/locales-all';

export default {
    mounted() {
        const calendarEl = document.getElementById('calendar' + this.id)
        let calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, listPlugin],
            initialView: this.layout,
            events: this.events,
            locales: allLocales,
            locale: 'nl',
            buttonText: {
                today:    'Vandaag',
                month:    'Maand',
                week:     'Week',
                day:      'Dag',
                list:     'Lijst'
            },
            eventTimeFormat: {
                hour: '2-digit',
                minute: '2-digit',
                meridiem: false,
                hour12: false
            }
        })
        calendar.render()
    },

    props: {
        layout: String,
        events: Array,
        id: String
    },
}
</script>
