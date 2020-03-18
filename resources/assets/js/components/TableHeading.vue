<template>
    <div class="table__header">

        <h4>
            {{ options.title }}

            <small v-show="options.description">
                {{ options.description }}
            </small>
        </h4>

    </div>
</template>

<script>
export default {
    props: {
        options: Array,
    },
    ready() {
        console.log("Form field ready.");
    }
};
</script>
