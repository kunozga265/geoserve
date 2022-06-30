<template>
    <app-layout>
        <template #header>
            Update Project
        </template>

        <template #breadcrumbs>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a :href="route('projects')" class="heading-font uppercase inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        Projects
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="heading-font uppercase text-sm font-medium text-gray-500 dark:text-gray-400">
                        {{ project.data.name }}
                    </span>
                </div>
            </li>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                           Project Details
                        </div>
                    </div>
                    <div class="page-section-content">
                        <form @submit.prevent="submit" class="flex justify-center">
                            <div class="card w-full sm:max-w-md">

                                <jet-validation-errors class="mb-4" />

                                <div class="mb-4">
                                    <jet-label for="name" value="Name" />
                                    <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus autocomplete="geoserve-project-name"/>
                                </div>
                                <div class="mb-4">
                                    <jet-label for="client" value="Client" />
                                    <jet-input id="client" type="text" class="mt-1 block w-full" v-model="form.client" required autofocus autocomplete="geoserve-project-client"/>
                                </div>
                                <div class="mb-4">
                                    <jet-label for="site" value="Site" />
                                    <jet-input id="site" type="text" class="mt-1 block w-full" v-model="form.site" required autofocus autocomplete="geoserve-project-site"/>
                                </div>
                                <div class="text-center mt-8">
                                    <jet-button class="ml-4 text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Edit
                                    </jet-button>
                                </div>
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DoughnutChart from "@/Components/Charts/DoughnutChart";
    import BarChart from "@/Components/Charts/BarChart";
    import PieChart from "@/Components/Charts/PieChart";
    import JetButton from "@/Jetstream/Button";
    import JetInput from '@/Jetstream/Input'
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        props:['project'],
        components: {
            AppLayout,
            DoughnutChart,
            BarChart,
            JetInput,
            PieChart,
            JetLabel,
            JetButton,
            JetValidationErrors
        },
        data(){
          return{
              form: this.$inertia.form({
                  name:this.project.data.name,
                  client:this.project.data.client,
                  site:this.project.data.site,
              })
          }
        },
        methods:{
            submit() {
                this.form.post(this.route('projects.update',{id:this.project.data.id}))
            }
        }

    }
</script>
