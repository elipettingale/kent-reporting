<template>
    <div class="k-field">
        <k-label :value="label" :name="key" />
        <div class="k-upload">
            <input type="file" />
        </div>
    </div>
</template>

<script>
import KLabel from "./KLabel.vue";

export default {
    name: "KUpload",
    props: ["label", "key"],
    components: {
        KLabel,
    },
};
</script>
