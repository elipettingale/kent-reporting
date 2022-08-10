<template>
    <div class="k-field">
        <k-label :value="label" :name="key" />
        <div class="k-select">
            <select
                class="k-select__select"
                :value="modelValue"
                @input="updateValue"
            >
                <option></option>
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
    props: ["label", "key", "modelValue", "options"],
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
