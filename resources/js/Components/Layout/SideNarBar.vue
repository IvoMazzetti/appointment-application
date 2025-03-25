<script setup>

</script>

<template>
  <div class="py-4 px-6">
    <a href="/">
      <ApplicationLogo class="w-full h-9"/>
    </a>
  </div>
  <div class="mb-10">
    <h3 class="mx-6 mb-2 text-xs text-gray-400 uppercase tracking-widest">
      Main
    </h3>

    <a v-for="(item, index) in mainNavigation"
       :href="item.href" :key="index" class="flex items-center px-6 py-2.5 text-gray-500 hover:text-green-600 group">
      <component
          :is="item.icon"
          class="h-5 w-5 text-gray-400 mr-2 group-hover:text-green-500"/>
      {{ item.label }}
    </a>
  </div>
  <div class="mb-10">
    <h3 class="mx-6 mb-2 text-xs text-gray-400 uppercase tracking-widest">
      Library
    </h3>

    <a v-for="(item, index) in libraryNavigation"
       :href="item.href" :key="index" class="flex items-center px-6 py-2.5 text-gray-500 hover:text-green-600 group">
      <component
          :is="item.icon"
          class="h-5 w-5 text-gray-400 mr-2 group-hover:text-green-500"/>
      {{ item.label }}
    </a>
  </div>
</template>

<script>
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue';
import {
  CalendarIcon,
  ChatIcon,
  ClipboardListIcon,
  BriefcaseIcon,
  ClockIcon,
  HeartIcon,
  HomeIcon,
  SearchIcon
} from "@heroicons/vue/outline";
import ApplicationLogo from "@/Components/ApplicationLogo.vue";

export default {
  components: {ChatIcon, HeartIcon, HomeIcon, Menu, MenuButton, MenuItems, MenuItem, SearchIcon, ApplicationLogo},
  data() {
    return {
      mainNavigation: [
        {href: '/', label: 'Home', icon: HomeIcon},
        {href: '/appointments', label: 'Appointments', icon: CalendarIcon},
        {href: '/services', label: 'Services', icon: BriefcaseIcon},
      ],
      libraryNavigation: [
        {href: '/', label: 'Favorites', icon: HeartIcon},
        {href: '/', label: 'Watch later', icon: ClockIcon},
        {href: '/', label: 'History', icon: ClipboardListIcon},
        {href: '/', label: 'Scheduled', icon: CalendarIcon},
      ],
      following: [
        {
          href: '/',
          label: 'Constantin Druc',
          imageUrl: 'https://pbs.twimg.com/profile_images/1333896976602193922/MtWztkxt_400x400.jpg'
        },
      ],
    };
  },
};
</script>
