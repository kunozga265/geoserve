<template>
    <app-layout>
        <template #header>
            {{vehicle.vehicleRegistrationNumber}}
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
                        Vehicle
                    </span>
                </div>
            </li>
        </template>

        <template #actions v-if="!vehicle.verified">
            <primary-button v-if="checkRole($page.props.auth.data,'administrator')" @click.native="edit">Edit</primary-button>
            <primary-button v-if="checkRole($page.props.auth.data,'management')" @click.native="verifyDialog=true">Verify</primary-button>
            <danger-button @click.native="deleteDialog=true">Delete</danger-button>
        </template>

        <dialog-modal :show="deleteDialog" @close="deleteDialog=false">
            <template #title>
                Delete Vehicle
            </template>

            <template #content>
                Are you sure you want to delete {{ vehicle.vehicleRegistrationNumber }} vehicle?
                Once you delete, this vehicle will no longer be available.
            </template>

            <template #footer>
                <secondary-button @click.native="deleteDialog=false">
                    Cancel
                </secondary-button>

                <danger-button class="ml-2" @click.native="deleteVehicle" :disabled="form.processing">
                    <svg v-show="form.processing" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                    Delete
                </danger-button>
            </template>
        </dialog-modal>
        <dialog-modal :show="verifyDialog" @close="verifyDialog=false">
            <template #title>
                Verify Vehicle
            </template>

            <template #content>
                Are you sure you want to verify {{ vehicle.vehicleRegistrationNumber }} project?
            </template>

            <template #footer>
                <secondary-button @click.native="verifyDialog=false">
                    Cancel
                </secondary-button>

                <primary-button class="ml-2" @click.native="verifyVehicle" :disabled="form.processing">
                    <svg v-show="form.processing" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                    </svg>
                    Verify
                </primary-button>
            </template>
        </dialog-modal>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Vehicle Information
                        </div>
                    </div>
                    <div class="page-section-content">
                        <div class=" md:flex">
                            <div v-if="vehicle.photo" class="card justify-center">
                                <img class="w-64 sm:w-80 lg:w-96 mx-auto" :src="fileUrl(vehicle.photo)" alt="Vehicle photo">
                            </div>
                            <div class="card profile md:w-full">
                                <div class="p-8 md:p-10 grid grid-cols-1 sm:grid-cols-2">
                                    <div class="mb-4">
                                        <div class="text-sm text-gray-600">Registration Number</div>
                                        <span class="mr-2 role rounded py-1 px-2 bg-gray-200 text-gray-600 text-sm font-bold uppercase">
                                        {{vehicle.vehicleRegistrationNumber}}
                                    </span>
                                    </div>
                                    <div class="mb-4">
                                        <div class="text-sm text-gray-600">Fuel Type</div>
                                        <span class="mr-2 role rounded py-1 px-2 bg-gray-200 text-gray-600 text-sm font-bold uppercase">
                                            {{vehicle.gas.type}}
                                        </span>
                                    </div>
                                    <div class="mb-4">
                                        <div class="text-sm text-gray-600">Mileage</div>
                                        <span class="mr-2 role rounded py-1 px-2 bg-gray-200 text-gray-600 text-sm font-bold uppercase">
                                            {{numberWithCommas(vehicle.mileage)}}KM
                                        </span>
                                    </div>
                                    <div v-if="vehicle.lastRefillDate" class="mb-4">
                                        <div class="text-sm text-gray-600">Last Refill Date</div>
                                        <span class="mr-2 role rounded py-1 px-2 bg-gray-200 text-gray-600 text-sm font-bold uppercase">
                                        {{getDate(vehicle.lastRefillDate*1000)}}
                                    </span>
                                    </div>
                                    <div v-if="vehicle.lastRefillFuelReceived" class="mb-4">
                                        <div class="text-sm text-gray-600">Last Refill Fuel Received</div>
                                        <span class="mr-2 role rounded py-1 px-2 bg-gray-200 text-gray-600 text-sm font-bold uppercase">
                                        {{numberWithCommas(vehicle.lastRefillFuelReceived)}}
                                    </span>
                                    </div>
                                    <div v-if="vehicle.lastRefillMileageCovered" class="mb-4">
                                        <div class="text-sm text-gray-600">Last Refill Mileage Covered</div>
                                        <span class="mr-2 role rounded py-1 px-2 bg-gray-200 text-gray-600 text-sm font-bold uppercase">
                                        {{numberWithCommas(vehicle.lastRefillMileageCovered)}}KM
                                    </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div v-if="vehicle.verified !== 0" class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Overview
                        </div>
                    </div>
                    <div class="page-section-content grid grid-cols-1 lg:grid-cols-2">
                        <div class="card flex justify-center">
                            <div class="h-64 w-64 sm:h-80 sm:w-80 mx-auto relative">
                                <div class="pie-chart absolute font-bold flex justify-center items-center">
                                    <div class="heading">
                                        <div class="font-bold heading-font text-center">{{ totalRequests }}</div>
                                        <div class="xl font-bold heading-font text-center">{{ totalRequests==1?'Request':'Requests' }}</div>
                                    </div>
                                </div>
                                <PieChart
                                    :chart-options="typesChartOptions"
                                    :chart-data="typesData"
                                    chart-id="types"
                                    dataset-id-key="types"
                                />
                            </div>
                        </div>
                        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1">
                            <div class="card">
                                <div class="flex justify-start items-center">
                                    <div v-if="approvedRequestsCount>0" class="overview-chart relative">
                                        <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                            {{ Math.floor((approvedRequestsCount/totalRequests)*100) }}%
                                        </div>
                                        <DoughnutChart
                                            :chart-options="chartOptions"
                                            :chart-data="approvedData"
                                            chart-id="approved"
                                            dataset-id-key="approved"
                                        />
                                    </div>
                                    <div class="ml-4">
                                        <div class="heading-font" style="font-weight: 600;">Approved</div>
                                        <div class="text-sm text-gray-400">{{ approvedRequestsCount }} {{ approvedRequestsCount ==1?'Request':'Requests'}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="flex justify-start items-center">
                                    <div v-if="pendingRequestsCount>0" class="overview-chart relative">
                                        <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                            {{ Math.floor((pendingRequestsCount/totalRequests)*100) }}%
                                        </div>
                                        <DoughnutChart
                                            :chart-options="chartOptions"
                                            :chart-data="pendingData"
                                            chart-id="pending"
                                            dataset-id-key="pending"
                                        />
                                    </div>
                                    <div class="ml-4">
                                        <div class="heading-font" style="font-weight: 600;">Pending</div>
                                        <div class="text-sm text-gray-400">{{ pendingRequestsCount }} {{ pendingRequestsCount ==1?'Request':'Requests'}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="flex justify-start items-center">
                                    <div v-if="deniedRequestsCount>0" class="overview-chart relative">
                                        <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                            {{ Math.floor((deniedRequestsCount/totalRequests)*100) }}%
                                        </div>
                                        <DoughnutChart
                                            :chart-options="chartOptions"
                                            :chart-data="deniedData"
                                            chart-id="denied"
                                            dataset-id-key="denied"
                                        />
                                    </div>
                                    <div class="ml-4">
                                        <div class="heading-font" style="font-weight: 600;">Denied</div>
                                        <div class="text-sm text-gray-400">{{ deniedRequestsCount }} {{ deniedRequestsCount ==1?'Request':'Requests'}}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="flex justify-start items-center">
                                    <div v-if="closedRequestsCount>0" class="overview-chart relative">
                                        <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                            {{ Math.floor((closedRequestsCount/totalRequests)*100) }}%
                                        </div>
                                        <DoughnutChart
                                            :chart-options="chartOptions"
                                            :chart-data="completedData"
                                            chart-id="complete"
                                            dataset-id-key="complete"
                                        />
                                    </div>
                                    <div class="ml-4">
                                        <div class="heading-font" style="font-weight: 600;">Closed</div>
                                        <div class="text-sm text-gray-400">{{ closedRequestsCount }} {{ closedRequestsCount ==1?'Request':'Requests'}}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div v-if="vehicle.verified !== 0" class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Active Requests
                        </div>
                    </div>
                    <div class="page-section-content grid grid-cols-1 md:grid-cols-2">
                        <request
                            v-for="(request,index) in activeRequests.data"
                            :key="index"
                            :request="request"
                        />
                        <div v-if="activeRequests.data.length === 0" class="text-center text-gray-400 md:col-span-2 text-sm">
                            No Active Requests
                        </div>
                    </div>
                </div>
                <div v-if="vehicle.verified !== 0" class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Closed Requests
                        </div>
                    </div>
                    <div class="page-section-content grid grid-cols-1 md:grid-cols-2">
                        <request
                            v-for="(request,index) in closedRequests.data"
                            :key="index"
                            :request="request"
                        />
                        <div v-if="closedRequests.data.length === 0" class="text-center text-gray-400 md:col-span-2 text-sm">
                            No Requests Closed
                        </div>
                    </div>
                </div>
<!--                <div class="mt-4 flex flex-col items-center justify-start">
                    &lt;!&ndash; Help text &ndash;&gt;
                    <span class="text-sm text-gray-700 dark:text-gray-400">
                                    Showing <span class="font-semibold text-gray-900 dark:text-white">1</span> to <span class="font-semibold text-gray-900 dark:text-white">10</span> of <span class="font-semibold text-gray-900 dark:text-white">100</span> Entries
                                </span>
                    <div class="inline-flex mt-2 xs:mt-0">
                        &lt;!&ndash; Buttons &ndash;&gt;
                        <button class="inline-flex items-center py-2 px-4 text-sm font-medium text-white bg-gray-800 rounded-l hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                            Prev
                        </button>
                        <button class="inline-flex items-center py-2 px-4 text-sm font-medium text-white bg-gray-800 rounded-r border-0 border-l border-gray-700 hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            Next
                            <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                </div>-->
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DoughnutChart from "@/Components/Charts/DoughnutChart";
    import PieChart from "@/Components/Charts/PieChart";
    import PrimaryButton from "@/Jetstream/Button";
    import SecondaryButton from "@/Jetstream/SecondaryButton";
    import DangerButton from "@/Jetstream/DangerButton";
    import DialogModal from "@/Jetstream/DialogModal";
    import Request from "@/Components/Request";

    export default {
        props:[
            'totalRequests',
            'cashRequestsCount',
            'materialsRequestsCount',
            'vehicleMaintenanceRequestsCount',
            'fuelRequestsCount',
            'approvedRequestsCount',
            'pendingRequestsCount',
            'deniedRequestsCount',
            'closedRequestsCount',
            'activeRequests',
            'closedRequests',
        ],
        components: {
            AppLayout,
            DoughnutChart,
            PieChart,
            PrimaryButton,
            SecondaryButton,
            DangerButton,
            DialogModal,
            Request
        },
        data(){
          return{
              deleteDialog:false,
              verifyDialog:false,
              chartOptions:{
                  plugins: {
                      tooltip: {
                          enabled: false
                      },
                      legend:{
                          display:false
                      }
                  }, cutout:20
              },
              approvedData:{
                  datasets: [{
                      data: [this.approvedRequestsCount, (this.totalRequests - this.approvedRequestsCount)],
                      backgroundColor: ['#22c55e','#e3ebf6'],
                  }],
              },
              pendingData:{
                  datasets: [{
                      data: [this.pendingRequestsCount, (this.totalRequests - this.pendingRequestsCount)],
                      backgroundColor: ['#eab308','#e3ebf6'],
                  }],
              },
              deniedData:{
                  datasets: [{
                      data: [this.deniedRequestsCount, (this.totalRequests - this.deniedRequestsCount)],
                      backgroundColor: ['#ef4444','#e3ebf6'],
                  }],
              },
              completedData:{
                  datasets: [{
                      data: [this.closedRequestsCount, (this.totalRequests - this.closedRequestsCount)],
                      backgroundColor: ['#303840','#e3ebf6'],
                  }],
              },
              typesData:{
                  datasets: [{
                      data: [
                          this.cashRequestsCount,
                          this.materialsRequestsCount,
                          this.vehicleMaintenanceRequestsCount,
                          this.fuelRequestsCount
                      ],
                      backgroundColor: ['#1a56db','#ed0b4b','#b1bbc9','#e3ebf6'],
                  }],
                  labels: ['Cash', 'Materials', 'Vehicle Maintenance', 'Fuel']
              },
              typesChartOptions:{
                  plugins: {
                      tooltip: {
                          enabled: true
                      },
                      legend:{
                          display:true,
                          position:'bottom'
                      }
                  },
                  cutout:70
              },
              form: this.$inertia.form({}),
          }
        },
        computed:{
            vehicle(){
                return this.$page.props.vehicle.data
            }
        },
        methods:{
            edit(){
                this.$inertia.get(this.route('vehicles.edit',{'id':this.vehicle.id}))
            },
            deleteVehicle(){
                this.form
                    .post(this.route('vehicles.delete',{'id':this.vehicle.id}),{
                        preserveScroll:true,
                        onSuccess: () => this.deleteDialog=false
                    })
            },
            verifyVehicle(){
                this.form
                    .post(this.route('vehicles.verify',{'id':this.vehicle.id}),{
                        preserveScroll:true,
                        onSuccess: () => this.verifyDialog=false
                    })
            }
        }
    }
</script>
