<template>
    <app-layout>
        <template #header>
            Notifications
        </template>

        <template #breadcrumbs>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="heading-font uppercase text-sm font-medium text-gray-500 dark:text-gray-400">Notifications</span>
                </div>
            </li>
        </template>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
                <div
                    class="page-section"
                    v-for="(notificationCompound,index) in notificationContainer"
                    :key="index"
                >
                    <div class="page-section-header">
                        <div class="page-section-title">
                            {{notificationCompound.month}} {{notificationCompound.year}}
                        </div>
                    </div>
                    <div class="page-section-content grid grid-cols-1 ">
                        <div
                            v-for="notification in notificationCompound.notifications"
                            :key="notification.id"
                            class="card"
                        >
                            <div class="flex justify-start items-center">
                                <div>
                                    <i class="mdi text-xl" :class="getNotificationIcon(notification.data.type)"></i>
                                </div>
                                <div class="ml-3 text-sm">
                                    {{notification.data.contents.message}}
                                </div>
                            </div>
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
    import Request from "@/Components/Request";
    import PrimaryButton from "@/Jetstream/Button";

    export default {
        props:[
            'notificationContainer',
        ],
        components: {
            AppLayout
        },
        data(){
          return{

          }
        },
        methods:{
            getNotificationIcon(type){
                switch (type){
                    case "USER_NEW":
                        return "mdi-account-plus";
                    case "USER_VERIFIED":
                        return "mdi-account-check";
                    case "USER_DISABLED":
                        return "mdi-account-lock";
                    case "VEHICLE_NEW":
                        return "mdi-truck-plus";
                    case "PROJECT_NEW":
                        return "mdi-home-group-plus";
                    case "REQUEST_FORM_PENDING":
                        return "mdi-book-clock";
                    case "REQUEST_FORM_APPROVED":
                        return "mdi-book-check";
                    case "REQUEST_FORM_DENIED":
                        return "mdi-book-remove";
                    case "WAITING_INITIATE":
                        return "mdi-book-alert";
                    case "WAITING_RECONCILE":
                        return "mdi-book-alert";
                    case "INITIATED":
                        return "mdi-book-check";
                    case "RECONCILED":
                        return "mdi-book-check";
                    default:
                        return "";
                }
            },
        }
    }
</script>
