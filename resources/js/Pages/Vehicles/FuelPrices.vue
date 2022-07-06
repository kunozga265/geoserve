<template>
    <app-layout>
        <template #header>
            Edit Fuel Prices
        </template>

        <template #breadcrumbs>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <a :href="route('vehicles')" class="heading-font uppercase inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                        Vehicles
                    </a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="heading-font uppercase text-sm font-medium text-gray-500 dark:text-gray-400">
                        Fuel Prices
                    </span>
                </div>
            </li>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                           Fuel Details
                        </div>
                    </div>
                    <div class="page-section-content">
                        <form @submit.prevent="submit" class="flex justify-center">
                            <div class="card w-full sm:max-w-md">

                                <jet-validation-errors class="mb-4" />

                                <div class="mb-4">
                                    <jet-label for="petrol" value="Petrol" />
                                    <jet-input id="petrol" type="text" class="mt-1 block w-full" v-model="form.petrol" required autofocus autocomplete="geoserve-petrol"/>
                                </div>
                                <div class="mb-4">
                                    <jet-label for="diesel" value="Diesel" />
                                    <jet-input id="diesel" type="text" class="mt-1 block w-full" v-model="form.diesel" required autofocus autocomplete="geoserve-diesel"/>
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
        props:['petrol','diesel'],
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
                  petrol:this.petrol,
                  diesel:this.diesel,
              })
          }
        },
        methods:{
            submit() {
                this.form.post(this.route('gases.update'))
            }
        }

    }
</script>
