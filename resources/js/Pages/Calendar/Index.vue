<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import {useForm, usePage} from '@inertiajs/vue3';

const isPanelOpen = ref(false);
const services = ref(null);
const timeSlots = ref([]);
const showTimeSlots = ref(false); // To control the visibility of time slots
const formDay = ref(null); // Ref to access the input field

const togglePanel = () => {
    isPanelOpen.value = !isPanelOpen.value;
};

const { errors } = usePage().props;

const form = ref({
    service: null,
    name: '',
    phone: null,
    email: '',
    notes: '',
    day: '',
    time: '',
    price: '',
});

onMounted(async () => {
    try {
        // Execute API call for services
        const servicesResponse = await axios.get('/api/calendar/services');
        services.value = servicesResponse.data;
    } catch (error) {
        console.error('Error fetching services:', error.response?.data || error.message);
    }
});

const fetchAvailableSlots = async () => {
    if (!formDay.value) {
        console.error('Date is required');
        return;
    }
    // Get the value of the input field using formDay.value.value
    let selectedDay = formDay.value.value;
    if (!selectedDay) {
        console.error('Date is required');
        return;
    }



    try {
        const response = await axios.get('/calendar/time', {
            params: { date: selectedDay }
        });
        form.value.day = selectedDay;
        timeSlots.value = response.data;
        showTimeSlots.value = true;
        console.log(form.value);d
    } catch (error) {
        console.error('Error fetching available slots:', error);
    }
};

const submitForm = () => {
    console.log(form);
    useForm(form.value)
        .post(route('service.store'), {
            onSuccess: () => {
                form.value = {
                    service: null,
                    name: '',
                    phone: null,
                    email: '',
                    notes: '',
                    day: '',
                    time: '',
                    price: '',
                };
                togglePanel();
            },
            onError: (errors) => {
                console.error(errors); // Log validation errors
            }
        });
};
</script>



<template>
    <AuthenticatedLayout>
        <div class="p-4 bg-white shadow-md rounded-lg border max-h-screen overflow-hidden relative">
            <div class="flex justify-between items-center mb-4">
                <div class="block">
                    <h2 class="text-lg font-bold">{{ calendarData.monthName }}</h2>
                    <p class="text-sm text-gray-600">{{ calendarData.weekRange }}</p>
                </div>
                <button @click="togglePanel" class="bg-blue-500 text-white px-4 py-1 rounded-md shadow-md">
                    Criar Marcação
                </button>
            </div>


            <div class="overflow-auto h-full relative">
                <div class="grid grid-cols-[80px_repeat(7,_1fr)]  grid-rows-[auto_repeat(12,_1fr)]  h-full relative">
                    <!-- GMT+1 Column -->
                    <div class="rounded-tl-lg border p-3 text-xs flex items-center justify-center">
                        <h3 class="font-bold text-gray-400">GMT+1</h3>
                    </div>

                    <!-- Header Row: Weekdays with Day Numbers -->
                    <div v-for="(day, index) in calendarData.days" :key="index" :class="[
            'border p-3 text-sm flex items-center justify-center',
            {
              'rounded-tr-lg': index === calendarData.days.length - 1,
              'text-blue-500 font-bold': day.isToday,
              'text-gray-400': !day.isToday
            }
          ]">
                        <div>
                            <span class="mr-2">{{ day.name }}</span>
                            <span :class="[
                                'text-md',
                                day.isToday ? 'text-blue-500' : 'text-black'
                              ]">
                            {{ day.numberDay }}
                          </span>
                        </div>
                    </div>

                    <!-- Loop through each hour to create a row -->
                    <template v-for="hour in hours" :key="hour">
                        <div
                            class="border  p-1 text-center text-xs no-border-first flex items-center justify-center h-14">
                            <span class="text-gray-400">{{ hour }}</span>
                        </div>

                        <!-- Day Columns with Events -->
                        <div v-for="(day, dayIndex) in calendarData.days" :key="dayIndex" :class="[
                              'border p-1 text-xs bg-gray-50',
                              {
                                'rounded-tr-lg': dayIndex === calendarData.days.length - 1 && hour === '19:00'
                              }
                            ]" :id="`cell-${day.date}-${hour}`"
                        >
                            <div class="h-full flex   relative">
                                <div v-for="event in getEvents(day.date, hour)" :key="event.id" class="flex text-white"
                                     :id="`event-${event.id}`"
                                     :style="getEventStyle(event)"
                                >
                                    <span class="mt-1 ml-2"> {{ event.name }}</span>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>

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
                <h2 class="text-xl font-semibold mb-4">Criar nova marcação</h2>
                <form @submit.prevent="submitForm">
                    <!-- Project Name -->
                    <div class="mb-4">
                        <label for="service" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Escolha
                            um serviço</label>
                        <select
                            required
                            v-model="form.service"
                            id="service"
                            name="service"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        >
                            <option value="" disabled selected>Escolha um serviço</option>
                            <option v-for="service in services" :key="service.id" :value="service.id">
                                {{ service.name }}
                            </option>
                        </select>

                        <span v-if="errors.service" class="text-red-500 text-sm">{{ errors.service }}</span>
                    </div>

                    <!-- Appointment Name -->
                    <div class="mb-4">
                        <label for="projectDescription" class="block text-sm font-medium text-gray-700">Nome</label>
                        <input
                            type="text"
                            id="appointmentName"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            v-model="form.name"
                            required
                        />
                        <span v-if="errors.name">{{ errors.name }}</span>
                    </div>

                    <!-- Appointment Phone -->
                    <div class="mb-4">
                        <label for="projectDescription" class="block text-sm font-medium text-gray-700">Telefone</label>
                        <input
                            type="number"
                            id="appointmentPhone"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            v-model="form.phone"
                            required
                        />
                        <span v-if="errors.phone">{{ errors.phone }}</span>
                    </div>

                    <!-- Appointment Email -->
                    <div class="mb-4">
                        <label for="projectDescription" class="block text-sm font-medium text-gray-700">Email</label>
                        <input
                            type="email"
                            id="appointmentEmail"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            v-model="form.email"
                            required
                        />
                        <span v-if="errors.email">{{ errors.email }}</span>
                    </div>

                    <!-- Appointment Notes -->
                    <div class="mb-4">
                        <label for="projectDescription" class="block text-sm font-medium text-gray-700">Notas</label>
                        <input
                            type="text"
                            id="projectDescription"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                            v-model="form.notes"
                            required
                        />
                        <span v-if="errors.description">{{ errors.notes }}</span>
                    </div>

                    <div class="mb-4">
                        <label for="time" class="block mb-2 text-sm font-medium text-gray-900">Escolha um dia</label>

                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input v-model="form.day" ref="formDay" autocomplete="off" id="datepicker-format" datepicker datepicker-format="yyyy-mm-dd"
                                   type="text"
                                   class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   placeholder="Select date">
                        </div>
                        <span v-if="errors.day">{{ errors.day }}</span>
                    </div>

                    <div class="mb-4">
                        <div class="pt-5 flex flex-col rtl:space-x-reverse">
                            <label class="mb-5">Horário</label>
                            <div class="w-full">
                                <button @click="fetchAvailableSlots" type="button"
                                        class="inline-flex items-center w-full py-2 me-2 justify-center text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    <svg class="w-4 h-4 text-gray-800 dark:text-white me-2" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                         viewBox="0 0 24 24">
                                        <path fill-rule="evenodd"
                                              d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4a1 1 0 1 0-2 0v4a1 1 0 0 0 .293.707l3 3a1 1 0 0 0 1.414-1.414L13 11.586V8Z"
                                              clip-rule="evenodd"/>
                                    </svg>
                                    Escolha um horário
                                </button>
                                <label class="sr-only">
                                    Escolha um horário
                                </label>
                                <ul v-if="showTimeSlots" id="timetable" class="grid w-full grid-cols-2 gap-2 mt-5">
                                    <li v-model="form.day" v-for="(slot, index) in timeSlots" :key="index">
                                        <input type="radio" :id="'slot-' + index" :value="slot" class="hidden peer" name="timetable">
                                        <label :for="'slot-' + index"
                                               class="inline-flex items-center justify-center w-full p-2 text-sm font-medium text-center bg-white border rounded-lg cursor-pointer text-blue-600 border-blue-600 dark:hover:text-white dark:border-blue-500 dark:peer-checked:border-blue-500 peer-checked:border-blue-600 peer-checked:bg-blue-600 hover:text-white peer-checked:text-white hover:bg-blue-500 dark:text-blue-500 dark:bg-gray-900 dark:hover:bg-blue-600 dark:hover:border-blue-600 dark:peer-checked:bg-blue-500">
                                            {{ slot.slice(0, 5) }}
                                        </label>
                                    </li>
                                </ul>

                            </div>
                        </div>
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
    </AuthenticatedLayout>
</template>

<script>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import axios from "axios";
import {ref} from 'vue';

export default {
    components: {AuthenticatedLayout},
    data() {
        const today = new Date();
        const weekStart = this.getStartOfWeek(today);
        const weekEnd = new Date(weekStart);
        weekEnd.setDate(weekEnd.getDate() + 6);

        const events = [
            {
                id: 1,
                date: '2024-09-04',
                hour: '12:00',
                name: 'Cabelereiro',
            },
            {
                id: 3,
                date: '2024-09-06',
                hour: '08:00',
                name: 'Pedicure',
            },
        ];

        return {
            calendarData: {
                days: this.getCurrentWeekDays(),
                monthName: this.getMonthName(today.getMonth(), today.getFullYear()),
                weekRange: this.getWeekRange(weekStart, weekEnd),
            },
            hours: Array.from({length: 12}, (v, i) => `${String(i + 8).padStart(2, '0')}:00`),
            events: events, // Add the events to data
        };
    },
    methods: {
        getCurrentWeekDays() {
            const days = ['Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'];
            const weekStart = this.getStartOfWeek(new Date());
            const today = new Date();
            const todayDate = new Date(today.getFullYear(), today.getMonth(), today.getDate()); // Remove time part

            return days.map((day, index) => {
                const date = new Date(weekStart);
                date.setDate(date.getDate() + index);
                const formattedDate = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}-${String(date.getDate()).padStart(2, '0')}`; // Format date as YYYY-MM-DD
                return {
                    name: day,
                    date: formattedDate,
                    isToday: date.setHours(0, 0, 0, 0) === todayDate.getTime(),
                    numberDay: date.getDate(),
                };
            });
        },
        getStartOfWeek(date) {
            const dayOfWeek = date.getDay();
            const distanceToMonday = (dayOfWeek + 6) % 7;
            const startOfWeek = new Date(date);
            startOfWeek.setDate(startOfWeek.getDate() - distanceToMonday);
            startOfWeek.setHours(0, 0, 0, 0);
            return startOfWeek;
        },
        getMonthName(monthIndex) {
            const months = [
                'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
                'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
            ];
            return `${months[monthIndex]}`;
        },
        getWeekRange(startDate, endDate) {
            const formatDate = date => `${date.getDate().toString().padStart(2, '0')}`;

            const today = new Date();
            return `Semana de  ${formatDate(startDate)} - ${formatDate(endDate)} de ${today.getFullYear()}`;
        },
        getEvents(date, hour) {
            return this.events.filter(event => {
                return event.date === date && event.hour === hour;
            });
        },
        getEventStyle(event) {
            return {
                cursor: 'pointer',
                position: 'absolute',
                top: `${event.top}px`,
                width: `100%`,
                height: `300px`,
                backgroundColor: event.color || '#1f96ea',
                borderRadius: '4px',
                padding: '2px',
                color: '#fff',
                overflow: 'hidden',
                textOverflow: 'ellipsis',
                whiteSpace: 'nowrap'
            };
        },
    }
};
</script>


<style scoped>

</style>
