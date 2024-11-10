<template>

    <div class="relative 2xl:container 2xl:mx-auto">
        <div class="relative  py-0 -z-0">
            <swiper
                :autoplay="{ delay: 3500, disableOnInteraction: false, }"
                :breakpoints="breakPoints"
                :pagination="{ dynamicBullets: true }"
                :navigation="{ nextEl: `.${forward}`, prevEl: `.${backward}`, }"
                :effect="'coverflow'"
                :grabCursor="true"
                :centeredSlides="true"
                :slidesPerView="'auto'"
                :coverflowEffect="{ rotate: 0, stretch: -40, depth: 200, modifier: 1, slideShadows : true }"
                :loop="true"
                :modules="modules"
                class="padding-right-8 mySwiper">

                <swiper-slide v-for="(item, index) in slidersOptions" :key="index" class="rounded-sm">
                    <a :href="item.link" :target="item.target?'_blank':'_self'">
                        <img :alt="`banner-image-${index}`"
                             :src="item.image"
                             class="rounded-lg bg-primary border-primary border-4"
                             height="300"
                             width="500"/>
                    </a>
                </swiper-slide>
            </swiper>

        </div>
        <button aria-label="backward" name="backward"
                :class="backward"
                class="hidden md:block absolute inset-y-0 left-0 rotate-180  disabled:hidden">
            <div class="bg-white p-3 shadow flex justify-center items-center rounded-full">
                <ChevronDoubleRightIcon class="h-4 w-4 text-primary"/>
            </div>
        </button>
        <button aria-label="forward" name="forward"
                :class="forward"
                class="hidden md:block absolute inset-y-0 right-0 disabled:hidden">
            <div class="bg-white p-3 shadow flex justify-center items-center rounded-full">
                <ChevronDoubleRightIcon class="h-4 w-4 text-primary"/>
            </div>
        </button>
    </div>


</template>

<script setup>
import {Swiper, SwiperSlide} from "swiper/vue";
import SwiperCore, {Autoplay, Navigation, Pagination, EffectCoverflow} from "swiper";
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/pagination';
import 'swiper/css/scrollbar';
import {ChevronDoubleRightIcon} from "@heroicons/vue/20/solid/index.js";

SwiperCore.use([Autoplay, Navigation, Pagination, EffectCoverflow]);

const breakPoints = {
    '0': {slidesPerView: 1, spaceBetween: 10,},
    '768': {slidesPerView: 2, spaceBetween: 10,},
    '786': {slidesPerView: 3, spaceBetween: 10,},
};
const modules = [EffectCoverflow, Pagination];
const ids = Math.floor(Math.random() * 100);
const forward = `forward${ids}`;
const backward = `backward${ids}`;
const slidersOptions = [
    {
        link: '#',
        target: false,
        image: 'https://picsum.photos/id/237/200/300'
    },
    {
        link: '#',
        target: false,
        image: 'https://picsum.photos/seed/picsum/200/300'
    },
    {
        link: '#',
        target: false,
        image: 'https://picsum.photos/id/237/200/300'
    },
    {
        link: '#',
        target: false,
        image: 'https://picsum.photos/seed/picsum/200/300'
    }
]
</script>
