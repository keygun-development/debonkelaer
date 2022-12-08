<template>
    <swiper
        :modules="modules"
        :slides-per-view="1"
        :space-between="50"
        navigation
        :breakpoints="breakpoints"
        :autoplay='{
            "delay": 3000
        }'
        loop
        @swiper="onSwiper"
        @slideChange="onSlideChange"
    >
        <swiper-slide v-for="slide in slides">
            <img :src="slide.image" :alt="slide.image" />
        </swiper-slide>
    </swiper>
</template>

<script>

import { Navigation, Autoplay } from 'swiper';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/navigation';

export default {
    data() {
        return {
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    autoplay: true
                }
            },
            slides: {}
        }
    },


    async mounted() {
        await axios.get('/api/impressions/all')
            .then(response => {
                this.slides = response.data
            })
    },

    components: {
        Swiper,
        SwiperSlide
    },

    setup() {
        const onSwiper = (swiper) => {
        };
        const onSlideChange = () => {
        };
        return {
            onSwiper,
            onSlideChange,
            modules: [Navigation, Autoplay]
        };
    },
}

</script>
