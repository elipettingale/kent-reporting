<template>
    <div class="k-field">
        <k-label :value="label" :name="key" />
        <div class="k-upload">
            <input type="file" :disabled="disabled" />
        </div>
        <p v-if="modelValue.error" class="k-field__error">
            {{ modelValue.error }}
        </p>
    </div>
</template>

<script>
import KLabel from "./KLabel.vue";

export default {
    name: "KUpload",
    props: ["label", "key", "modelValue", "disabled"],
    components: {
        KLabel,
    },
};
</script>
