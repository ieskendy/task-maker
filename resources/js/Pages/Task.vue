<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Task List
            </h2>
        </template>

        <div class="uk-section">
            <div class="uk-container uk-container-large">
                <div class="uk-width-1-1 uk-flex uk-flex-right uk-margin">
                    <a :href="route('create-task')" class="uk-button uk-button-secondary uk-border-rounded uk-width-small">Add Task</a>
                </div>
                <div class="uk-grid uk-child-width-1-2@m uk-child-width-1-3@xl" uk-grid>
                    <div v-for="task in $page['props']['tasks']" :key="task.name">
                        <div class="uk-card uk-card-default">
                            <div class="uk-card-header">
                                <div class="uk-card-badge uk-border-rounded uk-text-capitalize">{{ task.status }}</div>
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-expand">
                                        <h3 class="uk-card-title uk-margin-remove-bottom">{{ task.name }}</h3>
                                        <p class="uk-text-meta uk-margin-remove-top"><time datetime="2016-04-01T19:00">April 01, 2016</time></p>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-card-body">
                                <p>{{ task.description }}</p>
                            </div>
                            <div class="uk-card-footer uk-text-right">
                                <div class="uk-grid-small uk-width-1-1 uk-flex uk-flex-right" uk-grid>
                                    <div>
                                        <button class="uk-button uk-button-default  uk-text-bold uk-text-capitalize uk-border-rounded" type="button">View</button>
                                    </div>

                                    <div>
                                        <button class="uk-button uk-button-danger uk-text-bold uk-text-capitalize uk-border-rounded" type="button">Delete</button>
                                    </div>
                                </div>
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
    const tasks = [{}]
    export default {
        components: {
            AppLayout
        },

        data() {
            return {
                tasks
            }
        },

        methods: {
            createTask() {
                console.log("Create")
            }
        }
    }
</script>
