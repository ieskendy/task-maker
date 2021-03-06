<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Task List
            </h2>
        </template>

        <div class="uk-section">
            <div class="uk-container uk-container-large">
                <div class="uk-width-1-1 uk-flex uk-flex-right uk-margin uk-grid-small" uk-grid>
                    <div>
                        <a :href="route('create-task')" class="uk-button uk-button-secondary uk-border-rounded uk-width-small">Add Task</a>
                    </div>

                    <div>
                        <a :href="route('export-task')" class="uk-button uk-button-secondary uk-border-rounded uk-width-small">Export</a>
                    </div>
                </div>
                
                <div class="uk-grid uk-child-width-1-2@m uk-child-width-1-3@xl" uk-grid>
                    <div v-for="task in $page['props']['tasks']" :key="task.name">
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header">
                                <div class="uk-card-badge uk-border-rounded uk-text-capitalize">{{ task.status }}</div>
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand">
                                        <h3 class="uk-card-title uk-margin-remove-bottom">{{ task.name }}</h3>
                                        <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00">{{ task.created_at }}</time></p>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-body">
                                <p>{{ task.description }}</p>
                            </div>
                            <div class="uk-card-footer uk-text-right">
                                <div class="uk-grid-small uk-width-1-1 uk-flex uk-flex-right" uk-grid>
                                    <div>
                                        <a :href="route('task', [task.id])" class="uk-button uk-button-default  uk-text-bold uk-text-capitalize uk-border-rounded" type="button">View</a>
                                    </div>

                                    <div>
                                        <button
                                            class="uk-button uk-button-danger uk-text-bold uk-text-capitalize uk-border-rounded"
                                            type="button"
                                            @click="confirmTaskDeletion(task)"
                                            >Delete</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="confirmingTaskDeletion" @close="closeModal">
            <template #title>
                Delete Task
            </template>

            <template #content>
                Are you sure you want to delete this task?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="deleteTask(this.currentTask)">
                    Delete
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

    const tasks = [{}]
    export default {
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
                tasks,
                confirmingTaskDeletion: false,
                currentTask: null
            }
        },

        methods: {
            confirmTaskDeletion(task) {
                this.currentTask = task
                this.confirmingTaskDeletion = true
            },

            closeModal() {
                this.confirmingTaskDeletion = false
            },

            deleteTask(task) {
                this.$inertia.delete('/tasks', {
                    data: task,
                    onSuccess: (page) => {
                        this.confirmingTaskDeletion = false;
                    }
                })
            }
        }
    }
</script>
