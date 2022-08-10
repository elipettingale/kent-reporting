<template>
    <p :class="classList">
        <slot></slot>
    </p>
</template>

<script>
export default {
    name: "KHeader",
    props: ["classList"],
};
</script>
