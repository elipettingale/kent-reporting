<template>
    <div class="k-field">
        <k-label :value="label" :name="key" />
        <div class="k-select" :class="{ 'has-error': modelValue.error }">
            <select
                class="k-select__select"
                :value="modelValue.value"
                @input="updateValue"
                :disabled="disabled"
            >
                <option v-if="notNull !== true"></option>
                <option
                    v-for="option in options"
                    :key="option"
                    :value="option"
                    v-text="option"
                ></option>
            </select>
        </div>
    </div>
</template>

<script>
import KLabel from "./KLabel.vue";

export default {
    name: "KSelect",
    props: ["label", "key", "modelValue", "options", "disabled", "notNull"],
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
