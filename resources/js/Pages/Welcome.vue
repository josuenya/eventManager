<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import EventModal from '@/Components/EventModal.vue'
import VueCalendar from "@/Components/VueCalendar.vue";
defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <div class="">
        <Head title="Event-cloud" />
        <div class="bg-blue-600 flex justify-between items-center text-white font-bold px-5 py-2">
            <p>Cloud-Event</p>
            <div class="flex space-x-2">
                <p class="cursor-pointer">Ajouter un evenement</p>
                <div v-if="canLogin">
                    <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm dark:text-gray-500">Dashboard</Link>
                    <template v-else>
                        <Link :href="route('login')" class="text-sm dark:text-gray-500">Log in</Link>

                        <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm dark:text-gray-500">Register</Link>
                    </template>
                </div>
            </div>
        </div>
        <div class="" style="min-height: calc(100vh - 40px)">
            <vue-calendar />
        </div>
        <event-modal v-if="false" />
    </div>
</template>
