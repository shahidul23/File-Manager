<template>
    <MenuItem v-slot="{ active }">
        <a href="#" class="text-gray-700 block px-4 py-2 text-sm relative overflow-hidden">
        Upload Folders
        <input webkitdirectory directory @change="onChange" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
        </a>
    </MenuItem>
</template>

<script setup>
import { emitter, FILE_UPLOAD_START } from '@/event-bus';
import { MenuItem } from '@headlessui/vue';





//Method 
function onChange(event){
    emitter.emit(FILE_UPLOAD_START, event.target.files);
}

</script>

<style>

</style>