<template>
    <tr>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            {{ label }}
        </td>
        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
            <slot></slot>
        </td>
    </tr>
</template>

<script>
export default {
    name: "KTable",
    props: ["label"],
};
</script>
