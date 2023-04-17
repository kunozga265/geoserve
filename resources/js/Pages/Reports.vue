<template>
    <app-layout>
        <template #header>
            Reports
        </template>

        <template #breadcrumbs>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="heading-font uppercase text-sm font-medium text-gray-500 dark:text-gray-400">
                        Reports
                    </span>
                </div>
            </li>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <form @submit.prevent="submit">
                    <div class="page-section">
                        <div class="page-section-header">
                            <div class="page-section-title">
                               Generate a report
                            </div>
                        </div>
                        <div class="page-section-content flex justify-center">

                            <div class="card w-full sm:max-w-md md:max-w-3xl">

                                <jet-validation-errors class="mb-4" />

                                <div class="p-2 mb-2">
                                    <jet-label for="type" value="Filter By" />
                                    <select v-model="type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  required>
                                        <option value="NONE">None</option>
                                        <option
                                            v-for="(type,index) in types"
                                            :value="type.value"
                                            :key="index"
                                        >
                                            {{ type.name}}
                                        </option>
                                    </select>
                                </div>

                                <div  class="grid grid-cols-1 md:grid-cols-2">

                                    <div v-if="type === 'PROJECT'" class="p-2 mb-2 md:col-span-2">
                                        <jet-label for="project" value="Project Name" />
                                        <select v-model="projectIndex" id="project" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  required>
                                            <option value="-1">None</option>
                                            <option
                                                v-for="(project,index) in projects.data"
                                                :value="index"
                                                :key="index"
                                                v-if="project.verified==1 && project.status==1"
                                            >
                                                {{ project.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="p-2 mb-2" v-if="project && type === 'PROJECT'">
                                        <jet-label for="projectClient" value="Project Client" />
                                        <jet-input id="projectClient" type="text" class="block w-full" v-model="project.client" disabled/>
                                    </div>
                                    <div class="p-2 mb-2" v-if="project && type === 'PROJECT'">
                                        <jet-label for="projectSite" value="Project Site" />
                                        <jet-input id="projectSite" type="text" class="block w-full" v-model="project.site" disabled/>
                                    </div>

                                    <div class="p-2 mb-2 md:col-span-2" v-if="type === 'VEHICLE'">
                                        <jet-label for="vehicleMaintenanceVehicleId" value="Vehicle Registration" />
                                        <select v-model="vehicleMaintenanceVehicleId" id="vehicleMaintenanceVehicleId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  required>
                                            <option value="-1">Select Vehicle Registration</option>
                                            <option
                                                v-for="(vehicle,index) in vehicles.data"
                                                :value="vehicle.id"
                                                :key="index"
                                                v-if="vehicle.verified==1 && vehicle.status==1"
                                            >
                                                {{ vehicle.vehicleRegistrationNumber}}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="p-2 mb-2 md:col-span-2" v-if="type === 'USER'">
                                        <jet-label for="userId" value="System Users" />
                                        <select v-model="userId" id="userId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  required>
                                            <option value="-1">Select User</option>
                                            <option
                                                v-for="(user,index) in users.data"
                                                :value="user.id"
                                                :key="index"
                                                v-if="!checkRole(user,'unverified')"
                                            >
                                                {{ user.firstName}} {{ user.middleName}} {{ user.lastName}}
                                            </option>
                                        </select>
                                    </div>


<!--                                    Disabled Querry Pending or Denied Requests-->
<!--                                    <div class="p-2 mb-2">
                                        <jet-label for="requestStatus" value="Requests Status" />
                                            <div class="flex items-center">
                                                <input v-model="checkboxApproved" id="approved" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 w-4 h-4"/>
                                                <label for="approved" class="mb-0 ml-2 block text-sm font-medium text-gray-900 dark:text-gray-300">Approved</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input v-model="checkboxPending" id="pending" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 w-4 h-4"/>
                                                <label for="pending" class="mb-0 ml-2 block text-sm font-medium text-gray-900 dark:text-gray-300">Pending</label>
                                            </div>
                                            <div class="flex items-center">
                                                <input v-model="checkboxDenied" id="denied" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 w-4 h-4"/>
                                                <label for="denied" class="mb-0 ml-2 block text-sm font-medium text-gray-900 dark:text-gray-300">Denied</label>
                                            </div>
                                    </div>-->

                                    <div class="p-2 mb-2 md:col-span-2">
                                        <jet-label for="range" value="Select Range" />
                                        <vue-date-time-picker
                                            color="#1a56db"
                                            v-model="range"
                                            range
                                        />
                                    </div>
                                    <div class="p-2 mb-2">
                                        <jet-label for="requestType" value="Request Type" />
                                        <!--                                        <select v-model="form.requestType" id="requestType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  required multiple>-->
                                        <!--                                            <option value="ALL">All</option>-->
                                        <!--                                            <option-->
                                        <!--                                                v-for="(type,index) in requestTypes"-->
                                        <!--                                                :value="type.value"-->
                                        <!--                                                :key="index"-->
                                        <!--                                                checked-->
                                        <!--                                            >-->
                                        <!--                                                {{ type.name}}-->
                                        <!--                                            </option>-->
                                        <!--                                        </select>-->
                                        <div class="flex items-center">
                                            <input v-model="checkboxCash" id="CASH" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 w-4 h-4"/>
                                            <label for="CASH" class="mb-0 ml-2 block text-sm font-medium text-gray-900 dark:text-gray-300">Cash Advance Authorisation</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input v-model="checkboxMaterials" id="MATERIALS" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 w-4 h-4"/>
                                            <label for="MATERIALS" class="mb-0 ml-2 block text-sm font-medium text-gray-900 dark:text-gray-300">Materials</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input v-model="checkboxVehicle" id="VEHICLE_MAINTENANCE" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 w-4 h-4"/>
                                            <label for="VEHICLE_MAINTENANCE" class="mb-0 ml-2 block text-sm font-medium text-gray-900 dark:text-gray-300">Vehicle Maintenance</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input v-model="checkboxFuel" id="FUEL" type="checkbox" class="text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 w-4 h-4"/>
                                            <label for="FUEL" value="" class="mb-0 ml-2  block text-sm font-medium text-gray-900 dark:text-gray-300">Fuel </label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="fixed right-6 bottom-6 md:right-10 md:bottom-10">
                        <div v-show="!validation" id="toast-danger" class="flex items-center w-full max-w-xs p-4 mb-4 text-red-700 bg-red-100 rounded-lg shadow dark:text-red-400 dark:bg-red-800" role="alert">
                            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                                <i class="mdi mdi-alert-circle text-2xl"></i>
                            </div>
                            <div class="ml-3 text-sm font-normal">{{ error }}</div>
                        </div>
                    </div>



                    <div class="text-center mt-8">
                        <div v-show="validation">
                            <jet-button class="ml-4 text-center" :class="{ 'opacity-25': form.processing }" :disabled="loading">
                                <svg v-show="loading" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                </svg>
                                Generate
                            </jet-button>
                          </div>
                    </div>
                </form>
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
    import SecondaryButton from '@/Jetstream/SecondaryButton'
    import pdf from 'vue-pdf-embed/dist/vue2-pdf-embed'

    export default {
        props:['projects','vehicles','users'],
        components: {
            AppLayout,
            DoughnutChart,
            BarChart,
            JetInput,
            PieChart,
            JetLabel,
            JetButton,
            JetValidationErrors,
            SecondaryButton,
            pdf,
        },
        data(){
          return{
              loading:false,
              form: this.$inertia.form({

                  // requestType:'ALL',
              }),
              type:'NONE',
              projectIndex:-1,
              types:[
                  {
                      'name':'Project',
                      'value':'PROJECT'
                  },
                  {
                      'name':'Vehicle',
                      'value':'VEHICLE'
                  },
                  {
                      'name':'User',
                      'value':'USER'
                  },
              ],
              checkboxCash:true,
              checkboxMaterials:true,
              checkboxVehicle:true,
              checkboxFuel:true,
              checkboxApproved:true,
              checkboxPending:false,
              checkboxDenied:false,
              requestTypes:[
                  {
                      'name':'Cash Advance Authorisation Form',
                      'value':'CASH'
                  },
                  {
                      'name':'Materials Request Form',
                      'value':'MATERIALS'
                  },
                  {
                      'name':'Vehicle Maintenance Request Form',
                      'value':'VEHICLE_MAINTENANCE'
                  },
                  {
                      'name':'Fuel Request Form',
                      'value':'FUEL'
                  },
              ],
              statusTypes:[
                  {
                      'name':'Approved',
                      'value':'1'
                  },
                  {
                      'name':'Pending',
                      'value':'0'
                  },
                  {
                      'name':'Denied',
                      'value':'2'
                  },
              ],
              vehicleMaintenanceVehicleId:-1,
              fuelVehicleIndex:-1,
              userId:-1,
              quotes:[],
              error:'',
              range:null,
          }
        },
        created(){


        },
        computed:{
            project(){
                if (this.projectIndex === -1 || this.projectIndex === '-1')
                    return null
                else
                    return this.projects.data[this.projectIndex]
            },
            fuelVehicle(){
                if (this.fuelVehicleIndex === -1 || this.fuelVehicleIndex === '-1')
                    return null
                else
                    return this.vehicles.data[this.fuelVehicleIndex]
            },
            startDate(){
                return this.range?(new Date(this.range.start).getTime())/1000:null
            },
            endDate(){
                return this.range?(new Date(this.range.end).getTime())/1000:null
            },
            selectedRequestTypes(){
                let types = [];
                if(this.checkboxCash)
                    types.push("CASH")
                if (this.checkboxMaterials)
                    types.push("MATERIALS")
                if (this.checkboxVehicle)
                    types.push("VEHICLE_MAINTENANCE")
                if (this.checkboxFuel)
                    types.push("FUEL")

                return types
            },
            selectedRequestStatus(){
                let statuses = [];
                if(this.checkboxApproved)
                    statuses.push(1,3,4)
                if (this.checkboxPending)
                    statuses.push(0)
                if (this.checkboxDenied)
                    statuses.push(2)
                return statuses
            },
            validation(){
                if(this.type==='PROJECT' && this.project === null){
                    this.error="Select a project"
                    return false
                }
                else if(this.type==='VEHICLE' && (this.vehicleMaintenanceVehicleId==='-1' || this.vehicleMaintenanceVehicleId===-1)) {
                    this.error = "Select vehicle registration"
                    return false
                }
                /*else if(this.type==='USER'){

                }*/
                if(this.range === null){
                    this.error="Select a range"
                    return false
                }else {
                    return true
                }
            }
        },
        methods: {
            submit() {
                const projectId = this.project ? this.project.id : null
                /*this.form
                    .transform(data => ({
                        ...data,
                        'projectId': projectId,
                        vehicleId:  this.vehicleMaintenanceVehicleId,
                        startDate: this.startDate,
                        endDate: this.endDate,
                        requestType:this.selectedRequestTypes,
                        requestStatus:this.selectedRequestStatus,
                    }))
                    .get(this.route('reports.generate'))*/
                this.loading = true;
                axios.post(this.fileUrl("api/1.0.0/reports/generate"),{
                    'type': this.type,
                    'projectId': projectId,
                    'userId': this.userId,
                    vehicleId:  this.vehicleMaintenanceVehicleId,
                    startDate: this.startDate,
                    endDate: this.endDate,
                    requestType:this.selectedRequestTypes,
                    requestStatus:this.selectedRequestStatus,

                    },{ responseType: "blob" }).then(res => {
                    const headerContentDisp = res.headers["content-disposition"];
                    const filename =
                        headerContentDisp &&
                        headerContentDisp.split("filename=")[1].replace(/["']/g, ""); // TODO improve parcing
                    const contentType = res.headers["content-type"];

                    const blob = new Blob([res.data], { contentType });
                    const href = window.URL.createObjectURL(blob);

                    const el = document.createElement("a");
                    el.setAttribute("href", href);
                    el.setAttribute(
                        "download",
                        filename || (config && config.filename) || "someFile"
                    );
                    el.click();

                    this.loading = false;

                    window.URL.revokeObjectURL(blob);
                    return res;
                });

            },
        }
    }
</script>
