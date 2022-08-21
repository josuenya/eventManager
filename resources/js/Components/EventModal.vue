<script setup>
import {onMounted, reactive} from "vue";
import { Inertia } from '@inertiajs/inertia';
import DateRange from '@/Components/DateRange.vue';
const emit = defineEmits(['closeModal', 'events'])
const forms = reactive({
    title: '',
    description: '',
    start: '',
    end: ''
})

const props = defineProps(['editData', 'updateStatus'])

async function createEvent () {
    console.log('submit form', forms)
    if(!forms.title & !forms.start) return false
    await axios.post(route('event.store'), forms)
    .then((rep) => {
        emit('closeModal');
        this.reload()
    })
}

function eventsData (data) {
    forms.start = data.start
    forms.end = data.end
}

function reload() {
    Inertia.get('/dashboard')
}

async function updateEvent () {
    let finalForm = forms
    finalForm.id = props.editData.id
    await axios.post(route('event.update'), finalForm)
    .then((rep) => {
        emit('closeModal')
        this.reload()
    })
}

onMounted(() => {
    if (!props.editData) return false
    const edit = props.editData
    forms.title = edit.title
    forms.description = edit.description
    forms.start = edit.start
    forms.start = edit.end
})
</script>

<template>
    <div>
        <div class="transition-opacity w-full fixed z-20 inset-0 overflow-y-auto flex items-center justify-center" style="background: rgba(21, 19, 19, .2)">
            <div class="bg-white relative lg:w-1/2 p-5 w-full rounded-lg">
                <div>
                    <h1 class="text-center text-blue-600 font-bold"> {{ !props.editData ? 'Ajouter un nouveau evenement' : 'Modification de l\'evenement' }}</h1>
                    <form @submit.prevent="!props.editData ? createEvent() : updateEvent()">
                        <div class="space-y-3">
                            <div>
                                <label>Titre de l'evenement</label>
                                <input v-model="forms.title" type="text" placeholder="titre de l'evenement" class="outline-none border rounded-lg w-full">
                            </div>
                            <div>
                                <label>Description de l'evenement</label>
                                <textarea v-model="forms.description" class="w-full outline-none rounded-lg" placeholder="description de l'evenement" name="" id="" cols="30" rows="2"></textarea>
                            </div>
                            <div>
                                <label for="">Date de l'evenement</label>
                                <DateRange @dateEvent="eventsData" />
                            </div>
                            <div class="flex justify-end">
                                <button type="submit" class="bg-green-500 text-white font-bold px-5 py-1 rounded-lg">{{ !props.editData ? 'Creer' : 'Modifier' }}</button>
                            </div>
                        </div>
                    </form>
                </div>
                <svg @click="$emit('closeModal')" class="absolute bg-red-600 text-white font-bold rounded-lg font-bold cursor-pointer top-2 right-5 h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>
    </div>
</template>
