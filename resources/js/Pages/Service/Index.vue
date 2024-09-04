<script setup>
import {ref} from 'vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { PlusIcon } from "@heroicons/vue/outline";
import { defineProps } from 'vue';
import {router, useForm, usePage} from "@inertiajs/vue3";

const props = defineProps({
    isPanelOpen: Boolean,
    services: Array
});

const { errors } = usePage().props;


const togglePanel = () => {
    isPanelOpen.value = !isPanelOpen.value;
};

const form = ref({
    name: '',
    description: '',
    duration: '',
    price: '',
});

const submitForm = () => {
    useForm(form.value)
        .post(route('service.store'), {
            onSuccess: () => {
                form.value = {
                    name: '',
                    description: '',
                    duration: '',
                    price: '',
                    category: ''
                };
                togglePanel();
            },
            onError: (errors) => {
                console.error(errors); // Log validation errors
            }
        });
};

const formattedDuration = (minutes) => {
    const hours = Math.floor(minutes / 60);
    const remainingMinutes = minutes % 60;
    return `${hours > 0 ? `${hours}h ` : ''}${remainingMinutes}m`;
};

const isPanelOpen = ref(false); // Controls the overlay visibility


</script>

<template>
    <AuthenticatedLayout>
                <div class="flex justify-between items-center py-4">
            <div>
                <h1 class="text-2xl font-bold">Services</h1>
                <p class="text-base font-extralight text-gray-400">This is all the services you have</p>
            </div>
            <button
                @click="togglePanel"
                class="flex items-center space-x-2 px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700 transition duration-300"
            >
                <PlusIcon class="w-5 h-5" />
                <span>New Service</span>
            </button>
        </div>

        <!-- Integrate the Overlay component  -->
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <div class="p-4 flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
                <div>
                    <button id="dropdownActionButton" data-dropdown-toggle="dropdownAction" class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                        <span class="sr-only">Action button</span>
                        Action
                        <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                        </svg>
                    </button>
                    <!-- Dropdown menu -->
                    <div id="dropdownAction" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                        <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownActionButton">
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Reward</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Promote</a>
                            </li>
                            <li>
                                <a href="#" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Activate account</a>
                            </li>
                        </ul>
                        <div class="py-1">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete User</a>
                        </div>
                    </div>
                </div>
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </div>
                    <input type="text" id="table-search-users" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for services">
                </div>
            </div>

            <!-- TABLE -->

            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="p-4">
                        <div class="flex items-center">
                            <input id="checkbox-all-search" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-all-search" class="sr-only">checkbox</label>
                        </div>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Time
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Price
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>

                <tr v-for="service in services" :key="service.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="w-4 p-4">
                        <div class="flex items-center">
                            <input id="checkbox-table-search-1" type="checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                            <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                        </div>
                    </td>
                    <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                        <div class="ps-3">
                            <div class="text-base font-semibold">{{ service.name }}</div>
                            <div class="font-normal text-gray-500">{{ service.description }}</div>
                        </div>
                    </th>
                    <td class="px-6 py-4">
                        {{ formattedDuration(service.duration) }}
                    </td>
                    <td class="px-6 py-4">
                        {{ service.price }} €
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Active</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <button type="button" class="focus:outline-none text-white bg-green-600 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Edit</button>
                    </td>
                </tr>
                </tbody>
            </table>


            <!-- OVERLAY AND SIDE FORM -->
            <div v-if="isPanelOpen"
                 @click="togglePanel"
                 class="fixed inset-0 bg-black opacity-50 z-30"
            ></div>

            <div
                class="fixed top-0 right-0 h-full w-[35rem] bg-white shadow-lg transition-transform transform"
                :class="{ 'translate-x-0': isPanelOpen, 'translate-x-full': !isPanelOpen }"
                style="z-index: 40;"
            >
                <div class="p-6">
                    <h2 class="text-xl font-semibold mb-4">Create New Service</h2>
                    <form @submit.prevent="submitForm">
                        <!-- Project Name -->
                        <div class="mb-4">
                            <label for="projectName" class="block text-sm font-medium text-gray-700">Nome do serviço</label>
                            <input
                                type="text"
                                id="projectName"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                v-model="form.name"
                                placeholder="..."
                                required
                            />
                            <span v-if="errors.name">{{ errors.name }}</span>
                        </div>

                        <!-- Project Description -->
                        <div class="mb-4">
                            <label for="projectDescription" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <input
                                type="text"
                                id="projectDescription"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                v-model="form.description"
                                required
                                placeholder="..."
                            />
                            <span v-if="errors.description">{{ errors.description }}</span>
                        </div>

                        <div class="mb-4">
                            <label for="time" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Duração</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <input  v-model="form.duration" type="time" id="duration" class="bg-gray-50 border leading-none border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="00:00" required />
                            </div>
                            <span v-if="errors.duration">{{ errors.duration }}</span>
                        </div>

                        <div class="mb-4">
                            <label for="number-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Preço:</label>
                            <input type="number" id="price" v-model="form.price" aria-describedby="helper-text-explanation" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" value="0" required />
                            <span v-if="errors.price">{{ errors.price }}</span>
                        </div>

                        <button
                            type="submit"
                            class="py-2 px-5 mt-3 rounded-xl text-white bg-blue-600"
                        >
                           Guardar
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>
</template>
