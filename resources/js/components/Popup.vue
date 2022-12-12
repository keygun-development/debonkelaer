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
                        <slot name="popup"></slot>
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
            open: false
        }
    },

    methods: {
        openPopup: function () {
            this.open = true
        },

        close: function () {
            this.open = false
        },

        update: function() {
            
        }
    }
}
</script>
