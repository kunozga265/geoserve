<template>
    <app-layout>
        <template #header>
            New Vehicle
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
                        Create
                    </span>
                </div>
            </li>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                           Vehicle Details
                        </div>
                    </div>
                    <div class="page-section-content">
                        <form @submit.prevent="submit" class="flex justify-center">
                            <div class="card w-full sm:max-w-md">

                                <jet-validation-errors class="mb-4" />

                                <div v-if="form.photo !==''" class="mb-4">
                                    <img class="w-full" :src="fileUrl(form.photo)" alt="Vehicle Photo">
                                </div>

                                <div class="mb-4">
                                    <jet-label for="photo" value="Photo" />
                                    <input type="file" id="photo" @input="photoUpload($event.target.files[0])" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
                                </div>

                                <div class="mb-4">
                                    <jet-label for="vehicleRegistrationNumber" value="Registration Number" />
                                    <jet-input id="vehicleRegistrationNumber" type="text" class="mt-1 block w-full" v-model="form.vehicleRegistrationNumber" required autofocus autocomplete="geoserve-vehicle-vehicleRegistrationNumber"/>
                                </div>
                                <div class="mb-4">
                                    <jet-label for="mileage" value="Mileage" />
                                    <jet-input id="mileage" type="text" class="mt-1 block w-full" v-model="form.mileage" required autocomplete="geoserve-vehicle-mileage"/>
                                </div>
                                <div class="mb-4">
                                    <jet-label for="lastRefillDate" value="Last Refill Date" />
                                    <vue-date-time-picker
                                        color="#1a56db"
                                        v-model="date"
                                        :maxDate="today"
                                    />
                                </div>
                                <div class="mb-4">
                                    <jet-label for="lastRefillFuelReceived" value="Last Refill Fuel Received" />
                                    <jet-input id="lastRefillFuelReceived" type="text" class="mt-1 block w-full" v-model="form.lastRefillFuelReceived" autocomplete="geoserve-vehicle-lastRefillFuelReceived"/>
                                </div>
                                <div class="mb-4">
                                    <jet-label for="lastRefillMileageCovered" value="Last Refill Mileage Covered" />
                                    <jet-input id="lastRefillMileageCovered" type="text" class="mt-1 block w-full" v-model="form.lastRefillMileageCovered" autocomplete="geoserve-vehicle-lastRefillMileageCovered"/>
                                </div>
                                <div class="text-center mt-8">
                                    <jet-button class="ml-4 text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Create
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
                  photo:'',
                  vehicleRegistrationNumber:'',
                  mileage:'',
                  lastRefillFuelReceived:'',
                  lastRefillMileageCovered:'',
              }),
              date:null,
              today:new Date().toISOString(),
          }
        },
        computed:{
            lastRefillDate(){
                return this.date?(new Date(this.date).getTime())/1000:null
            }
        },
        methods:{
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        lastRefillDate:this.lastRefillDate
                    }))
                    .post(this.route('vehicles.store'))
            },
            photoUpload(file){
                const reader=new FileReader();
                if (file){
                    reader.readAsDataURL(file);
                    reader.onload=(e)=>{
                        axios.post(this.$page.props.publicPath+"api/1.0.0/upload",{
                            type:"VEHICLE",
                            file:e.target.result
                        }).then(res=>{
                            this.form.photo= res.data.file
                            document.getElementById('photo').value = ""
                        }).catch(function(res){
                            // this.form.errors.push(res.data.message)
                        })
                    };
                }
            },
        }

    }
</script>
