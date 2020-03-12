<template>
    <div class="buttons">
        <slot></slot>
    </div>
</template>

<script>
    export default {
        ready() {
            console.log('Component ready.')
        }
    }
</script>
