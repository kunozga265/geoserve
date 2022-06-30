<template>
    <div class="flex justify-start items-center" :class="getStatusClass()">
        <div>
            <i class="mdi text-xl" :class="getStatusIcon()"></i>
        </div>
        <div class="ml-3 text-sm">
            {{request.statusMessage }}
        </div>
    </div>
</template>

<script>
export default {
    name: "RequestStatus",
    props:['request'],
    methods:{
        getStatusClass(){
            switch (this.request.approvalStatus){
                case 0:
                    return "approval-pending";
                case 1:
                    return "approved";
                case 2:
                    return "denied";
                case 3:
                    return "approved";
                case 4:
                    return "closed";
                case 5:
                    return "closed";
                default:
                    return "";
            }
        },
        getStatusMessage(){
            switch (this.request.approvalStatus){
                case 0:
                    if (this.request.stagesApprovalStatus)
                        return ": Manager to approve";
                    else
                        return ": " + this.request.stagesApprovalPosition.title + " to approve";
                case 1:
                    return ": Accountant to initiate";
                case 2:
                    return "By " + this.request.deniedBy.firstName + " " + this.request.deniedBy.middleName + " " + this.request.deniedBy.lastName;
                case 3:
                    return ": Accountant to reconcile";
                default:
                    return "";
            }
        },
        getStatusIcon(){
            switch (this.request.approvalStatus){
                case 0:
                    return "mdi-alert-circle";
                case 1:
                    return "mdi-check-circle";
                case 2:
                    return "mdi-close-circle";
                case 3:
                    return "mdi-check-circle";
                case 4:
                    return "mdi-check-circle";
                case 5:
                    return "mdi-close-circle";
                default:
                    return "";
            }
        },
    }
}
</script>

<style scoped>

</style>
