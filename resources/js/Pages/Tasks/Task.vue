<template>
    <app-layout>
        <template #header>
            <h2 class="font-bold text-xl text-gray-800 leading-tight uk-text-capitalize">
                Task: {{ $page['props']['task'].name }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-5">
                        <div class="px-4 py-3 text-right sm:px-6">
                            <button
                                @click="showCreateSubTaskForm"
                                type="submit"
                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm
                                text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Add Sub Task
                            </button>
                        </div>
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="mt-5 md:mt-0 md:col-span-2">
                                <form @submit.prevent="updateTask($page['props']['task'])">
                                    <div class="shadow overflow-hidden sm:rounded-md">
                                        <div class="px-4 py-5 bg-white sm:p-6">
                                            <div class="grid grid-cols-6 gap-6">
                                                <div class="col-span-3">
                                                    <label for="first_name" class="block text-sm font-medium text-gray-700">Name</label>
                                                    <input
                                                        type="text"
                                                        name="name"
                                                        class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                        v-model="$page['props']['task'].name"
                                                    />
                                                    <jet-input-error :message="errors.name" class="mt-2" />
                                                </div>

                                                <div class="col-span-6">
                                                    <label for="street_address" class="block text-sm font-medium text-gray-700">Description</label>
                                                    
                                                    <div class="mt-1">
                                                        <textarea
                                                            name="description"
                                                            rows="3" 
                                                            class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                                                            placeholder="Enter task description"
                                                            v-model="$page['props']['task'].description"
                                                        />
                                                    </div>
                                                </div>

                                                <div class="col-span-6 sm:col-span-3">
                                                    <label for="country" class="block text-sm font-medium text-gray-700">Status</label>
                                                    <select name="status" v-model="$page['props']['task'].status"
                                                        class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            
                                                        <option v-for="status in statuses" v-bind:key="status" v-bind:value="status" :selected="status === $page['props']['task'].status">{{ status }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                            <button
                                                type="submit"
                                                class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                            >
                                                Updated
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-span-5">
                        <!-- This example requires Tailwind CSS v2.0+ -->
                        <div class="flex flex-col">
                            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Name
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Description
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                        Status
                                                    </th>
                                                    <th scope="col" class="relative px-6 py-3">
                                                        <span class="sr-only">Edit</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <tr v-for="subTask in $page['props']['subTasks'] || []" :key="subTask.id">
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="flex items-center">
                                                            <div class="ml-4">
                                                                <div class="text-sm text-gray-500">
                                                                    {{ subTask.name }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <div class="text-sm text-gray-900">
                                                            {{ subTask.description }}
                                                        </div>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                            {{ subTask.status }}
                                                        </span>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                        <jet-danger-button class="ml-2" @click="deleteSubTask(subTask)">
                                                            Delete
                                                        </jet-danger-button>
                                                    </td>
                                                </tr>

                                                <!-- More people... -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <jet-dialog-modal :show="showCreateSubTask" @close="closeModal">
            <template #title>
                Create Sub task
            </template>

            <template #content>
                <div class="overflow-hidden sm:rounded-lg">
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <form action="#">
                            <div class="shadow overflow-hidden sm:rounded-md">
                                <div class="px-4 py-5 sm:p-6">
                                    <div class="grid grid-cols-6 gap-6">
                                        <div class="col-span-3">
                                        
                                            <label for="first_name" class="block text-sm font-medium text-gray-700">Name</label>
                                            <input
                                                type="text"
                                                name="name"
                                                class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"
                                                v-model="formData.name" 
                                            />
                                        </div>

                                        <div class="col-span-6">
                                            <label for="street_address" class="block text-sm font-medium text-gray-700">Description</label>
                                            
                                            <div class="mt-1">
                                                <textarea
                                                    name="description"
                                                    rows="3" 
                                                    class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border-gray-300 rounded-md"
                                                    placeholder="Enter task description"
                                                    v-model="formData.description" 
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="createSubTask($page['props']['task'])">
                    Create
                </jet-danger-button>
            </template>
        </jet-dialog-modal>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetActionSection from '@/Jetstream/ActionSection'
    import JetDialogModal from '@/Jetstream/DialogModal'
    import JetDangerButton from '@/Jetstream/DangerButton'
    import JetInput from '@/Jetstream/Input'
    import JetInputError from '@/Jetstream/InputError'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton'

    export default {
        props: {
            errors: Object,
        },
        
        components: {
            AppLayout,
            JetActionSection,
            JetDangerButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
        },

        data() {
            return {
                statuses: [
                    'completed',
                    'pending',
                    'cancel'
                ],

                showCreateSubTask: false,

                formData: {
                    name: null,
                    description: null,
                },
            }
        },

        methods: {
            updateTask(task) {
                this.$inertia.put('/tasks/' + task.id, task);
            },

            closeModal() {
                this.showCreateSubTask = false;
            },

            showCreateSubTaskForm() {
                this.showCreateSubTask = true;
            },

            createSubTask(task) {
                this.$inertia.post('/tasks/' + task.id + '/sub-task', this.formData, {
                    onSuccess: (page) => {
                        this.showCreateSubTask = false;
                    }
                });
            },

            deleteSubTask(task) {
                
            }
        }
    }
</script>
