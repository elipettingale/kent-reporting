<template>
    <div class="k-select" :class="{ 'has-prefix': prefix }">
        <select class="k-select__select">
            <option></option>
            <option
                v-for="option in options"
                :key="option"
                value="option"
                v-text="option"
            ></option>
        </select>
    </div>
</template>

<script>
export default {
    name: "KSelect",
    props: ["options"],
};
</script>
