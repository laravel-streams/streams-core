<template>
    <ul class="c-list c-list--x flex-grow">
        <li v-for="link in links" :key="link.slug">
            <a v-bind="link.attributes">{{ link.title }}</a>

            <admin-sections :sections="link.sections"></admin-sections>
        </li>
    </ul>
</template>

<script>
export default {
    props: {
        links: Array,
    },
    ready() {
        console.log("Navigation ready.");
    }
};
</script>
