<template>
    <slot name="openpopup"></slot>
    <div class="c-popup" v-if="open">
        <div class="c-popup__container">
            <div class="flex items-center justify-center h-full">
                <div class="c-popup__card" :class="width">
                    <div class="flex justify-end">
                        <div @click="close()">
                            <i class="fa-solid fa-xmark text-red-500 font-bold text-3xl cursor-pointer"></i>
                        </div>
                    </div>
                    <div class="scrollbar">
                        <slot :times="times" :error="error" name="popup"></slot>
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
            open: false,
            reservation: {
                participant1: '',
                participant2: '',
                participant3: '',
                participant4: '',
                track: '',
                date: ''
            },
            times: {},
            error: ''
        }
    },

    methods: {
        openPopup: function (data) {
            this.open = true
            if (data) {
                this.reservation.participant1 = data
            }
        },

        close: function () {
            this.open = false
        },

        update: function() {
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
