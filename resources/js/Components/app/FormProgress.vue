<template>
    <div v-if="form.progress" class="absolute border-gray-900 border right-8 bottom-4 bg-white shadow-lg rounded flex flex-col w-[240px] p-2">
        <div class="text-xs mb-2">
            Upload Progress {{ form.files.length }} file(s)
        </div>
        <div class="h-4 bg-gray-200 rounded-md">
            <div class="h-full bg-gray-900 rounded-md transition-all" :style="{ width: form.progress.percentage + '%' }">

            </div>
        </div>
    </div>
</template>
<script setup>


const props = defineProps({
    form: Object,
});


</script>
<style scoped>
    .absolute {
        z-index: 1000;
    }
</style>