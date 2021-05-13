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
                    <div class="col-span-3">
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

                    <div class="col-span-3">
                        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <button
                                    type="submit"
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Add Sub Task
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import JetInputError from '@/Jetstream/InputError'

    export default {
        props: {
            errors: Object,
        },
        
        components: {
            AppLayout,
            JetInputError
        },

        data() {
            return {
                statuses: [
                    'completed',
                    'pending',
                    'cancel'
                ],
            }
        },

        methods: {
            updateTask(task) {
                this.$inertia.put('/tasks/' + task.id, task);
            }
        }
    }
</script>
