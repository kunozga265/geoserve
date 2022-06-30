<template>
    <app-layout>
        <template #header>
            Index
        </template>

        <template #breadcrumbs>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="heading-font uppercase text-sm font-medium text-gray-500 dark:text-gray-400">Index</span>
                </div>
            </li>
        </template>

        <template #actions>
            <button type="submit" class="text-center inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                New Request
            </button>
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
                            <div class="h-64 w-64 sm:h-80 sm:w-80 mx-auto relative">
                                <div class="pie-chart absolute font-bold flex justify-center items-center">
                                    <div class="heading">
                                        <div class="font-bold heading-font text-center">34</div>
                                        <div class="xl font-bold heading-font text-center">Requests</div>
                                    </div>
                                </div>
                                <PieChart
                                    :chart-options="typesChartOptions"
                                    :chart-data="typesData"
                                    chart-id="types"
                                    dataset-id-key="types"
                                >
                                    Hello world
                                </PieChart>
                            </div>
                        </div>
                        <div class="w-full grid grid-cols-1 md:grid-cols-2 lg:grid-cols-1">
                            <div class="card">
                                <div class="flex justify-start items-center">
                                    <div class="overview-chart relative">
                                        <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                            12%
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
                                        <div class="text-sm text-gray-400">4 Requests</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card ">
                                <div class="flex justify-start items-center">
                                    <div class="overview-chart relative">
                                        <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                            12%
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
                                        <div class="text-sm text-gray-400">4 Requests</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="flex justify-start items-center">
                                    <div class="overview-chart relative">
                                        <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                            12%
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
                                        <div class="text-sm text-gray-400">4 Requests</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="flex justify-start items-center">
                                    <div class="overview-chart relative">
                                        <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                            12%
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
                                        <div class="text-sm text-gray-400">4 Requests</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Active Requests
                        </div>
                    </div>
                    <div class="page-section-content grid grid-cols-1 md:grid-cols-2">
                        <div class="request">
                            <div class="header justify-between items-center border-b">
                                <div class="">
                                    <div>
                                        <span class="date rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase"> 12 Sept, 2022</span>
                                    </div>
                                    <div class="type"><i class="mdi mdi-car-hatchback"></i> Vehicle Maintenance Request</div>
                                    <div class="name">Blessings Majamanda</div>

                                </div>
                                <div class="flex items-center ">
                                    <div class="currency ">MK</div>
                                    <div class="total">400,000</div>
                                </div>
                            </div>
                            <div>
                                <div class="approval-pending flex justify-start items-center">
                                    <div>
                                        <i class="mdi mdi-alert-circle text-xl"></i>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        Pending: Manager to approve
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="request">
                            <div class="header justify-between items-center border-b">
                                <div class="">
                                    <div>
                                        <span class="date rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase"> 12 Sept, 2022</span>
                                    </div>
                                    <div class="type"><i class="mdi mdi-cash"></i> Cash Request</div>
                                    <div class="name">Vitumbiko Mpinganjira</div>

                                </div>
                                <div class="flex items-center ">
                                    <div class="currency ">MK</div>
                                    <div class="total">20,000</div>
                                </div>
                            </div>
                            <div>
                                <div class="approved flex justify-start items-center">
                                    <div>
                                        <i class="mdi mdi-check-circle text-xl"></i>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        Approved: Accountant to initiate
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="request">
                            <div class="header justify-between items-center border-b">
                                <div class="">
                                    <div>
                                        <span class="date rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase"> 12 Sept, 2022</span>
                                    </div>
                                    <div class="type"><i class="mdi mdi-gas-station"></i> Fuel Request</div>
                                    <div class="name">Chisomo Hanjahanja</div>

                                </div>
                                <div class="flex items-center ">
                                    <div class="currency ">MK</div>
                                    <div class="total">50,000</div>
                                </div>
                            </div>
                            <div>
                                <div class="approved flex justify-start items-center">
                                    <div>
                                        <i class="mdi mdi-check-circle text-xl"></i>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        Approved: Accountant to reconcile
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="request">
                            <div class="header justify-between items-center border-b">
                                <div class="">
                                    <div>
                                        <span class="date rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase"> 12 Sept, 2022</span>
                                    </div>
                                    <div class="type"><i class="mdi mdi-hammer"></i> Materials Request</div>
                                    <div class="name">Blessings Majamanda</div>

                                </div>
                                <div class="flex items-center ">
                                    <div class="currency ">MK</div>
                                    <div class="total">80,000</div>
                                </div>
                            </div>
                            <div>
                                <div class="approval-pending flex justify-start items-center">
                                    <div>
                                        <i class="mdi mdi-alert-circle text-xl"></i>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        Pending: Finance and Compliance Executive to approve
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Closed Requests
                        </div>
                    </div>
                    <div class="page-section-content grid grid-cols-1 md:grid-cols-2">
                        <div class="request">
                            <div class="header justify-between items-center border-b">
                                <div class="">
                                    <div>
                                        <span class="date rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase"> 12 Sept, 2022</span>
                                    </div>
                                    <div class="type"><i class="mdi mdi-cash"></i> Cash Request</div>
                                    <div class="name">Vitumbiko Mpinganjira</div>

                                </div>
                                <div class="flex items-center ">
                                    <div class="currency ">MK</div>
                                    <div class="total">20,000</div>
                                </div>
                            </div>
                            <div>
                                <div class="denied flex justify-start items-center">
                                    <div>
                                        <i class="mdi mdi-close-circle text-xl"></i>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        Denied by: Kunozga Mlowoka
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="request">
                            <div class="header justify-between items-center border-b">
                                <div class="">
                                    <div>
                                        <span class="date rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase"> 12 Sept, 2022</span>
                                    </div>
                                    <div class="type"><i class="mdi mdi-car-hatchback"></i> Vehicle Maintenance Request</div>
                                    <div class="name">Vitumbiko Mpinganjira</div>

                                </div>
                                <div class="flex items-center ">
                                    <div class="currency ">MK</div>
                                    <div class="total">400,000</div>
                                </div>
                            </div>
                            <div>
                                <div class="approval-pending flex justify-start items-center">
                                    <div>
                                        <i class="mdi mdi-alert-circle text-xl"></i>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        Pending: Manager to approve
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="request">
                            <div class="header justify-between items-center border-b">
                                <div class="">
                                    <div>
                                        <span class="date rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase"> 12 Sept, 2022</span>
                                    </div>
                                    <div class="type"><i class="mdi mdi-car-hatchback"></i> Vehicle Maintenance Request</div>
                                    <div class="name">Vitumbiko Mpinganjira</div>

                                </div>
                                <div class="flex items-center ">
                                    <div class="currency ">MK</div>
                                    <div class="total">400,000</div>
                                </div>
                            </div>
                            <div>
                                <div class="reconciled flex justify-start items-center">
                                    <div>
                                        <i class="mdi mdi-check-circle text-xl"></i>
                                    </div>
                                    <div class="ml-3 text-sm">
                                        Reconciled
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-4 flex flex-col items-center justify-start">
                    <!-- Help text -->
                    <span class="text-sm text-gray-700 dark:text-gray-400">
                                    Showing <span class="font-semibold text-gray-900 dark:text-white">1</span> to <span class="font-semibold text-gray-900 dark:text-white">10</span> of <span class="font-semibold text-gray-900 dark:text-white">100</span> Entries
                                </span>
                    <div class="inline-flex mt-2 xs:mt-0">
                        <!-- Buttons -->
                        <button class="inline-flex items-center py-2 px-4 text-sm font-medium text-white bg-gray-800 rounded-l hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            <svg class="mr-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                            Prev
                        </button>
                        <button class="inline-flex items-center py-2 px-4 text-sm font-medium text-white bg-gray-800 rounded-r border-0 border-l border-gray-700 hover:bg-gray-900 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">
                            Next
                            <svg class="ml-2 w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M12.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import DoughnutChart from "@/Components/Charts/DoughnutChart";
    import PieChart from "@/Components/Charts/PieChart";

    export default {
        components: {
            AppLayout,
            DoughnutChart,
            PieChart
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
              approvedData:{
                  datasets: [{
                      data: [20, 80],
                      backgroundColor: ['#22c55e','#e3ebf6'],
                  }],
              },
              pendingData:{
                  datasets: [{
                      data: [20, 80],
                      backgroundColor: ['#eab308','#e3ebf6'],
                  }],
              },
              deniedData:{
                  datasets: [{
                      data: [20, 80],
                      backgroundColor: ['#ef4444','#e3ebf6'],
                  }],
              },
              completedData:{
                  datasets: [{
                      data: [20, 80],
                      backgroundColor: ['#303840','#e3ebf6'],
                  }],
              },
              typesData:{
                  datasets: [{
                      data: [25, 60,45,19],
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
          }
        },

        /*created(){
            const awaitingApproval = document.getElementById('awaitingApproval');
            const awaitingInitiation = document.getElementById('awaitingInitiation');
            const awaitingReconciliation = document.getElementById('awaitingReconciliation');
            const active = document.getElementById('active');
            const options={
                plugins: {
                    tooltip: {
                        enabled: false
                    },
                    legend:{
                        display:false
                    }
                }, cutout:20
            };

            /!* Data *!/
            const awaitingApprovalData={
                datasets: [{
                    data: [20, 80],
                    backgroundColor: ['#1a56db','#e3ebf6'],
                }],
            };

            const awaitingInitiationData ={
                datasets: [{
                    data: [20, 80],
                    backgroundColor: ['#1a56db','#e3ebf6'],
                }],
            }
            const awaitingReconciliationData ={
                datasets: [{
                    data: [20, 80],
                    backgroundColor: ['#1a56db','#e3ebf6'],
                }],
            }
            const activeData ={
                datasets: [{
                    data: [20, 80],
                    backgroundColor: ['#1a56db','#e3ebf6'],
                }],
            }

            const myChart = new Chart(
                awaitingApproval, {
                    type: 'doughnut',
                    data: awaitingApprovalData,
                    options: options
                });

            const myChart1 = new Chart(
                awaitingInitiation,{
                    type: 'doughnut',
                    data: awaitingInitiationData,
                    options: options
                }
            );

            const myChart2 = new Chart(
                awaitingReconciliation,{
                    type: 'doughnut',
                    data: awaitingReconciliationData,
                    options: options
                }
            );

            const myChart3 = new Chart(
                active,{
                    type: 'doughnut',
                    data: activeData,
                    options: options
                }
            );
        }*/
    }
</script>
