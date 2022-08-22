<template>
    <div class="k-field">
        <k-label :value="label" :name="key" />
        <div class="k-upload" :class="{ 'has-error': modelValue.error }">
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
                    <span
                        class="k-upload__file__remove"
                        @click="deleteUpload(upload.id)"
                    >
                        <svg
                            clip-rule="evenodd"
                            fill-rule="evenodd"
                            stroke-linejoin="round"
                            stroke-miterlimit="2"
                            viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="m12.002 2.005c5.518 0 9.998 4.48 9.998 9.997 0 5.518-4.48 9.998-9.998 9.998-5.517 0-9.997-4.48-9.997-9.998 0-5.517 4.48-9.997 9.997-9.997zm0 8.933-2.721-2.722c-.146-.146-.339-.219-.531-.219-.404 0-.75.324-.75.749 0 .193.073.384.219.531l2.722 2.722-2.728 2.728c-.147.147-.22.34-.22.531 0 .427.35.75.751.75.192 0 .384-.073.53-.219l2.728-2.728 2.729 2.728c.146.146.338.219.53.219.401 0 .75-.323.75-.75 0-.191-.073-.384-.22-.531l-2.727-2.728 2.717-2.717c.146-.147.219-.338.219-.531 0-.425-.346-.75-.75-.75-.192 0-.385.073-.531.22z"
                                fill-rule="nonzero"
                            />
                        </svg>
                    </span>
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

                        if (uploads.length === 0) {
                            uploads = null;
                        }

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
