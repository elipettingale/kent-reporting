<template>
    <div class="k-field">
        <k-label :value="label" :name="key" />
        <div class="k-textarea">
            <textarea
                :id="key"
                class="k-textarea__textarea"
                :rows="rows ?? 4"
                :value="modelValue.value"
                @input="updateValue"
                :disabled="disabled"
            ></textarea>
        </div>
        <p v-if="modelValue.error" class="k-field__error">
            {{ modelValue.error }}
        </p>
    </div>
</template>

<script>
import KLabel from "./KLabel.vue";

export default {
    name: "KTextarea",
    props: ["label", "key", "modelValue", "rows", "error", "disabled"],
    components: {
        KLabel,
    },
    methods: {
        updateValue(event) {
            this.$emit("update:modelValue", {
                value: event.target.value,
                error: null,
            });
        },
    },
};
</script>
