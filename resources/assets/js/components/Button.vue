<template>
    <button type="button">
        <slot></slot>
    </button>
</template>

<script>
    export default {
        ready() {
            console.log('Component ready.')
        }
    }
</script>
