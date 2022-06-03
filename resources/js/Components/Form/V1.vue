<template>
    <div>
        <v-label value="Foo" />
        <v-input class="block mt-1 w-full" />
    </div>
    <div class="mt-4">
        <v-label value="Bar" />
        <v-input class="block mt-1 w-full" />
    </div>
</template>

<script>
import VLabel from "@/Components/VLabel.vue";
import VInput from "@/Components/VInput.vue";

export default {
    name: "V1",
    components: {
        VLabel,
        VInput,
    },
};
</script>
