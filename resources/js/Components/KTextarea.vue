<template>
    <div class="k-textarea">
        <textarea
            class="rounded-md shadow-sm border-gray-300 focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-full"
            :rows="rows ?? 4"
            :value="modelValue"
            @input="updateValue"
        ></textarea>
    </div>
</template>

<script>
export default {
    name: "KTextarea",
    props: ["modelValue", "rows"],
    methods: {
        updateValue(event) {
            this.$emit("update:modelValue", event.target.value);
        },
    },
};
</script>
