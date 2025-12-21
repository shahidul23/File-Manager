<template>
  <MenuItem v-slot="{ active }">
    <a href="#" class="text-gray-700 block px-4 py-2 text-sm relative overflow-hidden">
        Upload Files
        <input @change="onChange" type="file" multiple class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
    </a>
  </MenuItem>
</template>

<script setup>
import { MenuItem } from '@headlessui/vue';
import {emitter, FILE_UPLOAD_START} from '@/event-bus.js';

function onChange(event) {
    emitter.emit(FILE_UPLOAD_START, event.target.files);
    // const files = event.target.files;
    // if (files.length === 0) {
    //     return;
    // }
    // // Logic to handle file upload
    // console.log('Selected files:', files);
    // // Reset the input value to allow uploading the same file again if needed
    // event.target.value = '';
}
</script>

<style>

</style>