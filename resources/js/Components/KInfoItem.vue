<template>
    <div class="flex justify-between">
        <span>{{ label }}</span> <span class="font-bold">{{ value }}</span>
    </div>
</template>

<script>
export default {
    name: "KInfoItem",
    props: ["label", "value"],
};
</script>
