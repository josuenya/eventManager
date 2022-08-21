<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import {reactive} from "vue";

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
});

const modal = reactive ({
    display: false
})
</script>

<template>
    <div>
        <div class="bg-blue-600 flex justify-between items-center text-white font-bold px-5 py-2">
            <p>Cloud-Event</p>
            <div class="flex space-x-2">
                <p @click="modal.display = true" class="cursor-pointer flex items-center justify-center">
                    <svg class="h-4 text-white font-bold w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    <span>Ajouter</span>
                </p>
                <Link v-if="$page.props.user" :href="route('events-list')" class="text-sm dark:text-gray-500">Evenements</Link>
                <div v-if="canLogin">
                    <Link v-if="$page.props.user" :href="route('dashboard')" class="text-sm dark:text-gray-500">Dashboard</Link>
                    <template v-else>
                        <Link :href="route('login')" class="text-sm dark:text-gray-500">Log in</Link>

                        <Link v-if="canRegister" :href="route('register')" class="ml-4 text-sm dark:text-gray-500">Register</Link>
                    </template>
                </div>
            </div>
        </div>
    </div>
</template>
