<template>
    <jet-authentication-card>

        <jet-validation-errors class="mb-4" />

        <form @submit.prevent="submit">
            <div class="mb-4">
                <jet-label for="firstName" value="First Name" />
                <jet-input id="firstName" type="text" class="mt-1 block w-full" v-model="form.firstName" required autofocus autocomplete="geoserve-first-name"/>
            </div>
            <div class="mb-4">
                <jet-label for="middleName" value="Middle Name" />
                <jet-input id="middleName" type="text" class="mt-1 block w-full" v-model="form.middleName" autocomplete="geoserve-middle-name"/>
            </div>
            <div class="mb-4">
                <jet-label for="lastName" value="Last Name" />
                <jet-input id="lastName" type="text" class="mt-1 block w-full" v-model="form.lastName" required autocomplete="geoserve-last-name"/>
            </div>

            <div class="mb-4">
                <label for="positions" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300 heading-font">Position</label>
                <select v-model="form.positionId" id="positions" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white"  required>
                    <option value="">Select position</option>
                    <option
                        v-for="position in positions.data"
                        :value="position.id"
                        :key="position.id"
                    >
                        {{ position.title}}
                        <span v-if="position.title === 'Drilling Team'">({{position.grade.code}})</span>
                    </option>
                </select>
            </div>

            <div class="mb-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required />
            </div>

            <div class="mb-4">
                <jet-label for="password" value="Password" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" required autocomplete="new-password" />
            </div>

            <div class="mb-4">
                <jet-label for="password_confirmation" value="Confirm Password" />
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" required autocomplete="new-password" />
            </div>

            <div class="text-center mt-8">

                <jet-button class="ml-4 text-center" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Sign Up
                    <svg class="w-5 h-5 ml-2 -mr-1" fill="white" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </jet-button>
                <div class="text-sm font-medium text-gray-500 dark:text-gray-300">
                    Already have an account?
                    <inertia-link :href="route('login')" class="text-sm text-blue-700 hover:underline dark:text-blue-500">
                        Login
                    </inertia-link>
                </div>
            </div>
        </form>
    </jet-authentication-card>
</template>

<script>
    import JetAuthenticationCard from '@/Jetstream/AuthenticationCard'
    import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'
    import JetButton from '@/Jetstream/Button'
    import JetInput from '@/Jetstream/Input'
    import JetCheckbox from "@/Jetstream/Checkbox";
    import JetLabel from '@/Jetstream/Label'
    import JetValidationErrors from '@/Jetstream/ValidationErrors'

    export default {
        props:['positions'],

        components: {
            JetAuthenticationCard,
            JetAuthenticationCardLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetValidationErrors
        },

        data() {
            return {
                form: this.$inertia.form({
                    firstName: '',
                    middleName: '',
                    lastName: '',
                    positionId: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    terms: false,
                })
            }
        },

        created(){

        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        device_name: navigator.userAgent
                    }))
                    .post(this.route('register'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>
