<template>
    <inertia-link :href="route('request-forms.show',{id:request.id})">
        <div class="request">
            <div class="header justify-between items-center border-b">
                <div>
                    <div>
                        <span class="date rounded py-1 px-2 bg-gray-200 text-gray-600 text-xs font-bold uppercase">{{getDate(request.dateRequested*1000)}}</span>
                    </div>
                    <div class="type"><i class="mdi" :class="getRequestIcon()"></i> {{ getRequestName(request.type) }}</div>
                    <div class="name">{{request.requestedBy.firstName}} {{request.requestedBy.middleName}} {{request.requestedBy.lastName}}</div>

                </div>
                <div class="flex items-center ">
                    <div class="currency ">MK</div>
                    <div class="total">{{ numberWithCommas(total) }}</div>
                </div>
            </div>
            <div>
               <request-status :request="request"/>
            </div>
        </div>
    </inertia-link>

</template>

<script>
import RequestStatus from "@/Components/RequestStatus";
export default {
    name: "Request",
    props:['request'],
    components:{
        RequestStatus
    },

    computed:{
        total(){
            switch (this.request.type){
                case 'CASH':
                case 'MATERIALS':
                case 'VEHICLE_MAINTENANCE':
                    return this.request.total
                case 'FUEL':
                    return this.request.fuelRequestedMoney
                default:
                    return  ''
            }
        }
    },

    methods:{
        getRequestIcon(){
            switch (this.request.type){
                case 'CASH':
                    return 'mdi-cash'
                case 'MATERIALS':
                    return 'mdi-hammer'
                case 'VEHICLE_MAINTENANCE':
                    return 'mdi-car-hatchback'
                case 'FUEL':
                    return 'mdi-gas-station'
                default:
                    return  ''
            }
        },
    }
}
</script>

<style scoped>

</style>
