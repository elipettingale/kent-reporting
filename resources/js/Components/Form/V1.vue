<template>
    <k-form-section v-if="section === 1">
        <div>
            <k-label value="Group Entities" />
            <k-textarea class="mt-1 w-full" />
        </div>
        <div class="mt-4">
            <k-label value="Related Parties" />
            <k-textarea class="mt-1 w-full" />
        </div>
        <div class="mt-4">
            <k-label value="Ground Status" />
            <k-input class="mt-1 w-full" />
        </div>
        <div class="mt-4">
            <k-label value="Local Authority" />
            <k-input class="mt-1 w-full" />
        </div>
        <div class="mt-4">
            <k-label value="Turnover Band" />
            <k-input class="mt-1 w-full" />
        </div>
        <div class="mt-4">
            <k-label value="Details of Related Parties" />
            <k-textarea class="mt-1 w-full" />
        </div>
        <div class="mt-4">
            <k-label value="Accounts Upload" />
            <k-upload class="mt-1 w-full" />
        </div>
        <div class="mt-4">
            <k-label value="Howden's Risk Assesment Data" />
            <k-textarea class="mt-1 w-full" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <k-button @click="section = 2">Next</k-button>
        </div>
    </k-form-section>
    <k-form-section v-if="section === 2">
        <div>
            <k-label value="Club" />
            <k-input class="mt-1 w-full" type="number" prefix="£" />
        </div>
    </k-form-section>
</template>

<script>
import KLabel from "../KLabel.vue";
import KInput from "../KInput.vue";
import KTextarea from "../KTextarea.vue";
import KUpload from "../KUpload.vue";
import KFormSection from "../KFormSection.vue";
import KButton from "../KButton.vue";

export default {
    name: "V1",
    components: {
        KLabel,
        KInput,
        KTextarea,
        KUpload,
        KFormSection,
        KButton,
    },
    data: function () {
        return {
            section: 2,
        };
    },
};
</script>
