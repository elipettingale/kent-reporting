<template>
    <div>
        <component :is="`KForm${this.version}`"></component>
    </div>
</template>

<script>
import KForm1 from "./Form/V1";
import KButton from "./KButton";

export default {
    name: "KForm",
    props: ["version"],
    components: {
        KForm1,
        KButton,
    },
};
</script>
