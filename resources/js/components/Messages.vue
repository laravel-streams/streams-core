<template></template>
<script>
import Toasted from "vue-toasted";
import Vue from "vue";
Vue.use(Toasted, {
    position: "top-right",
    duration: 200000,
    theme: "c-toast"
});
export default {
    name: "messages",
    props: {
        messages: {
            type: Array,
            required: true
        },
        type: {
            type: String,
            required: true
        }
    },
   
    mounted() {
        let options = {
            type: "c-toast__" + this.type
        };

        Vue.toasted.register(
            this.type,
            payload => {
                if (!payload) {
                    return "Undefined " + this.type;
                }
                return "Oops.. " + payload;
            },
            options
        );

        
        if (this.type === "error")
            this.$toasted.global.error(this.messages.join("<br>"));
        if (this.type === "info")
            this.$toasted.global.info(this.messages.join("<br>"));
        if (this.type === "warning")
            this.$toasted.global.warning(this.messages.join("<br>"));
        if (this.type === "success")
            this.$toasted.global.success(this.messages.join("<br>"));
            
    }
};
</script>

