<template>
    <div>
        <span class="font-bold">{{ label }}:</span> <span>{{ value }}</span>
    </div>
</template>

<script>
export default {
    name: "KInfoItem",
    props: ["label", "value"],
};
</script>
