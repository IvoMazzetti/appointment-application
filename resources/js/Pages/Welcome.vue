<script setup>
import {Head, Link} from '@inertiajs/vue3';
import { CurrencyEuroIcon } from "@heroicons/vue/outline"
import Service from '../../images/Service.png'
import Service2 from '../../images/Service2.png'

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome"/>
    <div class="bg-white text-black/50 dark:bg-black dark:text-white/50">

        <div
            class="relative flex flex-col items-center min-h-screen"
        >
            <div class="relative w-full ">
                <header class="flex items-center justify-around w-full gap-2 py-5 bg-white shadow-sm">
                    <nav v-if="canLogin" class="flex items-center justify-evenly">
                        <Link
                            :href="route('login')"
                            class="ml-4 text-2xl text-gradient-2 font-semibold  rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Home
                        </Link>

                        <Link
                            :href="route('login')"
                            class="font-semibold text-xl text-black rounded-md px-3 py-2  ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Products
                        </Link>
                        <Link
                            :href="route('login')"
                            class="font-semibold text-xl text-black rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Templates
                        </Link>
                        <Link
                            :href="route('login')"
                            class="font-semibold text-xl text-black rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Features
                        </Link>
                        <Link
                            :href="route('login')"
                            class="font-semibold text-xl text-black rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            Pricing
                        </Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="font-semibold text-xl text-black rounded-md px-3 py-2 ring-1 ring-transparent transition hover:text-black/70 focus:outline-none focus-visible:ring-[#FF2D20] dark:text-white dark:hover:text-white/80 dark:focus-visible:ring-white"
                        >
                            About
                        </Link>
                    </nav>
                    <div class="flex">
                        <Link :href="route('login')" class="px-6 py-2 mr-2 text-black bg-white border rounded-full">Log in</Link>
                        <button class="ml-2 rounded-full bg-gradient-to-br from-[#ed23d8] to-[#0088ea] border px-6 py-2 text-white bg-blue-500">Get started</button>
                    </div>
                </header>

                <main class="flex flex-col items-center justify-center mt-10">
                    <div class="my-20 min-w-3xl">
                        <div class="flex flex-col items-center max-w-[40rem]">
                            <h1 class="mt-2 leading-tight text-black text-[1rem] md:text-[4rem] font-bold text-center">
                                Easy scheduling ahead of your needs.
                            </h1>
                            <span class="mt-4 text-[1.25rem] text-center">
                                Calendlo is your scheduling automation platform for eliminating the back-and-forth emails for finding the perfect time - and so much more.
                            </span>
                            <div class="flex justify-center my-6">
                                <button class="mr-4 rounded-full py-3 px-6  bg-gradient-to-br from-[#0088ea] to-[#ed23d8] text-white">Sign up free now
                                </button>
                                <button class="px-6 py-3 mr-4 text-black bg-white border rounded-full">Learn more about
                                    Calendlo
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="my-10 min-w-[70rem]">
                        <h1 class="my-20 leading-tight text-black text-[1rem] md:text-[3rem] font-bold text-center">
                            Special features for teams who <br> conduct meetings at scale
                        </h1>

                        <!-- Navigation Links -->
                        <div class="flex justify-around px-4 py-2 mt-10 bg-gray-100 rounded-full">
                            <a
                                @click.prevent
                                href="#sales"
                                :class="navClass('sales')"
                                class="px-10 py-3 transition-all duration-300 ease-in-out rounded-full"
                                @click="setActive('sales')"
                            >
                                Sales
                            </a>

                            <a
                                @click.prevent
                                href="#marketing"
                                :class="navClass('marketing')"
                                class="px-10 py-3 text-center transition-all duration-300 ease-in-out rounded-full"
                                @click="setActive('marketing')"
                            >
                                Marketing
                            </a>

                            <a
                                @click.prevent
                                href="#customer"
                                :class="navClass('customer')"
                                class="px-10 py-3 text-center transition-all duration-300 ease-in-out rounded-full"
                                @click="setActive('customer')"
                            >
                                Customer Success
                            </a>

                            <a
                                @click.prevent
                                href="#recruiting"
                                :class="navClass('recruiting')"
                                class="px-10 py-3 transition-all duration-300 ease-in-out rounded-full"
                                @click="setActive('recruiting')"
                            >
                                Recruiting
                            </a>

                            <a
                                @click.prevent
                                href="#education"
                                :class="navClass('education')"
                                class="px-10 py-3 transition-all duration-300 ease-in-out rounded-full"
                                @click="setActive('education')"
                            >
                                Education
                            </a>
                        </div>

                        <!-- Dynamic Content -->
                        <div class="flex flex-row justify-around mt-20 ">
                            <!-- Left Column -->
                            <div class="flex flex-col items-start flex-1 max-w-md p-4 text-start">
                                <h1 class="text-[2.4rem] text-gradient font-black mb-4">{{ content.title }}</h1>
                                <p class="mb-6 text-[1.2rem] max-w-sm">{{ content.description }}</p>
                                <button class="px-5 py-2 text-white transition-all bg-blue-500 rounded-full hover:bg-blue-600">
                                    Sign up free now
                                </button>
                            </div>

                            <!-- Right Column with Transition -->
                            <transition name="fade" @before-enter="beforeEnter" @enter="enter" @leave="leave">
                                <div v-if="content.features.length" key="features" class="flex flex-col max-w-md">
                                    <div v-for="(feature, index) in content.features" :key="index" class="cursor-pointer mb-10 rounded-2xl p-6 bg-gradient-to-br from-[#0088ea] to-[#ed23d8] shadow-lg hover:shadow-xl transition-shadow duration-300 ease-in-out">
                                        <h2 class="mb-4 text-[1.7rem] text-white font-black">{{ feature.title }}</h2>
                                        <span class="mt-4 text-white">{{ feature.description }}</span>
                                    </div>
                                </div>
                            </transition>
                        </div>
                    </div>

                    <div class="px-4 my-20">
                        <!-- Section Heading and Description -->
                        <div class="mb-12 text-center">
                            <h1 class="my-7 leading-tight text-black text-[1rem] md:text-[4rem] font-bold">
                                We make scheduling for <br /> you easier than ever
                            </h1>
                            <p class="text-center max-w-2xl mx-auto text-[1rem] md:text-[1.5rem]">
                                Take advantage of high buying intent right after checkout and create a seamless buying experience for your customers.
                            </p>
                        </div>

                        <!-- Content Section -->
                        <div class="flex flex-col justify-between gap-8 p-6 py-28 md:flex-row">
                            <!-- Text Content -->
                            <div class="flex-1 max-w-2xl rounded-lg">
                                <h2 class="text-black text-[2rem] md:text-[3.2rem] font-black mb-4">
                                    Share your Calendlo availability with others
                                </h2>
                                <p class="mb-4 text-[1.1rem] max-w-xl md:text-[1.2rem]">
                                    Grow your business with scheduling automation. Simply email, text, or add your Calendlo availability to your website - and watch prospects and recruits book high-value meetings with you.
                                </p>
                                <button class="bg-gradient-to-br from-[#0088ea] to-[#ed23d8] text-white py-2 px-4 rounded-lg transition-colors hover:bg-blue-600">
                                    Learn more
                                </button>
                            </div>

                            <!-- Image Content -->
                            <div class="flex-1 hidden md:block">
                                <img class="object-cover w-full h-auto rounded-3xl" :src="Service" alt="Calendlo Service" />
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="flex flex-col gap-8 p-6 py-28 md:flex-row-reverse">
                            <!-- Text Content -->
                            <div class="flex flex-col justify-between flex-1 max-w-2xl rounded-lg">
                                <div>
                                    <h2 class="text-black text-[2rem] md:text-[3.2rem] font-black mb-4">
                                        Share your Calendlo availability with others
                                    </h2>
                                    <p class="mb-4 text-[1.1rem] md:text-[1.2rem]">
                                        Grow your business with scheduling automation. Simply email, text, or add your Calendlo availability to your website - and watch prospects and recruits book high-value meetings with you.
                                    </p>
                                </div>
                                <div class="flex justify-end">
                                    <button class="bg-gradient-to-br from-[#ed23d8] to-[#0088ea] text-white py-2 px-4 rounded-lg transition-colors hover:bg-blue-600">
                                        Learn more
                                    </button>
                                </div>
                            </div>

                            <!-- Image Content -->
                            <div class="flex-1 hidden md:block">
                                <img class="object-cover w-full h-auto rounded-3xl" :src="Service2" alt="Calendlo Service" />
                            </div>
                        </div>

                    </div>
                </main>
            </div>
        </div>
    </div>
</template>

<script>
import HeroImage from 'resources/images/HeroImage.png';

export default {
    data() {
        return {
            heroImage: HeroImage,
            activeLink: 'sales',
            sections: {
                sales: {
                    title: "You do the business, we'll handle the money.",
                    description: "With the right credit card, you can improve your financial life by building credit, earning rewards, and saving money.",
                    features: [
                        { title: "Drive more revenue", description: "Book high-value meetings in seconds and turn scheduling into a competitive advantage." },
                        { title: "Speed up your sales cycle", description: "Keep your deal momentum high and remove scheduling friction at every stage of your sales cycle." },
                        { title: "Close more deals", description: "Customize reminder and follow-up workflows to move deals along, integrate with sales tools." }
                    ]
                },
                marketing: {
                    title: "Engage customers and grow faster.",
                    description: "Boost your marketing efforts with a streamlined workflow, from campaign creation to customer engagement.",
                    features: [
                        { title: "Generate leads quickly", description: "Automate lead generation and track customer engagement at every touchpoint." },
                        { title: "Optimize campaigns", description: "Run A/B tests to optimize your marketing campaigns and increase conversion rates." },
                        { title: "Build brand awareness", description: "Reach your target audience with personalized messaging and drive brand awareness." }
                    ]
                },
                customer: {
                    title: "Deliver exceptional customer experiences.",
                    description: "Enhance customer satisfaction by managing communications and support at scale.",
                    features: [
                        { title: "Streamline support", description: "Provide timely responses with an integrated helpdesk and CRM system." },
                        { title: "Measure customer satisfaction", description: "Track key metrics like CSAT and NPS to measure and improve customer satisfaction." },
                        { title: "Automate follow-ups", description: "Ensure no customer is left behind with automated follow-up workflows." }
                    ]
                },
                recruiting: {
                    title: "Build a world-class team.",
                    description: "Simplify your recruiting process and hire the right talent faster.",
                    features: [
                        { title: "Find top talent", description: "Attract and evaluate candidates with a streamlined recruitment process." },
                        { title: "Speed up hiring", description: "Reduce the time to hire by automating interview scheduling and follow-ups." },
                        { title: "Improve candidate experience", description: "Provide an exceptional candidate experience with clear communication and timely feedback." }
                    ]
                },
                education: {
                    title: "Empower learners with seamless scheduling.",
                    description: "Enhance the learning experience by simplifying scheduling and communication.",
                    features: [
                        { title: "Streamline student onboarding", description: "Easily schedule and manage student orientations and onboarding sessions." },
                        { title: "Enhance collaboration", description: "Facilitate smooth collaboration between students and educators with integrated scheduling." },
                        { title: "Automate reminders", description: "Set up automated reminders for exams, deadlines, and tutoring sessions." }
                    ]
                }
            }
        };
    },
    methods: {
        setActive(section) {
            this.activeLink = section;
        },
        navClass(section) {
            return {
                "bg-gradient-to-br from-[#ed23d8] to-[#0088ea] text-white": this.activeLink === section,
                "font-medium text-black hover:text-blue-500": this.activeLink !== section
            };
        },
    },
    computed: {
        content() {
            return this.sections[this.activeLink];
        }
    },
};
</script>

<style>
/* Text Gradient */
.text-gradient {
    background: linear-gradient(to right, #0088ea, #ed23d8); /* Gradient colors */
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.text-gradient-2 {
    background: linear-gradient(to right, #0088ea, #ed23d8); /* Gradient colors */
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
</style>


