<template>
    <div class="fixed right-6 bottom-6 md:right-10 md:bottom-10">
        <div v-show="success && flash.success" id="toast-success" class="flex items-center w-full max-w-xs p-4 mb-4 text-green-700 dark:text-green-800 bg-green-100 rounded-lg shadow" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                <i class="mdi mdi-check-circle text-2xl"></i>
            </div>
            <div class="ml-3 text-sm font-normal">{{ flash.success }}</div>
            <button @click="success=false" type="button" class="ml-auto -mx-1.5 -my-1.5 text-green-700 hover:text-green-900 rounded-lg focus:ring-2 focus:ring-green-300 p-1.5 hover:bg-green-100 inline-flex h-8 w-8 dark:text-green-500 dark:hover:text-white dark:bg-green-800 dark:hover:bg-green-700" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        <div v-show="error && flash.error" id="toast-danger" class="flex items-center w-full max-w-xs p-4 mb-4 text-red-700 bg-red-100 rounded-lg shadow dark:text-red-400 dark:bg-red-800" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-200">
                <i class="mdi mdi-alert-circle text-2xl"></i>
            </div>
            <div class="ml-3 text-sm font-normal">{{ flash.error }}</div>
            <button @click="error=false" type="button" class="ml-auto -mx-1.5 -my-1.5 text-red-700 hover:text-red-900 rounded-lg focus:ring-2 focus:ring-red-300 p-1.5 hover:bg-red-100 inline-flex h-8 w-8 dark:text-red-500 dark:hover:text-white dark:bg-red-800 dark:hover:bg-red-700" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
        <div v-show="warning && flash.warning" id="toast-warning" class="flex items-center w-full max-w-xs p-4 text-yellow-700 bg-yellow-100 bg-yellow-100 rounded-lg shadow dark:text-yellow-400 dark:bg-yellow-800" role="alert">
            <div class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-yellow-700 bg-yellow-100 rounded-lg dark:bg-yellow-700 dark:text-yellow-200">
                <i class="mdi mdi-alert text-2xl"></i>
            </div>
            <div class="ml-3 text-sm font-normal">{{ flash.warning }}</div>
            <button @click="warning=false" type="button" class="ml-auto -mx-1.5 -my-1.5 text-yellow-700 hover:text-yellow-900 rounded-lg focus:ring-2 focus:ring-yellow-300 p-1.5 hover:bg-yellow-100 inline-flex h-8 w-8 dark:text-yellow-500 dark:hover:text-white dark:bg-yellow-800 dark:hover:bg-yellow-700" aria-label="Close">
                <span class="sr-only">Close</span>
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: "Toast",
    data(){
        return{
            success:true,
            error:true,
            warning:true,
        }
    },
    computed:{
        flash(){
            return this.$page.props.flash
        }
    }
}
</script>

<style scoped>

</style>
