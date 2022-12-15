<template>
    <slot name="openpopup"></slot>
    <div class="c-popup" v-if="open">
        <div class="c-popup__container">
            <div class="flex items-center justify-center h-full overflow-y-auto">
                <div class="c-popup__card" :class="width">
                    <div class="flex justify-end">
                        <div @click="close()">
                            <i class="fa-solid fa-xmark text-red-500 font-bold text-3xl cursor-pointer"></i>
                        </div>
                    </div>
                    <div class="scrollbar">
                        <slot :times="times" :error="error" :id="id" name="popup"></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {

    mounted() {
        this.open = this.startOpen ?? false
    },

    props: {
        width: String,
        startOpen: Boolean
    },

    data() {
        return {
            id: 0,
            open: false,
            reservation: {
                id: 0,
                participant1: '',
                participant2: 'peo2',
                participant3: 'peo3',
                participant4: 'peo4',
                track: '',
                date: '',
                time: ''
            },
            times: {},
            error: ''
        }
    },

    methods: {
        openPopup: function (data, additionals = null) {
            this.open = true
            if (Array.isArray(data)) {
                this.reservation.participant1 = data[0].id
                if (typeof data[1] !== 'undefined') this.reservation.participant2 = data[1].id
                if (typeof data[2] !== 'undefined') this.reservation.participant3 = data[2].id
                if (typeof data[3] !== 'undefined') this.reservation.participant4 = data[3].id
                if (additionals) {
                    this.reservation.track = additionals.track
                    this.reservation.date = additionals.date
                    this.reservation.time = additionals.time
                    this.times = [additionals.time]
                    this.reservation.id = additionals.id
                    this.update()
                }
            } else {
                this.reservation.participant1 = data
            }
        },

        openPopupDashboard: function (id) {
            this.open = true
            this.id = id
        },

        close: function () {
            this.open = false
        },

        update: function () {
            axios.get('/api/reservation/availability', {
                params: {
                    reservation: this.reservation
                }
            })
                .then(response => {
                    this.times = response.data
                })
                .catch(err => {
                    console.log(err.response.data)
                    this.error = err.response.data
                })
        }
    }
}
</script>
