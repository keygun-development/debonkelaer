import './bootstrap';
import {createApp} from "vue/dist/vue.esm-bundler";
import Swiper from "./components/Swiper.vue";
import Popup from "./components/Popup.vue";
import Calendar from "./components/Calendar.vue";
import '../css/app.scss';
import './font-awesome';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

createApp({})
    .component('SwiperInit', Swiper)
    .component('Popup', Popup)
    .component('Calendar', Calendar)
    .mount('#app')
