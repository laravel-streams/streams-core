<template>
    <div class="table__filters">
        <slot></slot>
    </div>
</template>

<script>
export default {
    props: {
        field: Object,
    },
    ready() {
        console.log("Form field ready.");
    }
};
</script>
