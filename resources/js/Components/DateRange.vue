
<script setup>

import VueCtkDateTimePicker from 'vue-ctk-date-time-picker';
import 'vue-ctk-date-time-picker/dist/vue-ctk-date-time-picker.css';
import {ref, onMounted, reactive} from 'vue';

const emit = defineEmits(['dateEvent'])

const forms = reactive({
    eventDate: ''
})

function show() {
    emit('dateEvent', forms.eventDate)
}

</script>

<template>
    <VueCtkDateTimePicker @validate="show" label="Debut et fin" class="w-full rounded-lg outline-none" v-model="forms.eventDate" only-date="true" locale="fr" format="YYYY-MM-DD" range="true"/>
</template>
