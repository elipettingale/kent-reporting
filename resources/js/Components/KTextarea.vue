<template>
    <div class="k-field">
        <k-label :value="label" :name="key" />
        <div class="k-textarea">
            <textarea
                class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full"
                :name="key"
                :rows="rows ?? 4"
                :value="modelValue"
                @input="updateValue"
                :disabled="disabled"
            ></textarea>
        </div>
    </div>
</template>

<script>
import KLabel from "./KLabel.vue";

export default {
    name: "KTextarea",
    props: ["label", "key", "modelValue", "rows", "disabled"],
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
