<script setup>

const emit = defineEmits(['cancel', 'delete'])

</script>

<template>
    <div>
        <div class="transition-opacity w-full fixed z-20 inset-0 overflow-y-auto flex items-center justify-center" style="background: rgba(21, 19, 19, .2)">
            <div class="bg-white relative lg:w-1/2 p-5 w-full rounded-lg">
                <h1 class="text-center text-xl font-bold">Etez vous sure de vouloir supprimer l'evenement?</h1>
                <svg class="h-20 w-20 mx-auto text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <div class="flex justify-between">
                    <div @click="$emit('cancel')" class="bg-green-600 cursor-pointer text-white font-bold rounded-lg px-5 py-1">Annuler</div>
                    <div @click="$emit('delete')" class="bg-red-600 cursor-pointer text-white font-bold rounded-lg px-5 py-1">Supprimer</div>
                </div>
            </div>
        </div>
    </div>
</template>
