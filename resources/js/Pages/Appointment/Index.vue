<template>
    <div class="p-4 md:p-6 min-h-screen bg-gradient flex flex-col md:flex-row items-center justify-center">
        <div class="bg-white min-h-[32rem] w-full md:w-[56rem] rounded-lg shadow-lg p-4 md:p-6 flex flex-col md:flex-row"
             :class="{ 'min-w-[74rem]': selectedDay }">
            <!-- Left Column (Visible on mobile and desktop) -->
            <div class="flex flex-col w-full md:max-w-[25rem] pr-0 md:pr-4  md:border-r border-gray-200">
                <a href="/">
                    <ApplicationLogo class="w-full h-9"/>
                </a>
                <h1 class="text-md font-extrabold text-gray-500 my-2">Estética da Ana</h1>
                <h1 class="text-2xl md:text-3xl font-bold text-black mb-4">{{ selectedServiceName || 'Selecione um Serviço' }}</h1>
                <div class="flex items-center text-gray-600">
                    <ClockIcon class="h-5 w-5 text-gray-500 mr-2"/>
                    <span class="text-gray-500 font-semibold">{{ selectedServiceDuration || '30 min' }}</span>
                </div>
                <p class="mt-6 font-extralight text-sm md:text-[0.9rem] leading-6 mb-4">
                    {{ selectedServiceDescription || 'Selecione um Serviço' }}
                </p>
            </div>

            <!-- Right Column (Visible on larger devices, adjustable on mobile) -->
            <div class="flex flex-col w-full md:w-1/2 md:pl-4 mt-6 md:mt-0">
                <!-- Dropdown -->
                <div ref="dropdown" class="relative mb-4 md:mb-6">
                    <div @click="toggleDropdown" class="border-2 px-4 py-2 rounded-lg flex justify-between items-center cursor-pointer">
                        <span>{{ selectedServiceName || 'Selecione um Serviço' }}</span>
                        <svg class="w-4 h-4 transform transition-transform duration-300" :class="{ 'rotate-180': isDropdownOpen }" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </div>
                    <div v-if="isDropdownOpen" class="absolute left-0 right-0 mt-2 bg-white border rounded-lg shadow-lg z-10">
                        <ul class="py-2">
                            <li v-for="service in services" :key="service.name" @click="selectService(service)" class="px-4 py-2 hover:bg-gray-100 cursor-pointer">
                                {{ service.name }} - {{ formattedDuration(service.duration) }}
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Calendar Component -->
                <Calendar @update:selectedDay="handleSelectedDay"/>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { ClockIcon } from '@heroicons/vue/outline';
import Calendar from '@/Pages/Appointment/Calendar.vue';
import ApplicationLogo from "@/Components/ApplicationLogo.vue";
import axios from "axios";

const isDropdownOpen = ref(false);
const selectedService = ref(null);
const selectedDay = ref(null);
const services = ref([]);
const dropdown = ref(null);

// Fetching services data on component mount
onMounted(async () => {
    try {
        const response = await axios.get('/api/calendar/services');
        services.value = response.data;
    } catch (error) {
        console.error('Error fetching service data:', error);
    }
});

// Computed properties
const selectedServiceName = computed(() => selectedService.value?.name || '');
const selectedServiceDuration = computed(() => selectedService.value ? formattedDuration(selectedService.value.duration) : '');
const selectedServiceDescription = computed(() => selectedService.value?.description || '')

// Methods
const toggleDropdown = () => {
    isDropdownOpen.value = !isDropdownOpen.value;
};

const selectService = (service) => {
    selectedService.value = service;
    isDropdownOpen.value = false;
};

const formattedDuration = (minutes) => {
    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;
    return `${hours ? `${hours}h` : ''}${mins ? ` ${mins}m` : ''}`.trim();
};

const handleSelectedDay = (day) => {
    selectedDay.value = day;
}

// Close dropdown when clicking outside
const handleClickOutside = (event) => {
    if (dropdown.value && !dropdown.value.contains(event.target)) {
        isDropdownOpen.value = false;
    }
};

// Attach click outside event listener
onMounted(() => {
    document.addEventListener('click', handleClickOutside);
});

</script>

<style scoped>
.bg-gradient {
    background-image: linear-gradient(120deg, #f6d365 0%, #fda085 100%);
}
</style>
