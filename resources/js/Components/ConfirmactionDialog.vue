<template>
    <Modal :show="show" max-width="md">
        <div class="p-6">
            <h2 class="text-2xl font-semibold mb-2">
                Please Confirm
            </h2>

            <p class="mt-4 text-sm text-gray-600">
                {{ message }}
            </p>

            <div class="mt-6 flex justify-end space-x-3">
                <button
                    @click="$event => emit('cancel')"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500"
                >
                    Cancel
                </button>

                <button
                    @click="$event => emit('confirm')"
                    class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                >
                    Confirm
                </button>
            </div>
        </div>

    </Modal>
</template>
<script setup>
    import Modal from '@/Components/Modal.vue';
    import { defineEmits, defineProps } from 'vue';




    const emit = defineEmits(['confirm', 'cancel']);
    const props = defineProps({
        show: {
            type: Boolean,
            required: true,
        },
        message: {
            type: String,
            required: true,
        },
    });
    

</script>
<style scoped>      
</style>