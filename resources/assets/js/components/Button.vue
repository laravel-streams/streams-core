<template>
    <component :is="button.tag" :href="button.attributes.href" class="font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1">
        <i v-show="button.icon" :class="button.icon"></i>
        {{ button.text }}
    </component>
</template>

<script>
    export default {
        props: {
            button: Object,
        },
        ready() {
            console.log('Component ready.')
        }
    }
</script>
