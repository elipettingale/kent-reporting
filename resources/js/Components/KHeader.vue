<template>
    <p :class="`k-header k-header-${size}`">
        <slot></slot>
    </p>
</template>

<script>
export default {
    name: "KHeader",
    props: ["size"],
};
</script>
