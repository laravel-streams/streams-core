<template>
    <!-- {{ assets('scripts.js', 'public::vendor/anomaly/core/js/form.js') }} -->

    <div class="form__wrapper">

        <div v-for="(field, index) in form.fields" :key="index">{{ field.field }}</div>
        <!-- {!! $form->open() !!}
        @include('admin::form/partials/controls')
        @include('admin::form/partials/heading')
        @include('admin::form/partials/layout')
        @include('admin::form/partials/controls')
        {!! $form->close() !!} -->

    </div>
</template>

<script>
export default {
    props: {
        form: Object,
    },
    ready() {
        console.log("Form ready.");
    }
};
</script>
