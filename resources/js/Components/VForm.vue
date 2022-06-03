<template>
    <div>
        <component :is="`V${this.version}`"></component>
        <div class="flex items-center justify-end mt-4">
            <v-button>Save</v-button>
        </div>
    </div>
</template>

<script>
import V1 from "./Form/V1";
import VButton from "./VButton";

export default {
    name: "VForm",
    props: ["version"],
    components: {
        V1,
        VButton,
    },
};
</script>
