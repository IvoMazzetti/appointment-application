<script setup>
import { ref } from 'vue';
import SideNarBar from "@/Components/Layout/SideNarBar.vue";
import TopBar from "@/Components/Layout/TopBar.vue";

const showingNavigationDropdown = ref(false);
</script>

<template>
    <div>
        <div class="flex min-h-screen">
            <div class="w-64 bg-white border-r border-gray-200">
                <SideNarBar/>
            </div>

            <div class="flex-1">
                <TopBar/>

                <main class="bg-gray-50 p-10">
                    <slot />
                </main>
            </div>
        </div>
    </div>
</template>

