<template>
    <app-layout>
        <template #header>
            Dashboard
        </template>

        <template #breadcrumbs>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="heading-font uppercase text-sm font-medium text-gray-500 dark:text-gray-400">Dashboard</span>
                </div>
            </li>
        </template>

        <template #actions v-if="!checkRole($page.props.auth.data,'unverified') && !checkRole($page.props.auth.data,'disabled')">
            <inertia-link :href="route('request-forms.create')">
                <primary-button>
                    New Request
                </primary-button>
            </inertia-link>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">

                <div v-if="checkRole($page.props.auth.data,'unverified')">
                    Unverified User
                </div>
                <div v-else-if="checkRole($page.props.auth.data,'disabled')">
                    Disabled User
                </div>
                <div v-else>
                    <div class="page-section">
                        <div class="page-section-header">
                            <div class="page-section-title">
                                Overview
                            </div>
                        </div>
                        <div class="page-section-content">
                            <div class="card">
                                <div class="md:p-8 w-full  mx-auto relative">
                                    <BarChart
                                        :chart-options="positionsChartOptions"
                                        :chart-data="positionsData"
                                    />
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                                <div class="card" v-if="awaitingApprovalCount>0">
                                    <div class="flex justify-start items-center">
                                        <div class="overview-chart relative">
                                            <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                                {{ Math.floor((awaitingApprovalCount/totalCount)*100) }}%
                                            </div>
                                            <DoughnutChart
                                                :chart-options="chartOptions"
                                                :chart-data="awaitingApprovalData"
                                                chart-id="awaitingApproval"
                                                dataset-id-key="awaitingApproval"
                                            />
                                        </div>
                                        <div class="ml-4">
                                            <div class="heading-font" style="font-weight: 600;">Awaiting Approval</div>
                                            <div class="text-sm text-gray-400">{{ awaitingApprovalCount }} {{ awaitingApprovalCount ==1?'Request':'Requests'}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" v-if="awaitingInitiationCount>0">
                                    <div class="flex justify-start items-center">
                                        <div class="overview-chart relative">
                                            <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                                {{ Math.floor((awaitingInitiationCount/totalCount)*100) }}%
                                            </div>
                                            <DoughnutChart
                                                :chart-options="chartOptions"
                                                :chart-data="awaitingInitiationData"
                                                chart-id="awaitingInitiation"
                                                dataset-id-key="awaitingInitiation"
                                            />
                                        </div>
                                        <div class="ml-4">
                                            <div class="heading-font" style="font-weight: 600;">Awaiting Initiation</div>
                                            <div class="text-sm text-gray-400">{{ awaitingInitiationCount }} {{ awaitingInitiationCount ==1?'Request':'Requests'}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" v-if="awaitingReconciliationCount>0">
                                    <div class="flex justify-start items-center">
                                        <div class="overview-chart relative">
                                            <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                                {{ Math.floor((awaitingReconciliationCount/totalCount)*100) }}%
                                            </div>
                                            <DoughnutChart
                                                :chart-options="chartOptions"
                                                :chart-data="awaitingReconciliationData"
                                                chart-id="awaitingReconciliation"
                                                dataset-id-key="awaitingReconciliation"
                                            />
                                        </div>
                                        <div class="ml-4">
                                            <div class="heading-font" style="font-weight: 600;">Awaiting Reconciliation</div>
                                            <div class="text-sm text-gray-400">{{ awaitingReconciliationCount }} {{ awaitingReconciliationCount ==1?'Request':'Requests'}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" v-if="activeCount>0">
                                    <div class="flex justify-start items-center">
                                        <div class="overview-chart relative">
                                            <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                                {{ Math.floor((activeCount/totalCount)*100) }}%
                                            </div>
                                            <DoughnutChart
                                                :chart-options="chartOptions"
                                                :chart-data="activeData"
                                                chart-id="active"
                                                dataset-id-key="active"
                                            />
                                        </div>
                                        <div class="ml-4">
                                            <div class="heading-font" style="font-weight: 600;">Active</div>
                                            <div class="text-sm text-gray-400">{{ activeCount }} {{ activeCount ==1?'Request':'Requests'}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" v-if="unverifiedUsersCount>0 && (checkRole($page.props.auth.data,'management') || checkRole($page.props.auth.data,'administrator'))">
                                    <div class="flex justify-start items-center">
                                        <div class="ml-3 mr-1 relative">
                                            <i class="mdi mdi-account-supervisor-circle" style="font-size: 32px; color:#eab308"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="heading-font" style="font-weight: 600;">Unverified Users</div>
                                            <div class="text-sm text-gray-400">{{unverifiedUsersCount}} {{unverifiedUsersCount==1?'User':'Users'}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" v-if="unverifiedProjectsCount>0 && (checkRole($page.props.auth.data,'management') || checkRole($page.props.auth.data,'administrator'))">
                                    <div class="flex justify-start items-center">
                                        <div class="ml-3 mr-1 relative">
                                            <i class="mdi mdi-home-group" style="font-size: 32px; color:#eab308"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="heading-font" style="font-weight: 600;">Unverified Projects</div>
                                            <div class="text-sm text-gray-400">{{unverifiedProjectsCount}} {{unverifiedProjectsCount==1?'Project':'Projects'}}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" v-if="unverifiedVehiclesCount>0 && (checkRole($page.props.auth.data,'management') || checkRole($page.props.auth.data,'administrator'))">
                                    <div class="flex justify-start items-center">
                                        <div class="ml-3 mr-1 relative">
                                            <i class="mdi mdi-car-multiple" style="font-size: 32px; color:#eab308"></i>
                                        </div>
                                        <div class="ml-4">
                                            <div class="heading-font" style="font-weight: 600;">Unverified Vehicles</div>
                                            <div class="text-sm text-gray-400">{{unverifiedVehiclesCount}} {{unverifiedVehiclesCount==1?'Vehicle':'Vehicles'}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="page-section">
                        <div class="page-section-header">
                            <div class="page-section-title">
                                Awaiting your action
                            </div>
                        </div>
                        <div class="page-section-content">
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <request
                                    v-for="(request,index) in toApprove.data"
                                    :key="index"
                                    :request="request"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="page-section">
                        <div class="page-section-header">
                            <div class="page-section-title">
                                Active Requests
                            </div>
                        </div>
                        <div class="page-section-content">
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <request
                                    v-for="(request,index) in active.data"
                                    :key="index"
                                    :request="request"
                                />
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
    import DoughnutChart from "@/Components/Charts/DoughnutChart";
    import BarChart from "@/Components/Charts/BarChart";
    import PrimaryButton from '@/Jetstream/Button'
    import Request from "@/Components/Request";

    export default {
        props:[
            'toApprove',
            'active',
            'awaitingApprovalCount',
            'awaitingInitiationCount',
            'awaitingReconciliationCount',
            'activeCount',
            'totalCount',
            'unverifiedUsersCount',
            'unverifiedVehiclesCount',
            'unverifiedProjectsCount',
            'dashboardReports',
        ],
        components: {
            AppLayout,
            DoughnutChart,
            BarChart,
            PrimaryButton,
            Request
        },
        data(){
          return{
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
              awaitingApprovalData:{
                  datasets: [{
                      data: [this.awaitingApprovalCount, (this.totalCount - this.awaitingApprovalCount)],
                      backgroundColor: ['#eab308','#e3ebf6'],
                  }],
              },
              awaitingInitiationData:{
                  datasets: [{
                      data: [this.awaitingInitiationCount, (this.totalCount - this.awaitingInitiationCount)],
                      backgroundColor: ['#22c55e','#e3ebf6'],
                  }],
              },
              awaitingReconciliationData:{
                  datasets: [{
                      data: [this.awaitingReconciliationCount, (this.totalCount - this.awaitingReconciliationCount)],
                      backgroundColor: ['#22c55e','#e3ebf6'],
                  }],
              },
              activeData:{
                  datasets: [{
                      data: [this.activeCount, (this.totalCount - this.activeCount)],
                      backgroundColor: ['#1a56db','#e3ebf6'],
                  }],
              },
              positionsData:{
                  datasets: [{
                      data: [],
                      backgroundColor: ['#1a56db','#ed0b4b','#b1bbc9','#e3ebf6'],

                  }],
                  labels: []
              },
              positionsChartOptions:{
                  plugins: {
                      tooltip: {
                          enabled: true
                      },
                      legend:{
                          display:false,
                      }
                  },
                  scales: {
                      xAxes: {
                          grid: {
                              display:false
                          }
                      },
                      yAxes: {
                          grid: {
                              display:false
                          }
                      },
                  },
                  maintainAspectRatio:false
              },
          }
        },

        created() {
            for(let x in this.dashboardReports.data) {
                console.log(this.dashboardReports.data[x])
                this.positionsData.datasets[0].data.push(this.dashboardReports.data[x].requestsCount)
                this.positionsData.labels.push(this.dashboardReports.data[x].month)
            }
        }
    }
</script>
