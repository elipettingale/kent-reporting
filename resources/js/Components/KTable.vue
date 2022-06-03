<template>
    <div
        class="k-table overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg"
    >
        <table class="min-w-full divide-y divide-gray-300">
            <slot></slot>
        </table>
    </div>
</template>

<script>
export default {
    name: "KTable",
};
</script>
