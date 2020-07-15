<template>
    <div class="c-top">
        <h1>{{appName}}</h1>
        <ul class="c-list c-list--x">
            <li v-for="(link,index) in links" :key="index">
                <a v-bind="link.attributes">{{link.title}}</a>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    name: "top",
    props: {
        links: {
            type: Array,
            required: false
        },
        appName: {
            type: String,
            required: false
        }
    }
};
</script>

