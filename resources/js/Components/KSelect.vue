<template>
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
</template>

<script>
export default {
    name: "KSelect",
    props: ["modelValue", "options"],
    methods: {
        updateValue(event) {
            this.$emit("update:modelValue", event.target.value);
        },
    },
};
</script>
