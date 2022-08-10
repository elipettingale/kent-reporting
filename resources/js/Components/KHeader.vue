<template>
    <p :class="classList">
        {{ text }}
    </p>
</template>

<script>
export default {
    name: "KHeader",
    props: ["text", "classList"],
};
</script>
