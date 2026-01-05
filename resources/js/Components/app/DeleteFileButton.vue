<template>
    <button @click="onDeleteClick" class="inline-flex items-center px-4 py-2 border border-gray-200 text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 disabled:opacity-50 disabled:cursor-not-allowed">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
        </svg>
        <span class="ml-2">Delete</span>
    </button>
    <ConfirmactionDialog :show="showDeleteDialog" :message="confirmMessage" @confirm="confirmDelete" @cancel="cancelDelete"></ConfirmactionDialog>
</template>
<script setup>
import { defineProps, defineEmits, ref, computed } from 'vue';
import ConfirmactionDialog from '../ConfirmactionDialog.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import { showErrorDialog } from '@/event-bus';

const props = defineProps({
    deleteAll: {
        type: Boolean,
        required: false,
        default: false,
    },
    deletedIds: {
        type: Array,
        default: false,
    }
});

const emit = defineEmits(['delete']);

const showDeleteDialog = ref(false);
const page = usePage();
const deleteFileFrom = useForm({
    all: null,
    ids: [],
    parent_id: null,
});

const confirmMessage = computed(() => {
    if (props.deleteAll) {
        return 'Are you sure you want to delete all files? This action cannot be undone.';
    } else if (props.deletedIds.length) {
        return `Are you sure you want to delete ${props.deletedIds.length} selected file(s)? This action cannot be undone.`;
    } else {
        return 'No files selected for deletion.';
    }
});

function onDeleteClick() {
    if (!props.deleteAll && !props.deletedIds.length) {
        showErrorDialog('Please select at least one file to delete.');
        return;
    }
    showDeleteDialog.value = true;
}
function confirmDelete() {
    deleteFileFrom.parent_id = page.props.folder ? page.props.folder.id : null;
    if (props.deleteAll) {
        deleteFileFrom.all = true;
    } else {
        deleteFileFrom.ids = props.deletedIds;
    }
    deleteFileFrom.delete(route('file.destroy'), {
        onSuccess: () => {
            showDeleteDialog.value = false;
            emit('delete');
        },
    });

    console.log('clicked', props.deleteAll, props.deletedIds);
}
function cancelDelete() {
    showDeleteDialog.value = false;
}
</script>
<style scoped>

</style>
