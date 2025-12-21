<template>
   <div   @drop.prevent="handleDrop"
          @dragover.prevent="handleDragOver"
          @dropleave.prevent="handleDragLeave" 
   class="h-screen bg-gray-50 flex w-full gap-4">
    <Navigation />
    <main 
         class="flex flex-col flex-1 px-4 overflow-hidden" :class="dragOver ? 'drogzone' : ''">
         <template v-if="dragOver" class="text-gray-500 text-center py-8 text-sm">
            Drop files here to upload
         </template>
         <template v-else>
            <div class="flex items-center justify-between w-full"> 
                <SearchForm />
                <UserSettingsDropdown />
            </div>
            <div class="flex-1 flex-col overflow-hidden">
                <slot />
            </div>
         </template>
    </main>
   </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import Navigation from '@/Components/app/Navigation.vue';
import SearchForm from '@/Components/app/SearchForm.vue';
import UserSettingsDropdown from '@/Components/app/UserSettingsDropdown.vue';
import { emitter, FILE_UPLOAD_START } from '@/event-bus.js';



//uses 
const page = usePage();
const fileUploadFrom = useForm({
    files: [],
    relative_path: [],
    parent_id: null,
    
});



const showingNavigationDropdown = ref(false);
const dragOver = ref(false);


//Methid

function handleDrop(event) {
    dragOver.value = false;
    const files = event.dataTransfer.files;
    if (files.length === 0) {
        return;
    }
    uploadFiles(files);


    emitter.emit(FILE_UPLOAD_START, files);
}

function handleDragOver(event) {
    dragOver.value = true;
    //event.preventDefault();
}

function handleDragLeave(event) {
    dragOver.value = false;
    //event.preventDefault();
}

function uploadFiles(files) {
    console.log(files);
    
    fileUploadFrom.parent_id = page.props.folder ? page.props.folder.id : null;
    fileUploadFrom.files = files;
    fileUploadFrom.relative_path = [...files].map(file => file.webkitRelativePath);
    fileUploadFrom.post(route('uploadFiles'), {
        preserveScroll: true,
        onSuccess: () => {
            fileUploadFrom.reset();
        },
    }); 
    
}


// hooks
onMounted(() => {
    emitter.on(FILE_UPLOAD_START,uploadFiles);
});
</script>
<style scoped>
    .drogzone{
        width: 100%;
        height: 100%;
        border: 4px dashed #9ca3af;
        border-radius: 0.5rem;
        background-color: #f9fafb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.125rem;
        color: #6b7280;
    }
</style>
