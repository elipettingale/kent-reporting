<template>
    <div class="k-total">
        <p>{{ label ?? "Total" }}</p>
        <p>{{ prefix ?? "£" }} {{ value }}</p>
    </div>
</template>

<script>
export default {
    name: "KTotal",
    props: ["label", "value", "prefix"],
};
</script>
