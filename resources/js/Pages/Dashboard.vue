<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import DateRange from '@/Components/DateRange.vue';
import EventModal from '@/Components/EventModal.vue';
import Alert from '@/Components/Alert.vue';
import moment from 'moment';
import { Inertia } from '@inertiajs/inertia'
import {onMounted, reactive} from "vue";
const props = defineProps({
    events: [],
    updateStatus: Boolean,
});

const edit = reactive({
    editData: []
})

const modalEdit = reactive ({
    display: false,
    showAlert: false,
    event_id: null,
    date: [],
    displayRange: true
})

const eventData = reactive ({
    data: [],
    filter: false
})

function createEvent () {
    console.log('submit form', forms)
    axios.post(route('event.store'), forms)
    .then((rep) => {
        console.log('creating response events ===>>', rep)
    })
}

function eventsData (data) {
    modalEdit.date = data
}

function updateEvent (event) {
    modalEdit.display = true
    edit.editData = event
}
async function DeleteEvent () {
    await axios.post(`/events/delete`, {id: modalEdit.event_id})
    .then((rep) => {
        modalEdit.showAlert = false
        reload()
    })
}

function getRange() {
    if (modalEdit.date.length === 0) {
        reload()
    }else {
        axios.post(route('events.range'), modalEdit.date)
        .then((rep) => {
            modalEdit.date = []
            eventData.data = rep.data
        })
    }
}

function myEvents () {
    modalEdit.displayRange = false
    axios.get(route('events.myEvents'))
    .then((rep) => {
        eventData.data = rep.data
    })
}

function reload() {
    Inertia.get('/dashboard')
}

onMounted(() => {
    eventData.data = props.events
})
</script>

<template>
    <div>
        <AppLayout title="Dashboard">
            <template #header>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard
                </h2>
            </template>
            <template #content>
                <div class="space-y-3">
                    <h1 class="text-center mt-5 italic text-green-500 underline uppercase font-bold"> {{ modalEdit.displayRange ? 'liste des evenements a venir' : 'Mes Evenements' }} </h1>
                    <div class="border space-y-2 w-full bg-white p-3 rounded-lg">
                        <h1 v-if="modalEdit.displayRange" class="text-green-600 font-bold">Filtrer par Date</h1>
                        <div class="flex justify-center justify-between items-center space-x-3">
                            <div class="flex justify-center items-center space-x-2">
                                <DateRange v-if="modalEdit.displayRange" @dateEvent="eventsData" />
                                <p v-if="modalEdit.displayRange" @click="getRange" class=" px-5 py-1 rounded-lg whitespace-nowrap cursor-pointer bg-green-600 text-white font-bold">Filtrer</p>
                            </div>
                            <div class="flex space-x-3">
                                <p @click="myEvents" class="px-5 py-1 rounded-lg whitespace-nowrap cursor-pointer bg-green-600 text-white font-bold">Mes Evenements</p>
                                <p v-if="!modalEdit.displayRange" @click="reload" class="px-5 py-1 rounded-lg whitespace-nowrap cursor-pointer bg-green-600 text-white font-bold">Evenements a venir</p>
                            </div>
                            </div>
<!--                        <p class="cursor-pointer border-2 bg-blue-500" @click="getRange">Filtrer</p>-->
                    </div>
                    <div class="w-full border-2 overflow-x-auto shadow-lg rounded-lg">
                        <table class="px-5 w-full whitespace-nowrap bg-white">
                            <thead>
                            <tr class="bg-green-500 text-white font-bold text-gray-600 uppercase text-sm leading-normal">
                                <th>#</th>
                                <th class="top">Nom de l'evenement</th>
                                <th class="top">Debut</th>
                                <th class="top">Fin</th>
                                <th class="top">Creer le:</th>
                                <th class="top">Modifier le:</th>
                                <th class="top">Action</th>
                            </tr>
                            </thead>
                            <tbody class="text-gray-600 font-bold capitalize text-sm font-light">
                                <tr class="border-b border-gray-200" v-for="(event, idx) in eventData.data.data" :key="idx">
                                <td class="top">{{idx+1}}</td>
                                <td class="top">{{ event.title }}</td>
                                <td class="top">{{ moment(event.start).format('DD-MM-YYYY') }}</td>
                                <td class="top">{{ moment(event.end).format('DD-MM-YYYY') }}</td>
                                <td class="top">{{ moment(event.created_at).format('DD-MM-YYYY') }}</td>
                                <td class="top">{{ moment(event.updated_at).format('DD-MM-YYYY') }}</td>
                                <td class="top">
                                    <div class="flex space-x-2">
                                        <div @click="updateEvent(event)" class="bg-green-500 cursor-pointer px-4 flex items-center rounded-lg">
                                            <svg class="h-5 text-white font-bold w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                            </svg>
                                        </div>

                                        <div @click="modalEdit.showAlert=true, modalEdit.event_id = event.id" class="bg-red-600 cursor-pointer flex items-center rounded-lg py-1 px-4">
                                            <svg class="h-5 font-bold text-white w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </template>
        </AppLayout>
        <event-modal v-if="modalEdit.display" :editData="edit.editData" @closeModal="modalEdit.display=false"/>
        <Alert v-if="modalEdit.showAlert" @cancel="modalEdit.showAlert = false" @delete="DeleteEvent" />
    </div>

</template>

<style>
    .top {
        @apply py-3 px-6 text-left
    }
    .red-color {
        color: red;
    }
</style>
