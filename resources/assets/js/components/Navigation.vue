<template>
    <ul class="c-list c-list--x">
        <li v-for="link in links" :key="link.slug">
            <a v-bind="link.attributes">{{ link.title }}</a>

            <sections :sections="link.sections"></sections>
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
