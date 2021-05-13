<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Trashed Task
            </h2>
        </template>

        <div class="uk-section">
            <div class="uk-container uk-container-large">
                <div class="uk-grid uk-child-width-1-2@m uk-child-width-1-3@xl" uk-grid>
                    <div v-for="task in $page['props']['tasks']" :key="task.name">
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header">
                                <div class="uk-card-badge uk-border-rounded uk-text-capitalize">{{ task.status }}</div>
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand">
                                        <h3 class="uk-card-title uk-margin-remove-bottom">{{ task.name }}</h3>
                                        <p class="uk-text-meta uk-margin-remove-top">Deleted At {{ task.deleted_at }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-body">
                                <p>{{ task.description }}</p>
                            </div>
                            <div class="uk-card-footer uk-text-right">
                                <div class="uk-grid-small uk-width-1-1 uk-flex uk-flex-right" uk-grid>
                                    <div>
                                        <button
                                            class="uk-button uk-button-primary   uk-text-bold uk-text-capitalize uk-border-rounded"
                                            type="button"
                                            @click="restoration(task)"
                                            >Restore</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="confirmingRestoration" @close="closeModal">
            <template #title>
                Restore Task
            </template>

            <template #content>
                Are you sure you want to restore this task?
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-danger-button class="ml-2" @click="restoreTask(this.currentTask)">
                    Restore
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
                currentTask: null,
                confirmingRestoration: false,
            }
        },

        methods: {
            restoration(task) {
                this.currentTask = task;
                this.confirmingRestoration = true;
            },

            closeModal() {
                this.confirmingRestoration = false;
            },

            restoreTask(task) {
                this.$inertia.post('/tasks/restore', task, {
                    onSuccess: (page) => {
                        this.confirmingRestoration = false;
                    }
                })
            }
        }
    }
</script>
