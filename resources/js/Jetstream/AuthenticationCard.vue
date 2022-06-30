<template>
    <div>
        <div class="absolute w-full bg-gray-800 background-image"
             :style="{
                            backgroundImage:`url(${fileUrl('images/auth-background1.jpg')})`
                         }"
        ></div>
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div style="max-width: 410px; margin-top: 200px" class="sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden rounded-xl">
                <div class="py-6 flex justify-center">
                    <jet-authentication-card-logo />
                </div>
                <slot />
            </div>
            <footer class="p-4 text-center">
                <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">
                    © 2022
                    <a href="/">Geoserve Engineering Group™</a>. All Rights Reserved.
                </span>
            </footer>

        </div>
    </div>

</template>

<script>
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo'

export default {
    components: {
        JetAuthenticationCardLogo,
    },
}
</script>

