<template>

    <div class="c-form-row c-form__row--input">
        
        <label :for="field.input_name">
            
            {{ field.label }}

            <span v-show="field.required" class="field__required">*</span>

            <!-- @if ($fieldType->locale)
                @include('admin::form/partials/translations')
            @endif -->
        </label>

        <div v-show="field.instructions" class="field__instructions">{{ field.instructions }}</div>
            
        <div v-show="field.warning" class="field__warning">
                <!-- {!! icon('warning') !!} -->
                {{ field.warning }}
            </div>

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
