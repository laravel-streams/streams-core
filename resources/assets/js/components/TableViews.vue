<template>
    <div class="table__views">
        <slot>
            <nav>
                <a v-for="(view, index) in views" :key="index" :href="view.attributes.href" :class="{'is-active': view.active}" class="table__view">
                    <i v-show="view.icon" :class="view.icon"></i>
                    
                    {{ view.text }}

                    <span :v-show="view.label" :class="view.context">
                        {{ view.label }}
                    </span>
                </a>
            </nav>
        </slot>
    </div>
</template>

<script>
export default {
    props: {
        table: Object,
        views: Array,
    },
};
</script>

<style lang="scss">
.table__view.is-active {
    font-weight: bold;
}
</style>
