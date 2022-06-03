<template>
    <div>
        <component :is="`VForm${this.version}`"></component>
        <div class="flex items-center justify-end mt-4">
            <v-button>Save</v-button>
        </div>
    </div>
</template>

<script>
import VForm1 from "./Form/V1";
import VButton from "./VButton";

export default {
    name: "VForm",
    props: ["version"],
    components: {
        VForm1,
        VButton,
    },
};
</script>
