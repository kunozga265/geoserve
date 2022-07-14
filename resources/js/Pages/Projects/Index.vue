<template>
    <app-layout>
        <template #header>
            Projects
        </template>

        <template #breadcrumbs>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="heading-font uppercase text-sm font-medium text-gray-500 dark:text-gray-400">
                        Projects
                    </span>
                </div>
            </li>
        </template>

        <template #actions v-if="checkRole($page.props.auth.data,'administrator')">
            <inertia-link :href="route('projects.create')">
                <button type="submit" class="text-center inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    New Project
                </button>
            </inertia-link>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="page-section" >
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Unverified Projects
                        </div>
                    </div>
                    <div class="page-section-content grid grid-cols-1 md:grid-cols-2">
                        <div
                            class="user"
                            v-for="(project,index) in projects.data"
                            :key="index"
                            v-if="project.verified===0"
                            @click="viewUser(project.id)"
                        >
                            <div class="flex justify-between items-center">
                                <div class="">
                                    <div class="name">{{ project.name }}</div>
                                    <div class="position">{{ project.site }}</div>
                                </div>
                                <div v-if="checkRole($page.props.auth.data,'management')" class="">
                                    <div class="heading-font uppercase text-center inline-flex items-center text-white bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                        Verify
                                    </div>
                                </div>
                            </div>
                            <div>
                                <span class="mr-2 role rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase">
                                    {{project.client}}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Verified Projects
                        </div>
                    </div>
                    <div class="page-section-content grid grid-cols-1 md:grid-cols-2">
                        <div
                            class="user"
                            v-for="(project,index) in projects.data"
                            :key="index"
                            v-if="project.verified===1"
                            @click="viewUser(project.id)"
                        >
                            <div class="flex justify-between items-center">
                                <div class="">
                                    <div class="name">{{ project.name }}</div>
                                    <div class="position">{{ project.site }}</div>
                                </div>
                                <div class=" h-10 w-10 flex justify-center items-center rounded-full bg-blue-700">
                                    <i v-if="project.status==1" class="mdi mdi-check-decagram text-white"></i>
                                    <i v-else class="mdi mdi-lock text-white"></i>
                                </div>
                            </div>
                            <div>
                                <span class="mr-2 role rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase">
                                    {{project.client}}
                                </span>
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
    import PieChart from "@/Components/Charts/PieChart";
    import JetButton from "@/Jetstream/Button";

    export default {
        props:['projects'],
        components: {
            AppLayout,
            DoughnutChart,
            BarChart,
            PieChart,
            JetButton
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
              initiatedData:{
                  datasets: [{
                      data: [20, 80],
                      backgroundColor: ['#059669','#e3ebf6'],
                  }],
              },
              reconciledData:{
                  datasets: [{
                      data: [20, 80],
                      backgroundColor: ['#303840','#e3ebf6'],
                  }],
              },
              positionsData:{
                  datasets: [{
                      data: [2, 6,4,12,2, 6,6,9,5, 0,4,1,2, 6,5,8,7, 6,4,1,2,],
                      backgroundColor: ['#1a56db','#ed0b4b','#b1bbc9','#e3ebf6'],
                      barThickness:5
                  }],
                  labels: ['Managing Director', 'Finance and Compliance Executive', 'Vehicle Maintenance', 'Fuel','Operations and Bus Dev Specialist', 'Materials', 'Vehicle Maintenance', 'Fuel','Cash', 'Materials', 'Vehicle Maintenance', 'Fuel','Procurement Officer', 'Materials', 'Vehicle Maintenance', 'Fuel','Cash', 'Materials', 'Vehicle Maintenance', 'Fuel','Cash']
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
                  indexAxis: 'y',
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
                  }
              },
              rolesData:{
                  datasets: [{
                      data: [25, 60,45,19,4],
                      backgroundColor: ['#1a56db','#6690F3FF','#ed0b4b','#b1bbc9','#e3ebf6'],
                  }],
                  labels: ['Unverified','Employee', 'Accountant', 'Administrator', 'Management']
              },
              rolesChartOptions:{
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
          }
        },
        methods:{
            viewUser(id){
                this.$inertia.get(this.route('projects.show',{'id':id}))
            }
        }

    }
</script>
