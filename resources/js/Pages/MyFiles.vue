<template>
    <AuthenticatedLayout>
        <nav class="flex items-center justify-between p-1 mb-3">
            <ol class="inline-flex items-center space-x-1 md:space-x-2">
                <li v-for="ancestor in ancestors.data" :key="ancestor.id" class="inline-flex items-center">
                     <Link v-if="!ancestor.parent_id" :href="route('myFiles')" class="text-gray-500 hover:text-gray-700 inline-flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                        My Files
                    </Link>
                    <div v-else class="flex items-center">
                        <svg class="w-4 h-4 text-gray-400 mx-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                        <Link :href="route('myFiles', { folder: ancestor.path })" class="text-gray-500 hover:text-gray-700 ml-1 md:ml-2">
                            {{ ancestor.name }}
                        </Link>
                    </div>
                </li>
            </ol>   
        </nav>
        <table class="min-w-full">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-900 uppercase tracking-wider">
                        Name
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Woner
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Last Modified
                    </th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Size
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="file in files.data" :key="file.id"
                @dblclick="openFolder(file)"
                 class="bg-white border-b transition duration-300 ease-in-out hover:bg-gray-100 cursor-pointer">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ file.name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ file.owner }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ file.updated_at }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">{{ file.size }}</td>
                </tr>
            </tbody>
        </table>  
        <div v-if="!files.data.length" class="py-8 text-center text-lg text-gray-400">
            There are no files or folders in this directory.
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link, router } from '@inertiajs/vue3';


const props = defineProps({
    files: Object,
    folder: Object,
    ancestors: Object,
});

function openFolder(file) {
    if (!file.is_folder) {
        return;
    }
    router.visit(route('myFiles', { folder: file.path }));
}

</script>
<style scoped>  

</style>