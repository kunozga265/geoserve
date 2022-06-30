<template>
    <app-layout>
        <template #header>
            Users
        </template>

        <template #breadcrumbs>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="heading-font uppercase text-sm font-medium text-gray-500 dark:text-gray-400">
                        Users
                    </span>
                </div>
            </li>
        </template>

        <template #actions>

        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Overview
                        </div>
                    </div>
                    <div class="page-section-content grid grid-cols-1 lg:grid-cols-2">
                        <div class="card flex justify-center">
                            <div class="h-64 w-64 sm:h-80 sm:w-80  mx-auto relative">
                                <div class="pie-chart pie-chart-users absolute font-bold flex justify-center items-center">
                                    <div class="heading">
                                        <div class="font-bold heading-font text-center">5</div>
                                        <div class="xl font-bold heading-font text-center">Types</div>
                                    </div>
                                </div>
                                <PieChart
                                    :chart-options="rolesChartOptions"
                                    :chart-data="rolesData"
                                    chart-id="types"
                                    dataset-id-key="types"
                                />
                            </div>
                        </div>
                        <div class="card">
                            <div class="ml-4 mt-2 flex justify-start items-center">
                                <div class="text-3xl heading-font font-semibold">{{users.data.length}}</div>
                                <div class="ml-3">
                                    <div class="heading-font" style="font-weight: 600;">Users</div>
                                    <div class="text-sm text-gray-400">{{positions.data.length}} Positions</div>
                                </div>
                            </div>
                            <div class="ml-4">
<!--                                <div class="h-64 w-64 sm:h-80 sm:w-80 lg:h-96 lg:w-96  mx-auto relative">

                                    <BarChart
                                        :chart-options="positionsChartOptions"
                                        :chart-data="positionsData"
                                    />
                                </div>-->
                                <table>
                                    <tbody>
                                        <tr
                                            v-for="(position,index) in positions.data"
                                            :key="index"
                                        >
                                            <td class="mr-2 flex justify-center items-center">
                                                <div class="rounded-full py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold">{{position.usersCount}}</div>
                                            </td>
                                            <td class="border-l pl-3 text-sm text-gray-600">{{ position.title }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Unverified Users
                        </div>
                    </div>
                    <div class="page-section-content grid grid-cols-1 md:grid-cols-2">
                        <div
                            class="user"
                            v-for="(user,index) in users.data"
                            :key="index"
                            @click="viewUser(user.id)"
                            v-if="checkRole(user,'unverified')"
                        >
                            <div class="flex justify-between items-center">
                                <div class="">
                                    <div class="name">{{ user.firstName }} {{ user.middleName }} {{ user.lastName }}</div>
                                    <div class="position">{{ user.position.title }}</div>
                                </div>
                                <div class="">
                                    <jet-button>
                                        Verify
                                    </jet-button>
                                </div>
                            </div>
                            <div>
                                <span
                                    v-for="(role,index) in user.roles"
                                    :key="index"
                                    class="mr-2 role rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase"
                                >
                                    {{ role.name }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Verified Users
                        </div>
                    </div>
                    <div class="page-section-content grid grid-cols-1 md:grid-cols-2">
                        <div
                            class="user"
                            v-for="(user,index) in users.data"
                            :key="index"
                            @click="viewUser(user.id)"
                            v-if="!checkRole(user,'unverified')"
                        >
                            <div class="flex justify-between items-center">
                                <div class="">
                                    <div class="name">{{ user.firstName }} {{ user.middleName }} {{ user.lastName }}</div>
                                    <div class="position">{{ user.position.title }}</div>
                                </div>
                                <div class=" h-10 w-10 flex justify-center items-center rounded-full bg-blue-700 cursor">
                                    <i class="mdi mdi-check-decagram text-white"></i>
                                </div>
                            </div>
                            <div>
                                <span
                                    v-for="(role,index) in user.roles"
                                    :key="index"
                                    class="mr-2 role rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase"
                                >
                                    {{ role.name }}
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
        props:[
            'positions',
            'users',
            'roles',
        ],

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
                this.$inertia.get(this.route('users.show',{'id':id}))
            }
        }

    }
</script>
