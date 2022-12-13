<template>
    <slot name="disclosure" :active="active"></slot>
    <slot name="menuopen" v-if="active"></slot>
</template>


<script>

export default {
    data() {
        return {
            active: false
        }
    },

    methods: {
        disclose: function () {
            this.active = !this.active
        }
    }
}
</script>
