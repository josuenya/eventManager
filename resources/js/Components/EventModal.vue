<script setup>

</script>

<template>
    <div>
        <div class="transition-opacity w-full fixed z-20 inset-0 overflow-y-auto flex items-center justify-center" style="background: rgba(21, 19, 19, .2)">
            <div class="bg-white lg:w-1/2 p-5 w-full rounded-sm">
                <div>
                    <h1 class="text-center text-blue-600 font-bold">Ajouter un nouveau evenement</h1>
                    <form>
                        <div class="space-y-3">
                            <div>
                                <label>Titre de l'evenement</label>
                                <input type="text" placeholder="titre de l'evenement" class="outline-none border rounded-lg w-full">
                            </div>
                            <div>
                                <label>Description de l'evenement</label>
                                <textarea class="w-full outline-none rounded-lg" placeholder="description de l'evenement" name="" id="" cols="30" rows="2"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>
