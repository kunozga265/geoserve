<template>
    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot></slot></span>
    </label>
</template>

<script>
    export default {
        props: ['value']
    }
</script>
