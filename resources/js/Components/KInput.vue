<template>
    <div class="k-field">
        <k-label :value="label" :name="key" />
        <div class="k-input" :class="{ 'has-prefix': prefix }">
            <span v-if="prefix" class="k-input__prefix" v-text="prefix"></span>
            <input
                :type="type ?? 'text'"
                class="k-input__input"
                :value="modelValue"
                @input="updateValue"
                :disabled="disabled"
            />
        </div>
    </div>
</template>

<script>
import KLabel from "./KLabel.vue";

export default {
    name: "KInput",
    props: ["label", "key", "modelValue", "type", "prefix", "disabled"],
    components: {
        KLabel,
    },
    methods: {
        updateValue(event) {
            this.$emit("update:modelValue", event.target.value);
        },
    },
};
</script>
