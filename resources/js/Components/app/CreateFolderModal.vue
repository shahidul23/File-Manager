<template>
    <Modal :show="modelValue" @show="onShow" max-width="sm">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                Create New Folder
            </h2>
            <div class="mt-6">
                <InputLabel for="folderName" value="Folder Name"/>
                <TextInput type="text" 
                            ref="folderNameInput"
                            id="folderName" 
                            v-model="form.name"
                            class="mt-1 block w-full"
                            :class="form.errors.name ? 'border-red-500 focus:border-red-500 focus:ring-red-500' : ''"
                            placeholder="Folder Name"
                            @keyup.enter="createFolder"
                            />
                <InputError :message="form.errors.name" class="mt-2"/>            
            </div>
            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal">Cancel</SecondaryButton>
                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    @click="createFolder"
                    :disabled="form.processing"
                >
                    Create
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>

<script setup>  
import Modal from '@/Components/Modal.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import { useForm } from '@inertiajs/vue3';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { nextTick ,ref } from 'vue';
import { usePage } from '@inertiajs/vue3';

const { modelValue } = defineProps({
    modelValue: Boolean,
});
const emit = defineEmits(['update:modelValue']);
const folderNameInput = ref(null);
const form = useForm({
    name: '',
    parent_id: null,
    errors: {},
});
const page = usePage();

function onShow() {
    nextTick(() => {
        if (folderNameInput.value) {
            folderNameInput.value.focus();
        }
    });
}


// methods
function createFolder() {
    // Logic to create folder
    form.parent_id = page.props.folder.id
    form.post(route('createFolder'), {
        preserveScroll: true,
        onSuccess: () => {
            closeModal();
            form.reset();

        },
        onError: () => {
            // Focus the input field if there's an error
            folderNameInput.value.focus();
        },
    });
    // Close the modal after creating folder
}
function closeModal() {
    form.reset();
    form.clearErrors();
    emit('update:modelValue');
}

</script>