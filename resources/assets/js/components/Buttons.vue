<template>
    <div class="buttons__list">
        <cp-button v-for="(button, index) in primary" :key="index" :button="button"></cp-button>

        <div class="buttons__dropdown">
            <cp-button v-for="(button, index) in secondary" :key="index" :button="button"></cp-button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            buttons: Array,
        },
        computed: {
            primary () {
                return this.buttons.filter(button => {
                    return button.primary == true;
                });
            },
            secondary () {
                return this.buttons.filter(button => {
                    return button.primary == false;
                });
            }
        }
    }
</script>
