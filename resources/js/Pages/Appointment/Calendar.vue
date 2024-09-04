<template>
    <div :class="{ 'min-w-[45rem]': selectedDay !== null }" class="bg-white min-h-[30rem] max-w-full md:max-w-[98rem] rounded-lg overflow-hidden flex flex-col md:flex-row">
        <!-- Calendário -->
        <div class="flex-1 mr-0 md:mr-2">
            <div class="p-4 border-gray-200 flex items-center justify-between">
                <button @click="prevMonth" class="text-lg font-bold text-blue-500">Anterior</button>
                <h1 class="text-md md:text-2xl sm:text-md font-bold">{{ monthName }}</h1>
                <button @click="nextMonth" class="text-lg font-bold text-blue-500">Próximo</button>
            </div>

            <!-- Tabela para o calendário -->
            <div class="grid grid-cols-7 gap-px">
                <!-- Cabeçalho com os nomes dos dias da semana em português -->
                <div v-for="(day, index) in weekDays" :key="'header-' + index" class="p-2 md:p-4 text-center text-xs font-semibold">
                    {{ day }}
                </div>

                <!-- Renderiza o calendário -->
                <div v-for="(day, index) in calendar" :key="'day-' + index" class="relative w-[44px] h-[44px] mx-auto">
                    <button v-if="day !== null" @click="selectDay(day)"
                            :class="['mt-2 w-full h-full flex items-center text-sm md:text-[18px] justify-center font-bold rounded-full',
                  day === selectedDay ? 'bg-blue-600 text-white' : 'bg-custom-bg text-custom-blue']">
                        {{ day }}
                    </button>
                </div>
            </div>
        </div>

        <!-- Painel de horários (aparece abaixo em dispositivos móveis) -->
        <div v-if="selectedDay !== null" class="md:border-l border-gray-200 p-4">
            <h2 class="text-lg md:text-xl font-bold mb-4">Horários Disponíveis para {{ selectedDay }}</h2>
            <div v-for="time in availableTimes" :key="time" class="mb-2">
                <button @click="expandParentWidth" class="w-full py-2 px-4 border border-blue-300 text-blue-500 font-bold rounded-md hover:bg-blue-200">
                    {{ time }}
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue';
import dayjs from 'dayjs';

// Reactive state
const today = dayjs();
const year = ref(today.year());
const month = ref(today.month()); // 0-indexed for January
const selectedDay = ref(null);
const availableTimes = ref([
    '08:00', '09:00', '10:00', '11:00', '12:00',
    '13:00', '14:00', '15:00', '16:00', '17:00'
]);


// Computed properties
const monthNames = [
    'Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho',
    'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'
];
const weekDays = ['Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'];

const monthName = computed(() => monthNames[month.value]);

const calendar = computed(() => {
    const firstDayOfMonth = dayjs(`${year.value}-${month.value + 1}-01`);
    const startDay = (firstDayOfMonth.day() + 6) % 7;
    const daysInMonth = firstDayOfMonth.daysInMonth();

    const days = [];

    for (let i = 0; i < startDay; i++) {
        days.push(null);
    }

    for (let day = 1; day <= daysInMonth; day++) {
        days.push(day);
    }

    while (days.length % 7 !== 0) {
        days.push(null);
    }

    return days;
});

// Methods
const prevMonth = () => {
    if (month.value === 0) {
        month.value = 11; // December
        year.value -= 1;
    } else {
        month.value -= 1;
    }
};

const nextMonth = () => {
    if (month.value === 11) {
        month.value = 0; // January
        year.value += 1;
    } else {
        month.value += 1;
    }
};

const emit = defineEmits(['update:selectedDay']);

const selectDay = (day) => {
    selectedDay.value = day;
    // Emit the selected day to the parent
    emit('update:selectedDay', day);
};

const services = ref([]);

</script>

<style scoped>
/* Add any specific styles here */
</style>
