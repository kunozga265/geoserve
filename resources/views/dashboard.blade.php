<x-app-layout>
    <x-slot name="header">
       Dashboard
    </x-slot>
    @push('breadcrumbs')
        <li aria-current="page">
            <div class="flex items-center">
                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                <span class="heading-font uppercase ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Dashboard</span>
            </div>
        </li>
    @endpush

    @push('actions')
        <button type="submit" class="text-center inline-flex items-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            New Request
        </button>
    @endpush

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="page-section">
                <div class="page-section-header">
                    <div class="page-section-title">
                        Overview
                    </div>
                </div>
                <div class="page-section-content grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <div class="card">
                        <div class="flex justify-start items-center">
                            <div class="overview-chart relative">
                                <div style="font-size:12px;" class="absolute h-full w-full font-bold flex justify-center items-center">
                                    12%
                                </div>
                                <canvas class="" id="awaitingApproval" ></canvas>
                            </div>
                            <div class="ml-4">
                                <div class="heading-font" style="font-weight: 600;">Awaiting Approval</div>
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
                                <canvas class="" id="awaitingInitiation" ></canvas>
                            </div>
                            <div class="ml-4">
                                <div class="heading-font" style="font-weight: 600;">Awaiting Initiation</div>
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
                                <canvas class="" id="awaitingReconciliation" ></canvas>
                            </div>
                            <div class="ml-4">
                                <div class="heading-font" style="font-weight: 600;">Awaiting Reconciliation</div>
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
                                <canvas class="" id="active" ></canvas>
                            </div>
                            <div class="ml-4">
                                <div class="heading-font" style="font-weight: 600;">Active</div>
                                <div class="text-sm text-gray-400">4 Requests</div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="flex justify-start items-center">
                            <div class="relative">
                               <i class="mdi mdi-account-supervisor-circle" style="font-size: 32px"></i>
                            </div>
                            <div class="ml-4">
                                <div class="heading-font" style="font-weight: 600;">Unverified Users</div>
                                <div class="text-sm text-gray-400">4 Users</div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="flex justify-start items-center">
                            <div class="relative">
                               <i class="mdi mdi-home-group" style="font-size: 32px"></i>
                            </div>
                            <div class="ml-4">
                                <div class="heading-font" style="font-weight: 600;">Unverified Projects</div>
                                <div class="text-sm text-gray-400">4 Projects</div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="flex justify-start items-center">
                            <div class="relative">
                               <i class="mdi mdi-car-multiple" style="font-size: 32px"></i>
                            </div>
                            <div class="ml-4">
                                <div class="heading-font" style="font-weight: 600;">Unverified Vehicles</div>
                                <div class="text-sm text-gray-400">4 Vehicles</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="page-section">
                    <div class="page-section-header">
                        <div class="page-section-title">
                            Awaiting your action
                        </div>
                    </div>
                    <div class="page-section-content">
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
                            Active Requests
                        </div>
                    </div>
                    <div class="page-section-content">
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
            </div>
        </div>
    </div>


    @push('scripts')
        <script>

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

            /* Data */
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



        </script>
    @endpush

</x-app-layout>
