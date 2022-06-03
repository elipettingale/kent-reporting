<template>
    <div class="k-input" :class="{ 'has-prefix': prefix }">
        <span v-if="prefix" class="k-input__prefix" v-text="prefix"></span>
        <input :type="type ?? 'text'" class="k-input__input" />
    </div>
</template>

<script>
export default {
    name: "KInput",
    props: ["type", "prefix"],
};
</script>
