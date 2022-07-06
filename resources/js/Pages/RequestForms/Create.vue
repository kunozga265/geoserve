<template>
    <app-layout>
        <template #header>
            New Request
        </template>

        <template #breadcrumbs>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="heading-font uppercase text-sm font-medium text-gray-500 dark:text-gray-400">
                        Requests
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
                               General Details
                            </div>
                        </div>
                        <div class="page-section-content flex justify-center">

                            <div class="card w-full sm:max-w-md md:max-w-3xl">

                                <jet-validation-errors class="mb-4" />

                                <div class="p-2 mb-2">
                                    <jet-label for="type" value="Type" />
                                    <select v-model="form.type" id="type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  required>
                                        <option value="">Select type</option>
                                        <option
                                            v-for="(type,index) in types"
                                            :value="type.value"
                                            :key="index"
                                        >
                                            {{ type.name}}
                                        </option>
                                    </select>
                                </div>

                                <div v-if="form.type !=='FUEL'" class="grid grid-cols-1 md:grid-cols-2">
                                    <div class="p-2 mb-2">
                                        <jet-label for="personCollectingAdvance" value="Person Collecting Advance" />
                                        <jet-input id="personCollectingAdvance" type="text" class="block w-full" v-model="form.personCollectingAdvance" autocomplete="geoserve-person-collecting-advance"/>
                                    </div>

                                    <div v-if="form.type !== 'VEHICLE_MAINTENANCE'" class="p-2 mb-2">
                                        <jet-label for="project" value="Project" />
                                        <select v-model="projectIndex" id="project" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  required>
                                            <option value="-1">None</option>
                                            <option
                                                v-for="(project,index) in projects.data"
                                                :value="index"
                                                :key="index"
                                            >
                                                {{ project.name}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="p-2 mb-2" v-if="project && form.type !== 'VEHICLE_MAINTENANCE'">
                                        <jet-label for="projectClient" value="Project Client" />
                                        <jet-input id="projectClient" type="text" class="block w-full" v-model="project.client" disabled/>
                                    </div>
                                    <div class="p-2 mb-2" v-if="project && form.type !== 'VEHICLE_MAINTENANCE'">
                                        <jet-label for="projectSite" value="Project Site" />
                                        <jet-input id="projectSite" type="text" class="block w-full" v-model="project.site" disabled/>
                                    </div>

                                    <div class="p-2 mb-2" v-if="form.type === 'VEHICLE_MAINTENANCE'">
                                        <jet-label for="assessedBy" value="Assessed By" />
                                        <jet-input id="assessedBy" type="text" class="block w-full" v-model="form.assessedBy"/>
                                    </div>

                                    <div class="p-2 mb-2" v-if="form.type === 'VEHICLE_MAINTENANCE'">
                                        <jet-label for="vehicleMaintenanceVehicleId" value="Vehicle Registration" />
                                        <select v-model="vehicleMaintenanceVehicleId" id="vehicleMaintenanceVehicleId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  required>
                                            <option value="-1">Select Vehicle Registration</option>
                                            <option
                                                v-for="(vehicle,index) in vehicles.data"
                                                :value="vehicle.id"
                                                :key="index"
                                            >
                                                {{ vehicle.vehicleRegistrationNumber}}
                                            </option>
                                        </select>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="form.type !=='FUEL'" class="page-section">
                        <div class="page-section-header">
                            <div class="page-section-title">
                                Breakdown
                            </div>
                        </div>
                        <div class="page-section-content flex justify-center">

                            <div class="card w-full sm:max-w-md md:max-w-3xl">

                                <div class="p-2 mb-2 relative overflow-x-auto">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="heading-font">

                                            </th>
                                            <th scope="col" class="heading-font">
                                                Details
                                            </th>
                                            <th v-if="form.type ==='MATERIALS'" scope="col" class="heading-font">
                                                Units
                                            </th>
                                            <th scope="col" class="heading-font">
                                                Quantity
                                            </th>
                                            <th scope="col" class="heading-font">
                                                Unit Cost
                                            </th>
                                            <th scope="col" class="heading-font">
                                                Total Cost
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr
                                            class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700"
                                            v-for="(info,index) in form.information"
                                            :key="index"
                                        >
                                            <th scope="row" class="px-2">
                                                <i @click="removeRecord(index)" class="mdi mdi-close-circle text-red-600 focus:ring-4 focus:outline-none focus:ring-red-300 cursor"></i>
                                            </th>
                                            <th scope="row" class="py-2 pr-1 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                <jet-input type="text" class="block w-full" v-model="info.details" />
                                            </th>
                                            <td v-if="form.type ==='MATERIALS'" class="py-2 pr-1">
                                                <jet-input type="text" class="block w-full" v-model="info.units" />
                                            </td>
                                            <td class="py-2 pr-1">
                                                <jet-input type="text" class="block w-full" v-model="info.quantity" />
                                            </td>
                                            <td class="py-2 pr-1">
                                                <jet-input type="text" class="block w-full" v-model="info.unitCost" />
                                            </td>
                                            <td class="py-2 pr-1">
                                                <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                                    {{numberWithCommas((info.quantity*info.unitCost).toFixed(2))}}
                                                </div>
<!--                                                <jet-input type="text" class="block w-full" v-model="info.totalCost" value="23" />-->
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div @click="addRecord" class="mt-2 ml-2 flex justify-start items-center cursor">
                                        <div>
                                            <i class="mdi mdi-plus-circle text-blue-600"></i>
                                        </div>
                                        <div  class="ml-2 text-blue-600 text-sm">
                                            Add Record
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <div v-if="isNaN(totalCost)" class="text-red-600 uppercase font-semibold heading-font">
                                            Enter valid total cost
                                        </div>
                                        <div v-else class="flex justify-center items-center ">
                                            <div class="currency ">MK</div>
                                            <div class="total">{{ numberWithCommas(totalCost) }}</div>
                                        </div>
                                        <div class="text-gray-600 text-xs">Total Cost</div>
                                    </div>
                                    <div class="mt-4 text-gray-600 text-sm">
                                        I accept the advances listed above and I acknowledge that I must return the full amount or account for it on a company expense form within 3 days of returning to Geoserve from this assignment.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div v-if="form.type !=='FUEL'" class="page-section">
                        <div class="page-section-header">
                            <div class="page-section-title">
                                Quotes
                            </div>
                        </div>
                        <div class="page-section-content flex justify-center">
                            <div class="card w-full sm:max-w-md md:max-w-3xl">

                                <div class="mb-4">
                                    <jet-label for="quote" value="Upload quote" />
                                    <input type="file" id="quote" @input="fileUpload($event.target.files[0])" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
                                </div>

                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
                                    <div
                                        v-for="(quote,index) in quotes"
                                        :key="index"
                                    >
                                        <div class="relative" v-if="quote.ext === 'pdf'">
                                            <i @click="removeQuote(index)" style="top:-12px; right:-12px;  z-index: 2;" class="cursor mdi mdi-close-circle text-red-600 absolute right-0 text-2xl"></i>
                                            <div style="top: -6px; width: 20px; height: 20px; right: -10px; z-index: 1; border-radius: 50%;" class="h-9 w-9 bg-white absolute"></div>
                                            <pdf  class="w-32" :source="fileUrl(quote.file)"/>
                                        </div>
                                        <div class="relative" v-else>
                                            <i @click="removeQuote(index)" style="top:-12px; right:-12px;  z-index: 2;" class="cursor mdi mdi-close-circle text-red-600 absolute right-0 text-2xl"></i>
                                            <div style="top: -6px; width: 20px; height: 20px; right: -10px; z-index: 1; border-radius: 50%;" class="h-9 w-9 bg-white absolute"></div>
                                            <img class="w-32" :src="fileUrl(quote.file)" alt="Quote Image">
                                        </div>


                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div v-if="form.type ==='FUEL'" class="page-section">
                        <div class="page-section-header">
                            <div class="page-section-title">
                                Details
                            </div>
                        </div>
                        <div class="page-section-content flex justify-center">

                            <div class="card w-full sm:max-w-md md:max-w-3xl">
                                <div class="grid grid-cols-1 md:grid-cols-2">

                                    <div class="p-2 mb-2" :class="{ 'md:col-span-2': fuelVehicle==null}">
                                        <jet-label for="fuelVehicleId" value="Vehicle Registration" />
                                        <select v-model="fuelVehicleIndex" id="fuelVehicleId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  required>
                                            <option value="-1">Select Vehicle Registration</option>
                                            <option
                                                v-for="(vehicle,index) in vehicles.data"
                                                :value="index"
                                                :key="index"
                                            >
                                                {{ vehicle.vehicleRegistrationNumber}}
                                            </option>
                                        </select>
                                    </div>

                                    <div class="p-2 mb-2" v-if="fuelVehicle">
                                        <jet-label for="fuelVehicleMileage" value="Mileage" />
                                        <div class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                            {{numberWithCommas(fuelVehicle.mileage)}}
                                        </div>
<!--                                        <jet-input id="fuelVehicleMileage" type="text" class="block w-full" v-model="fuelVehicleMileage" disabled/>-->
                                    </div>

                                    <div class="p-2 mb-2 md:col-span-2">
                                        <jet-label for="driverName" value="Driver Name" />
                                        <jet-input id="driverName" type="text" class="block w-full" v-model="form.driverName" required/>
                                    </div>

                                    <div class="p-2 mb-2">
                                        <jet-label for="fuelRequestedLitres" value="Fuel Requested (In Litres)" />
                                        <jet-input id="fuelRequestedLitres" type="text" class="block w-full" v-model="form.fuelRequestedLitres" required/>
                                    </div>

                                    <div class="p-2 mb-2">
                                        <jet-label for="fuelRequestedMoney" value="Fuel Requested (Money Equivalent)"/>
                                        <div class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white">
                                            {{numberWithCommas(fuelRequestedMoney)}}
                                        </div>
                                        <span v-if="fuelVehicle" class="text-sm text-gray-600">@ K{{numberWithCommas(fuelVehicle.gas.perLitre)}}/Litre</span>
                                    </div>

                                    <div class="p-2 mb-2 md:col-span-2">
                                        <jet-label for="purpose" value="Purpose" />
                                        <textarea id="purpose" v-model="form.purpose" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" required></textarea>
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
                            <jet-button class="ml-4 text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                Create
                            </jet-button>
                            <div  class="text-gray-600 text-sm">Please confirm all details before submission</div>
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
        props:['projects','vehicles'],
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
              form: this.$inertia.form({
                  type:'',
                  personCollectingAdvance:'',
                  assessedBy:'',
                  fuelRequestedLitres:'',
                  purpose:'',
                  driverName:'',
                  information:[
                      {
                          "details":'',
                          "units":'',
                          "quantity":0,
                          "unitCost":0,
                          "totalCost":0,
                      },
                  ],
              }),
              projectIndex:-1,
              types:[
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
              vehicleMaintenanceVehicleId:-1,
              fuelVehicleIndex:-1,
              quotes:[],
              error:'',
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
            fuelRequestedMoney(){
                if (this.fuelVehicle && this.form.fuelRequestedLitres !== "" && !isNaN(this.form.fuelRequestedLitres))
                    return parseFloat((parseFloat(this.form.fuelRequestedLitres)*this.fuelVehicle.gas.perLitre).toFixed(2))
                else
                    return 0
            },
            totalCost(){
                let totalCost=0
                let currentTotal=0
                for (let x in this.form.information){
                    currentTotal=parseFloat(this.form.information[x].quantity * this.form.information[x].unitCost)
                    totalCost+=currentTotal
                    this.form.information[x].totalCost=parseFloat(currentTotal.toFixed(2))

                    //convert to numbers
                    this.form.information[x].quantity=parseFloat(this.form.information[x].quantity)
                    this.form.information[x].unitCost=parseFloat(this.form.information[x].unitCost)

                }
                return parseFloat(totalCost.toFixed(2))
            },
            quoteFiles(){
                let files=[]
                for (let x in this.quotes)
                    files.push(this.quotes[x].file)

                return files
            },
            validation(){
                if(this.form.type==='CASH' || this.form.type==='MATERIALS'){
                   if(isNaN(this.totalCost)) {
                       this.error="Enter valid breakdown details"
                       return false
                   }else if(this.totalCost <= 0) {
                       this.error="Enter breakdown details"
                       return false
                   }else
                       return true

                }else if(this.form.type==='VEHICLE_MAINTENANCE'){
                    if(this.vehicleMaintenanceVehicleId==='-1' || this.vehicleMaintenanceVehicleId===-1) {
                        this.error = "Select vehicle registration"
                        return false
                    }else if(isNaN(this.totalCost)) {
                        this.error="Enter valid breakdown details"
                        return false
                    }else if(this.totalCost <= 0) {
                        this.error="Enter breakdown details"
                        return false
                    }else
                        return true

                }else if(this.form.type==='FUEL'){
                    if(this.fuelVehicle===null) {
                        this.error = "Select vehicle registration"
                        return false
                    }else if(this.form.driverName==='' || this.form.driverName.length===0) {
                        this.error = "Enter a driver's name"
                        return false
                    }else if(this.form.fuelRequestedLitres==='' || this.form.fuelRequestedLitres.length===0) {
                        this.error = "Enter fuel requested (in litres)"
                        return false
                    }else if(isNaN(this.form.fuelRequestedLitres)) {
                        this.error = "Fuel requested (in litres) should be a number"
                        return false
                    }else if(this.fuelRequestedMoney===0) {
                        this.error = "Enter fuel requested (money equivalent)"
                        return false
                   /* }else if(isNaN(this.form.fuelRequestedMoney)) {
                        this.error = "Fuel requested (money equivalent) should be a number"
                        return false*/
                    }else if(this.form.purpose==='' || this.form.purpose.length===0) {
                        this.error = "Enter the purpose"
                        return false
                    }else
                        return true

                }else {
                    this.error="Select request type"
                    return false
                }

            }
        },
        methods:{
            submit() {
                let vehicleId=""
                if(this.form.type==='VEHICLE_MAINTENANCE')
                    vehicleId=this.vehicleMaintenanceVehicleId
                else if(this.form.type==='FUEL')
                    vehicleId=this.fuelVehicle.id

                const projectId=this.project?this.project.id:null
                this.form
                    .transform(data => ({
                        ... data,
                        'projectId': projectId,
                        total: this.totalCost,
                        quotes: this.quoteFiles,
                        vehicleId: vehicleId,
                        fuelRequestedMoney:this.fuelRequestedMoney
                    }))
                    .post(this.route('request-forms.store'))
            },
            addRecord(){
                this.form.information.push({
                    "details":'',
                    "units":'',
                    "quantity":0,
                    "unitCost":0,
                    "totalCost":0,
                })
            },
            removeRecord(index){
                this.form.information.splice(index,1)
            },
            fileUpload(file){
                const reader=new FileReader();
                if (file){
                    reader.readAsDataURL(file);
                    reader.onload=(e)=>{
                        axios.post(this.$page.props.publicPath+"api/1.0.0/upload",{
                            type:"QUOTE",
                            file:e.target.result
                        }).then(res=>{
                            this.quotes.push({
                                'file':res.data.file,
                                'ext':res.data.ext,
                            })
                            document.getElementById('quote').value = ""
                        }).catch(function(res){
                            // this.form.errors.push(res.data.message)
                        })
                    };
                }
            },
            removeQuote(index){
                const file=this.quotes[index].file
                //delete online
                axios.post(this.$page.props.publicPath+"api/1.0.0/upload/delete",{
                    'file':file
                })
                this.quotes.splice(index,1)
            },
        }

    }
</script>
