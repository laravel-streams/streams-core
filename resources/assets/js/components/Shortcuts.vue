<template>
    <nav class="shortcut__items">
        <div v-for="(shortcut, index) in shortcuts" :key="index" class="shortcut__item">
                <a :href="shortcut.attributes.href" class="font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1">
                    {{ shortcut.title }}
                </a>
        </div>
    </nav>
</template>

<script>
export default {
    props: {
        shortcuts: Array,
    },
    ready() {
        console.log("Navigation ready.");
    }
};
</script>

<style lang="scss">
.shortcut__item {
    display: inline-block;

    a {
        padding: 5px;
    }
}
</style>
