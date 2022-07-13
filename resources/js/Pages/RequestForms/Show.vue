<template>
    <app-layout>
        <template #header>
            {{ getRequestName(request.data.type) }} Form
        </template>

        <template #breadcrumbs>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                    <span class="heading-font uppercase text-sm font-medium text-gray-500 dark:text-gray-400">
                        Request
                    </span>
                </div>
            </li>
        </template>

       <template #actions >
           <a :href="route('request-forms.print',{'id':request.data.id})" target="_blank">
               <primary-button>Print</primary-button>
           </a>

           <span v-if="request.data.approvalStatus<4">
               <primary-button v-if="request.data.canEdit"  @click.native="edit">Edit</primary-button>
               <danger-button v-if="request.data.canDelete" @click.native="deleteDialog=true">Delete</danger-button>
               <danger-button v-if="request.data.canDiscard" @click.native="discardDialog=true">Discard</danger-button>

               <primary-button v-if="request.data.canApproveOrDeny"  @click.native="approveDialog=true">Approve</primary-button>
               <danger-button v-if="request.data.canApproveOrDeny" @click.native="denyDialog=true">Deny</danger-button>

               <primary-button v-if="request.data.canInitiate"  @click.native="initiateDialog=true">Initiate</primary-button>
               <primary-button v-if="request.data.canReconcile"  @click.native="reconcileDialog=true">Reconcile</primary-button>
           </span>
       </template>

          <dialog-modal :show="deleteDialog" @close="deleteDialog=false">
              <template #title>
                  Delete Request
              </template>

              <template #content>
                  Are you sure you want to delete this request?
                  Once you delete, this request will no longer be available.
              </template>

              <template #footer>
                  <secondary-button @click.native="deleteDialog=false">
                      Cancel
                  </secondary-button>

                  <danger-button class="ml-2" @click.native="deleteRequest">
                      <svg v-show="form.processing" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                          <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                      </svg>
                      Proceed
                  </danger-button>
              </template>
          </dialog-modal>

          <dialog-modal :show="discardDialog" @close="discardDialog=false">
              <template #title>
                  Discard Request
              </template>

              <template #content>
                  Are you sure you want to discard this request?
                  Once you discard, this request will no longer be available.
              </template>

              <template #footer>
                  <secondary-button @click.native="discardDialog=false">
                      Cancel
                  </secondary-button>

                  <danger-button class="ml-2" @click.native="discardRequest">
                      <svg v-show="form.processing" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                          <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                      </svg>
                      Proceed
                  </danger-button>
              </template>
          </dialog-modal>

        <dialog-modal :show="approveDialog" @close="approveDialog=false">
              <template #title>
                  Approve Request
              </template>

              <template #content>
                  <div class="mb-2">
                      Are you sure you want to approve this request?
                  </div>
<!--                  <jet-validation-errors class="mb-4" />-->

                  <textarea v-model="form.remarks" placeholder="Please leave remarks (Optional)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"></textarea>
              </template>

              <template #footer>
                  <secondary-button @click.native="approveDialog=false">
                      Cancel
                  </secondary-button>

                  <primary-button class="ml-2" @click.native="approve" :disabled="form.processing">
                      <svg v-show="form.processing" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                          <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                      </svg>
                      Proceed
                  </primary-button>
              </template>
          </dialog-modal>

        <dialog-modal :show="denyDialog" @close="denyDialog=false">
              <template #title>
                  Deny Request
              </template>

              <template #content>
                  <div class="mb-2">
                      Are you sure you want to deny this request?
                  </div>
                  <jet-validation-errors class="mb-4" />

                  <textarea v-model="form.remarks" placeholder="Please leave remarks (Required)" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"></textarea>
              </template>

              <template #footer>
                  <secondary-button @click.native="denyDialog=false">
                      Cancel
                  </secondary-button>

                  <danger-button class="ml-2" @click.native="denyRequest" :disabled="form.processing">
                      <svg v-show="form.processing" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                          <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                      </svg>

                      Proceed
                  </danger-button>
              </template>
          </dialog-modal>
        <dialog-modal :show="initiateDialog" @close="initiateDialog=false">
             <template #title>
                 Initiate Request
             </template>

             <template #content>
                 Are you sure you want to initiate this request?
             </template>

             <template #footer>
                 <secondary-button @click.native="initiateDialog=false">
                     Cancel
                 </secondary-button>

                 <primary-button class="ml-2" @click.native="initiate" :disabled="form.processing">
                     <svg v-show="form.processing" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                         <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                         <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                     </svg>
                     Proceed
                 </primary-button>
             </template>
         </dialog-modal>
        <dialog-modal :show="reconcileDialog" @close="reconcileDialog=false">
             <template #title>
                 Reconcile Request
             </template>

             <template #content>

                 <div class="mb-4">
                     Are you sure you want to reconcile this request?
                     <span v-if="request.data.type ==='FUEL'">Please submit the following information and upload receipts;</span>
                     <span v-else>Please upload receipts;</span>
                 </div>
                 <jet-validation-errors class="mb-4" />
                 <div v-if="request.data.type ==='FUEL'">
                     <div class="mb-4">
                         <jet-label for="lastRefillDate" value="Last Refill Date" />
                         <vue-date-time-picker
                             color="#1a56db"
                             v-model="date"
                             :min-date="minDate"
                         />
                     </div>
                     <div class="mb-4">
                         <jet-label for="lastRefillFuelReceived" value="Last Refill Fuel Received" />
                         <jet-input id="lastRefillFuelReceived" type="text" class="mt-1 block w-full" v-model="form.lastRefillFuelReceived" autocomplete="geoserve-vehicle-lastRefillFuelReceived"/>
                     </div>
                     <div class="mb-4">
                         <jet-label for="lastRefillMileageCovered" value="Last Refill Mileage Covered" />
                         <jet-input id="lastRefillMileageCovered" type="text" class="mt-1 block w-full" v-model="form.lastRefillMileageCovered" autocomplete="geoserve-vehicle-lastRefillMileageCovered"/>
                     </div>
                 </div>

                 <div class="mb-4">
                     <jet-label for="receipt" value="Upload receipt" />
                     <input type="file" id="receipt" @input="fileUpload($event.target.files[0])" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"/>
                 </div>

                 <div class="grid grid-cols-2 md:grid-cols-4">
                     <div
                         v-for="(receipt,index) in receiptUploads"
                         :key="index"
                     >
                         <div class="relative" v-if="receipt.ext === 'pdf'">
                             <i @click="removeReceipt(index)" style="top:-12px; right:-12px;  z-index: 2;" class="cursor mdi mdi-close-circle text-red-600 absolute right-0 text-2xl"></i>
                             <div style="top: -6px; width: 20px; height: 20px; right: -10px; z-index: 1; border-radius: 50%;" class="h-9 w-9 bg-white absolute"></div>
                             <pdf  class="w-32" :source="fileUrl(receipt.file)"/>
                         </div>
                         <div class="relative" v-else>
                             <i @click="removeReceipt(index)" style="top:-12px; right:-12px;  z-index: 2;" class="cursor mdi mdi-close-circle text-red-600 absolute right-0 text-2xl"></i>
                             <div style="top: -6px; width: 20px; height: 20px; right: -10px; z-index: 1; border-radius: 50%;" class="h-9 w-9 bg-white absolute"></div>
                             <img class="w-32" :src="fileUrl(receipt.file)" alt="Receipt Image">
                         </div>
                     </div>
                 </div>
             </template>

             <template #footer>
                 <secondary-button @click.native="reconcileDialog=false">
                     Cancel
                 </secondary-button>

                 <primary-button class="ml-2" @click.native="reconcile" :disabled="form.processing">
                     <svg v-show="form.processing" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                         <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                         <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                     </svg>
                     Proceed
                 </primary-button>
             </template>
         </dialog-modal>

        <div class="py-6">
            <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">


                <request-status class="mb-4" :request="request.data" />
                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="page-section" :class="{'md:col-span-2': request.data.type!=='FUEL'}">
                        <div class="page-section-header">
                            <div class="page-section-title">
                                General Details
                            </div>
                        </div>
                        <div class="page-section-content">

                            <div class="card p-0">
                                <div class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Request Code</div>
                                    <div>{{request.data.code}}</div>
                                </div>
                                <div v-if="request.data.type!=='FUEL'" class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Person Collecting Advance</div>
                                    <div>{{request.data.personCollectingAdvance}}</div>
                                </div>
                                <div v-if="request.data.type==='CASH' || request.data.type==='MATERIALS'" class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Project Name</div>
                                    <div v-if="request.data.project" >{{request.data.project.name}}</div>
                                </div>
                                <div v-if="request.data.type==='CASH' || request.data.type==='MATERIALS'" class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Project Client</div>
                                    <div v-if="request.data.project">{{request.data.project.client}}</div>
                                </div>
                                <div v-if="request.data.type==='CASH' || request.data.type==='MATERIALS'" class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Project Site</div>
                                    <div v-if="request.data.project">{{request.data.project.site}}</div>
                                </div>
                                <div v-if="request.data.type==='VEHICLE_MAINTENANCE'" class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Assessed By</div>
                                    <div>{{request.data.assessedBy}}</div>
                                </div>
                                <div v-if="request.data.type==='VEHICLE_MAINTENANCE' || request.data.type==='FUEL'" class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Vehicle Registration Number</div>
                                    <div>{{request.data.vehicle.vehicleRegistrationNumber}}</div>
                                </div>
                                <div v-if="request.data.type==='FUEL'" class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Mileage</div>
                                    <div>{{numberWithCommas(request.data.mileage)}}</div>
                                </div>
                                <div v-if="request.data.type==='FUEL'" class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Driver Name</div>
                                    <div>{{request.data.driverName}}</div>
                                </div>
                                <div v-if="request.data.type==='FUEL'" class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold"> Fuel Requested (In Litres)</div>
                                    <div>{{numberWithCommas(request.data.fuelRequestedLitres)}}</div>
                                </div>
                                <div v-if="request.data.type==='FUEL'" class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Fuel Requested (Money Equivalent)</div>
                                    <div>{{numberWithCommas(request.data.fuelRequestedMoney)}}</div>
                                </div>
                                <div v-if="request.data.type==='FUEL'" class="border-b px-4 py-3 text-sm">
                                    <div class="text-gray-600 font-semibold">Purpose</div>
                                    <div>{{request.data.purpose}}</div>
                                </div>
<!--                                <table class="w-full md:table-fixed text-sm text-left">
                                    <tbody>
                                    <tr class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Request Code
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{request.data.code}}
                                        </td>
                                    </tr>
                                    <tr v-if="request.data.type!=='FUEL'" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Person Collecting Advance
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{request.data.personCollectingAdvance}}
                                        </td>
                                    </tr>
                                    <tr v-if="request.data.type==='CASH' || request.data.type==='MATERIALS'" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Project Name
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{request.data.project.name}}
                                        </td>
                                    </tr>
                                    <tr v-if="request.data.type==='CASH' || request.data.type==='MATERIALS'" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Project Client
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{request.data.project.client}}
                                        </td>
                                    </tr>
                                    <tr v-if="request.data.type==='CASH' || request.data.type==='MATERIALS'" class="dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Project Site
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{request.data.project.site}}
                                        </td>
                                    </tr>
                                    <tr v-if="request.data.type==='VEHICLE_MAINTENANCE'" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Assessed By
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{request.data.assessedBy}}
                                        </td>
                                    </tr>
                                    <tr v-if="request.data.type==='VEHICLE_MAINTENANCE' || request.data.type==='FUEL'" class="dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Vehicle Registration Number
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{request.data.vehicle.vehicleRegistrationNumber}}
                                        </td>
                                    </tr>

                                    <tr v-if="request.data.type==='FUEL'" class="border-t border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Mileage
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{numberWithCommas(request.data.mileage)}}
                                        </td>
                                    </tr>
                                    <tr v-if="request.data.type==='FUEL'" class="border-t border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Driver Name
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{request.data.driverName}}
                                        </td>
                                    </tr>
                                    <tr v-if="request.data.type==='FUEL'" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Fuel Requested (In Litres)
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{numberWithCommas(request.data.fuelRequestedLitres)}}
                                        </td>
                                    </tr>
                                    <tr v-if="request.data.type==='FUEL'" class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Fuel Requested (Money Equivalent)
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{numberWithCommas(request.data.fuelRequestedMoney)}}
                                        </td>
                                    </tr>
                                    <tr v-if="request.data.type==='FUEL'" class="dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700">
                                        <td class="py-2 pr-1 font-semibold text-gray-600 dark:text-white whitespace-nowrap heading-font">
                                            Purpose
                                        </td>
                                        <td class="py-2 pr-1">
                                            {{request.data.purpose}}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>-->
                            </div>
                        </div>
                    </div>
                    <div v-if="request.data.type==='FUEL'" class="page-section">
                        <div class="page-section-header">
                            <div class="page-section-title">
                                Last Refill Details
                            </div>
                        </div>
                        <div class="page-section-content">
                            <div class="card p-0">
                                <div class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Date</div>
                                    <div v-if="request.data.lastRefillDate!==null && request.data.lastRefillDate!==0"> {{getDate(request.data.lastRefillDate*1000,true)}}</div>
                                </div>
                                <div class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Fuel Received</div>
                                    <div  v-if="request.data.lastRefillFuelReceived">{{numberWithCommas(request.data.lastRefillFuelReceived)}}</div>
                                </div>
                                <div class="border-b px-4 py-3 flex justify-between text-sm">
                                    <div class="text-gray-600 font-semibold">Mileage Covered</div>
                                    <div v-if="request.data.lastRefillMileageCovered">{{numberWithCommas(request.data.lastRefillMileageCovered)}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="request.data.type!=='FUEL'" class="page-section md:col-span-2">
                        <div class="page-section-header">
                            <div class="page-section-title">
                                Breakdown
                            </div>
                        </div>
                        <div class="page-section-content">
                            <div class="card">
                                <div class="p-2 relative overflow-x-auto">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead class=" text-gray-600  bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="heading-font">
                                                Details
                                            </th>
                                            <th v-if="request.data.type ==='MATERIALS'" scope="col" class="heading-font">
                                                Units
                                            </th>
                                            <th scope="col" class="heading-font">
                                                Quantity
                                            </th>
                                            <th scope="col" class="heading-font">
                                                Unit Cost
                                            </th>
                                            <th scope="col" class="heading-font">
                                                Total Cost
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr
                                            class="border-b dark:bg-gray-800 dark:border-gray-700 odd:bg-white even:bg-gray-50 odd:dark:bg-gray-800 even:dark:bg-gray-700"
                                            v-for="(info,index) in request.data.information"
                                            :key="index"
                                        >
                                            <th scope="row" class="py-2 pr-1 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                {{info.details}}
                                            </th>
                                            <td v-if="request.data.type ==='MATERIALS'" class="py-2 pr-1">
                                                {{info.units}}
                                            </td>
                                            <td class="py-2 pr-1">
                                                {{numberWithCommas(info.quantity)}}
                                            </td>
                                            <td class="py-2 pr-1">
                                                {{numberWithCommas(info.unitCost)}}
                                            </td>
                                            <td class="py-2 pr-1">
                                                {{numberWithCommas(info.totalCost)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td v-if="request.data.type ==='MATERIALS'"></td>
                                            <td></td>
                                            <th class="pt-4 pr-1 text-base heading-font font-bold">Total</th>
                                            <td class="pt-4 pr-1 text-base font-bold">{{numberWithCommas(request.data.total)}}</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <!--                                <div class="mt-4 text-center">-->
                                    <!--                                    <div class="flex justify-center items-center ">-->
                                    <!--                                        <div class="currency ">MK</div>-->
                                    <!--                                        <div class="total">{{ numberWithCommas(request.data.total) }}</div>-->
                                    <!--                                    </div>-->
                                    <!--                                    <div class="text-gray-600 text-xs">Total Cost</div>-->
                                    <!--                                </div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="request.data.type !=='FUEL' && request.data.quotes" class="page-section md:col-span-2">
                        <div v-show="request.data.quotes.length > 0" class="page-section-header">
                            <div class="page-section-title">
                                Attached Quotes
                            </div>
                        </div>
                        <div v-show="request.data.quotes.length > 0" class="page-section-content">
                            <div class="card">

                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
                                    <div
                                        v-for="(quote,index) in this.quotes"
                                        :key="index"
                                    >
                                        <div v-if="quote.ext === 'pdf'" @click="displayAttachment(index,'quote')" class="cursor" >
                                            <pdf  class="w-32" :source="fileUrl(quote.file)"/>
                                        </div>
                                        <div v-else @click="displayAttachment(index,'quote')" class="cursor" >
                                            <img class="w-32" :src="fileUrl(quote.file)" alt="Quote Image">
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div v-if="request.data.receipts" class="page-section md:col-span-2">
                        <div v-show="request.data.receipts.length > 0" class="page-section-header">
                            <div class="page-section-title">
                                Attached Receipts
                            </div>
                        </div>
                        <div v-show="request.data.receipts.length > 0" class="page-section-content">
                            <div class="card">

                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6">
                                    <div
                                        v-for="(receipt,index) in this.receipts"
                                        :key="index"
                                    >
                                        <div v-if="receipt.ext === 'pdf'" @click="displayAttachment(index,'receipt')" class="cursor" >
                                            <pdf  class="w-32" :source="fileUrl(receipt.file)"/>
                                        </div>
                                        <div v-else @click="displayAttachment(index,'receipt')" class="cursor" >
                                            <img class="w-32" :src="fileUrl(receipt.file)" alt="Receipt Image">
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="page-section">
<!--                            <div class="page-section-header">-->
<!--                                <div class="page-section-title">-->
<!--                                    Authorised By-->
<!--                                </div>-->
<!--                            </div>-->
                            <div class="page-section-content">
                                <div class="card p-0">
                                    <div class="p-3 text-white text-sm font-semibold bg-system heading-font uppercase rounded-t-lg">
                                        Requested By
                                    </div>
                                    <div class="border-b px-3 py-2 flex justify-between text-sm">
                                        <div class="font-semibold">Name</div>
                                        <div>{{request.data.requestedBy.firstName}} {{request.data.requestedBy.middleName}} {{request.data.requestedBy.lastName}}</div>
                                    </div>
                                    <div class="border-b px-3 py-2 flex justify-between text-sm">
                                        <div class="font-semibold">Position</div>
                                        <div>{{request.data.requestedBy.position.title}}</div>
                                    </div>
                                    <div class="px-3 py-2 flex justify-between text-sm">
                                        <div class="font-semibold">Date</div>
                                        <div>{{getDate(request.data.dateRequested*1000,true)}}</div>
                                    </div>
                                </div>

                                <div class="card p-0"
                                     v-for="(stage,index) in request.data.stages"
                                     :key="index"
                                     v-if="stage.status"
                                >
                                    <div class="p-3 text-white text-sm font-semibold bg-system heading-font uppercase rounded-t-lg">
                                        <i class="mdi mdi-check-decagram text-white mr-2"></i>
                                        Authorised By: {{ stage.positionTitle }}
                                    </div>
                                    <div class="border-b px-3 py-2 flex justify-between text-sm">
                                        <div class="font-semibold">Name</div>
                                        <div>{{ stage.name }}</div>
                                    </div>
                                    <div class="px-3 py-2 flex justify-between text-sm">
                                        <div class="font-semibold">Date</div>
                                        <div>{{ getDate(stage.date*1000,true) }}</div>
                                    </div>
                                </div>
                                <div class="card p-0" v-if="request.data.approvedBy">
                                    <div class="p-3 text-white text-sm font-semibold bg-system heading-font uppercase rounded-t-lg">
                                        <i class="mdi mdi-check-decagram text-white mr-2"></i>
                                        Approved By: {{ request.data.approvedBy.position.title }}
                                    </div>
                                    <div class="border-b px-3 py-2 flex justify-between text-sm">
                                        <div class="font-semibold">Name</div>
                                        <div>{{request.data.approvedBy.firstName}} {{request.data.approvedBy.middleName}} {{request.data.approvedBy.lastName}}</div>
                                    </div>
                                    <div class="px-3 py-2 flex justify-between text-sm">
                                        <div class="font-semibold">Date</div>
                                        <div>{{ getDate(request.data.approvedDate*1000,true) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-section" v-if="request.data.dateInitiated || request.data.dateReconciled">
<!--                        <div class="page-section-header">
                            <div class="page-section-title">
                                Finance
                            </div>
                        </div>-->
                        <div class="page-section-content">
                            <div class="card p-0">
                                <div class="p-3 text-white text-sm font-semibold bg-system heading-font uppercase rounded-t-lg">
                                    Finance
                                </div>
                                <div v-if="request.data.dateInitiated" class="border-b px-3 py-2 flex justify-between text-sm">
                                    <div class="font-semibold">Initiated Date</div>
                                    <div>{{ getDate(request.data.dateInitiated*1000,true) }}</div>
                                </div>
                                <div v-if="request.data.dateReconciled" class="px-3 py-2 flex justify-between text-sm">
                                    <div class="font-semibold">Reconciled Date</div>
                                    <div>{{ getDate(request.data.dateReconciled*1000,true) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-if="request.data.remarks" class="page-section md:col-span-2" >
                        <div v-show="request.data.remarks.length > 0" class="page-section-header">
                            <div class="page-section-title">
                                Remarks
                            </div>
                        </div>
                        <div v-show="request.data.remarks.length > 0" class="page-section-content">
                            <div class="grid grid-cols-1 md:grid-cols-2">
                                <div class="card p-0"
                                     v-for="(remark,index) in request.data.remarks"
                                     :key="index"
                                >
                                    <div class="border-b p-3 text-sm ">
                                        {{remark.comments}}
                                    </div>
                                    <div class="px-3 py-2 bg-text-gray-400 bg-gray-50 rounded-b-xl flex justify-between text-xs">
                                        <div >
                                            <div class="font-semibold">{{ remark.name }}</div>
                                            <div>{{ remark.positionTitle }}</div>

                                        </div>
                                        <div>
                                            {{getDate(remark.date*1000,true)}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card" v-if="request.data.canEdit">
                                <jet-validation-errors class="mb-4" />
                                <textarea v-model="form.remarks" placeholder="Leave remarks" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"></textarea>
                                <div>
                                    <primary-button class="mt-2" @click.native="addRemarks" :disabled="form.processing">
                                        <svg v-show="form.processing" role="status" class="inline w-4 h-4 mr-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                                            <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
                                        </svg>
                                        Add remark
                                    </primary-button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <dialog-modal v-if="attachment" :show="attachmentDialog" @close="attachmentDialog=false">

                        <template #content>
                            <div v-if="attachment.ext === 'pdf'">
                                <pdf  class="w-full" :source="fileUrl(attachment.file)"/>
                            </div>
                            <div v-else>
                                <img class="w-full" :src="fileUrl(attachment.file)" alt="Quote Image">
                            </div>
                        </template>

                        <template #footer>
                            <secondary-button @click.native="attachmentDialog=false">
                                close
                            </secondary-button>
                            <a :href="fileUrl(attachment.file)" target="_blank">
                                <primary-button @click.native="attachmentDialog=false">
                                    Print
                                </primary-button>
                            </a>
                        </template>
                    </dialog-modal>

                </div>
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
    import pdf from 'vue-pdf-embed/dist/vue2-pdf-embed'
    import requestStatus from "@/Components/RequestStatus";
    import JetValidationErrors from '@/Jetstream/ValidationErrors'
    import JetLabel from "@/Jetstream/Label";
    import JetInput from "@/Jetstream/Input";

    export default {
        props:['request'],
        components: {
            AppLayout,
            DoughnutChart,
            PieChart,
            PrimaryButton,
            SecondaryButton,
            DangerButton,
            DialogModal,
            pdf,
            requestStatus,
            JetValidationErrors,
            JetLabel,
            JetInput,
        },
        data(){
          return{
              loading:false,
              approveDialog:false,
              deleteDialog:false,
              discardDialog:false,
              initiateDialog:false,
              reconcileDialog:false,
              attachmentDialog:false,
              attachmentIndex:null,
              attachmentType:'',
              denyDialog:false,
              form: this.$inertia.form({
                  remarks:'',
                  lastRefillFuelReceived:'',
                  lastRefillMileageCovered:'',
              }),
              date:null,
              minDate:new Date(this.request.data.dateRequested*1000).toISOString().substr(0,10),
              receiptUploads:[],
          }
        },
        created(){

        },
        computed:{
            attachment(){
                if(this.attachmentIndex !== null) {
                    if (this.attachmentType === 'quote')
                        return this.quotes[this.attachmentIndex]
                    else if (this.attachmentType === 'receipt')
                        return this.receipts[this.attachmentIndex]

                }

                return null
            },
            quotes(){
                let quotes=[]
                let split=null

                for(let x in this.request.data.quotes){
                    split=this.request.data.quotes[x].split('.')
                    quotes.push({
                        file:this.request.data.quotes[x],
                        ext:split[1]
                    })
                }
                return quotes
            },
            receipts(){
                let receipts=[]
                let split=null

                for(let x in this.request.data.receipts){
                    split=this.request.data.receipts[x].split('.')
                    receipts.push({
                        file:this.request.data.receipts[x],
                        ext:split[1]
                    })
                }
                return receipts
            },
            receiptFiles(){
                let files=[]
                for (let x in this.receiptUploads)
                    files.push(this.receiptUploads[x].file)

                return files
            },
            lastRefillDate(){
                return this.date?(new Date(this.date).getTime())/1000:null
            }
        },
        methods:{
            printRequest(){
                this.$inertia.get(this.route('request-forms.print',{'id':this.request.data.id}))
            },
            edit(){
                this.$inertia.get(this.route('request-forms.edit',{'id':this.request.data.id}))
            },
            approve(){
                this.form
                    .post(this.route('request-forms.approve',{'id':this.request.data.id}),{
                        onSuccess: () => this.approveDialog=false,
                    })
            },
            deleteRequest(){
                this.form
                    .post(this.route('request-forms.delete',{'id':this.request.data.id}),{
                        preserveScroll: true,
                        onSuccess: () => this.deleteDialog=false,
                    })
            },
            discardRequest(){
                this.form
                    .post(this.route('request-forms.discard',{'id':this.request.data.id}),{
                        onSuccess: () => this.discardDialog=false,
                    })
            },
            denyRequest(){
                this.form
                    .post(this.route('request-forms.deny',{'id':this.request.data.id}),{
                        onSuccess: () => this.denyDialog=false,
                    })
            },
            addRemarks(){
                this.form
                    .post(this.route('request-forms.add-remarks',{'id':this.request.data.id}),{
                        preserveScroll:true,
                        onSuccess: () => this.form.reset('remarks')
                    })
            },
            initiate(){
                this.form
                    .post(this.route('request-forms.initiate',{'id':this.request.data.id}),{
                        onSuccess: () => this.initiateDialog=false,
                    })
            },
            reconcile(){
                this.form
                    .transform(data => ({
                        ... data,
                        receipts: this.receiptFiles,
                        lastRefillDate:this.lastRefillDate
                    }))
                    .post(this.route('request-forms.reconcile',{'id':this.request.data.id}),{
                        onSuccess: () => this.reconcileDialog=false,
                    })
            },
            displayAttachment(index,type){
                this.attachmentIndex=index
                this.attachmentType=type
                this.attachmentDialog=true
            },
            fileUpload(file){
                const reader=new FileReader();
                if (file){
                    reader.readAsDataURL(file);
                    reader.onload=(e)=>{
                        axios.post(this.$page.props.publicPath+"api/1.0.0/upload",{
                            type:"RECEIPT",
                            file:e.target.result
                        }).then(res=>{
                            this.receiptUploads.push({
                                'file':res.data.file,
                                'ext':res.data.ext,
                            })
                            document.getElementById('receipt').value = ""
                        }).catch(function(res){
                            // this.form.errors.push(res.data.message)
                        })
                    };
                }
            },
            removeReceipt(index){
                const file=this.receiptUploads[index].file
                //delete online
                axios.post(this.$page.props.publicPath+"api/1.0.0/upload/delete",{
                    'file':file
                })
                this.receiptUploads.splice(index,1)
            },
        }
    }
</script>
