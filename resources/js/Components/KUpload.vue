<template>
    <div class="k-field">
        <k-label :value="label" :name="key" />
        <div class="k-upload">
            <div class="k-upload__files">
                <div
                    class="k-upload__file"
                    v-for="upload in modelValue.value"
                    :key="upload.id"
                >
                    <span
                        class="k-upload__file__name"
                        v-text="upload.name"
                    ></span>
                    <button
                        class="k-upload__file__remove"
                        @click="deleteUpload(upload.id)"
                    >
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div>
                <input
                    class="k-upload__upload"
                    ref="upload"
                    type="file"
                    :disabled="disabled"
                    @change="upload"
                    multiple
                />
                <p v-if="is_uploading">Uploading...</p>
            </div>
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

    data() {
        return {
            is_uploading: false,
        };
    },

    methods: {
        upload(event) {
            let data = new FormData();

            for (var i = 0; i < event.target.files.length; i++) {
                data.append("uploads[]", event.target.files[i]);
            }

            this.is_uploading = true;

            axios
                .post(window.location.href + "/files", data, {
                    headers: {
                        "Content-Type": "multipart/form-data",
                    },
                })
                .then(({ data }) => {
                    if (data.success) {
                        let uploads = Object.assign([], this.modelValue.value);

                        data.files.forEach((file) => {
                            uploads.push(file);
                        });

                        this.$emit("update:modelValue", {
                            value: uploads,
                            error: null,
                        });

                        this.$refs.upload.value = "";
                        this.is_uploading = false;
                    }
                });
        },

        deleteUpload(id) {
            axios
                .delete(window.location.href + `/files/${id}`)
                .then(({ data }) => {
                    if (data.success) {
                        let uploads = Object.assign([], this.modelValue.value);
                        let index = uploads.findIndex(
                            (upload) => upload.id === id
                        );
                        uploads.splice(index, 1);

                        this.$emit("update:modelValue", {
                            value: uploads,
                            error: null,
                        });
                    }
                });
        },
    },
};
</script>
