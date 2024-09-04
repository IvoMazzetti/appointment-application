<script setup>

</script>

<template>
    <div class="flex justify-between py-3 px-6 bg-white
                 border-b space-x-6"
    >
        <form action="" class="w-full max-w-md">
            <div class="relative flex items-center text-gray-400 focus-within:text-gray-600">
                <SearchIcon class="w-5 h-5 absolute ml-3 pointer-events-none"/>
                <input
                    type="text"
                    name="search"
                    placeholder="Search talk"
                    autocomplete="off"
                    aria-label="Search talk"
                    class="w-full pr-3 pl-10 py-2 font-semibold placeholder-gray-500 text-black rounded-2xl border-none ring-2 ring-gray-300 focus:ring-gray-500 focus:ring-2"
                >
            </div>
        </form>
        <Menu as="div" class="relative flex-shrink-0">
            <MenuButton class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-black">
                <img class="inline w-10 h-10 rounded-full" src="https://pbs.twimg.com/profile_images/1333896976602193922/MtWztkxt_400x400.jpg" alt="">
            </MenuButton>

            <transition
                enter-active-class="transition duration-100 ease-out transform"
                enter-from-class="opacity-0 scale-90"
                enter-to-class="opacity-100 scale-100"
                leave-active-class="transition duration-100 ease-in transform"
                leave-from-class="opacity-100 scale-100"
                leave-to-class="opacity-0 scale-90"
            >
                <MenuItems class="overflow-hidden absolute right-0 mt-2 w-48 bg-white rounded-md border shadow-lg origin-top-right focus:outline-none">
                    <MenuItem v-slot="{active}">
                        <a href="#" :class="{'bg-gray-100': active}" class="block py-2 px-4 text-sm text-gray-700">My Profile</a>
                    </MenuItem>
                    <MenuItem v-slot="{active, disabled}" disabled>
                        <a href="#" :class="{'bg-gray-100': active, 'opacity-40': disabled}" class="block py-2 px-4 text-sm text-gray-700">Settings</a>
                    </MenuItem>
                    <MenuItem v-slot="{active}">
                        <a href="#" :class="{'bg-gray-100': active}" class="block py-2 px-4 text-sm text-gray-700">Help</a>
                    </MenuItem>
                    <MenuItem v-slot="{active}">
                        <a href="#" :class="{'bg-gray-100': active}" class="block py-2 px-4 text-sm text-gray-700">Log out</a>
                    </MenuItem>
                </MenuItems>
            </transition>
        </Menu>
    </div>
</template>

<script>
import {Menu, MenuButton, MenuItem, MenuItems} from '@headlessui/vue';
import {
    SearchIcon
} from "@heroicons/vue/outline";

export default {
    components: {Menu, MenuButton, MenuItems, MenuItem, SearchIcon},

};
</script>
