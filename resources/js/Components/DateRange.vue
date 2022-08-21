<template>
    <VueCtkDateTimePicker range="true" format="YYYY-MM-DD"/>
</template>

<script setup>

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import { ref, onMounted } from 'vue';

const emit = defineEmits(['date'])

</script>
