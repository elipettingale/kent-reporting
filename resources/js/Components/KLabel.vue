<template>
    <label class="block font-medium text-sm text-gray-700" :for="name">
        {{ value }}
    </label>
</template>

<script>
export default {
    name: "KLabel",
    props: ["value", "name"],
};
</script>
