<template>
    <div>
        <div class="mb-4">
            <div class="flex">
                <div class="flex">
                    <k-form-nav-item
                        v-for="(section, index) in blueprint.sections"
                        :key="index"
                        class="mr-4"
                        :class="{
                            'is-active': current_section_index === index,
                        }"
                        @click="current_section_index = index"
                    >
                        {{ section.name }}
                    </k-form-nav-item>
                    <k-form-nav-item
                        :class="{
                            'is-active': current_section_index === 99,
                        }"
                        @click="current_section_index = 99"
                    >
                        Confirmation
                    </k-form-nav-item>
                </div>
                <div class="flex flex-1 justify-end text-right items-center">
                    <p v-text="save_status"></p>
                </div>
            </div>
        </div>
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <k-form-section v-if="current_section">
                    <div
                        v-for="(item, index) in current_section.items"
                        :key="index"
                    >
                        <component
                            :is="item.component"
                            :label="item.name"
                            :key="`${current_section.key}_${item.key}`"
                            :disabled="is_locked || item.disabled === true"
                            v-bind="item.props"
                            v-model="
                                form_data[`${current_section.key}_${item.key}`]
                            "
                        >
                            <template v-if="item.slot">{{
                                item.slot
                            }}</template>
                        </component>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <k-button @click="goToNextSection">Next</k-button>
                    </div>
                </k-form-section>
                <k-form-section v-if="current_section_index === 99">
                    Confirmation
                </k-form-section>
            </div>
        </div>
    </div>
</template>

<script>
import KButton from "../Components/KButton";
import KLabel from "../Components/KLabel.vue";
import KInput from "../Components/KInput.vue";
import KSelect from "../Components/KSelect.vue";
import KTextarea from "../Components/KTextarea.vue";
import KUpload from "../Components/KUpload.vue";
import KFormSection from "../Components/KFormSection.vue";
import KFormNavItem from "../Components/KFormNavItem.vue";
import KTable from "../Components/KTable.vue";
import KTableRow from "../Components/KTableRow.vue";
import KHeader from "../Components/KHeader.vue";

export default {
    name: "KForm",
    props: ["version"],
    components: {
        KButton,
        KLabel,
        KInput,
        KSelect,
        KTextarea,
        KUpload,
        KFormSection,
        KFormNavItem,
        KTable,
        KTableRow,
        KHeader,
    },
    created() {
        this.blueprint = require(`../data/form/V${this.version}.json`);
        console.log(this.blueprint);

        let form_data = {};

        this.blueprint.sections.forEach((section) => {
            section.items.forEach((item) => {
                if (item.key) {
                    form_data[`${section.key}_${item.key}`] = null;
                }
            });
        });

        this.form_data = form_data;
        this.is_locked = false;

        // todo: build form data from this.blueprint
        // basically if it has a key, then save it's value
        // else do nothing here, it will be handled elsewhere

        // axios.get(window.location.href + "/data").then(({ data }) => {
        //     if (data.status !== "complete") {
        //         this.is_locked = false;
        //     }

        //     if (data.data) {
        //         this.form = data.data;
        //     }
        // });

        // todo: instead of overwriting full data from save, save just the values and patch them into the above data structure

        // todo: validation
        // should I have it submit to check validation?
        // or should I have a js validator and put the rules in the json? (prob this one)
    },
    mounted() {
        this.debounced_save = _.debounce(this.save, 1000);
    },
    data: function () {
        return {
            is_saved: true,
            is_locked: true,
            current_section_index: 0,
            form_data: {},
        };
    },
    computed: {
        current_section() {
            return this.blueprint.sections[this.current_section_index];
        },

        save_status() {
            if (this.is_saved) {
                return "Saved";
            }

            return "...Saving";
        },
    },
    watch: {
        form_data: {
            handler(value) {
                console.log(value);

                // if (!this.is_locked) {
                //     this.is_saved = false;
                //     this.debounced_save(value);
                // }
            },
            deep: true,
        },
    },
    methods: {
        goToNextSection() {
            if (
                this.current_section_index + 1 <
                this.blueprint.sections.length
            ) {
                this.current_section_index++;
            } else {
                this.current_section_index = 99;
            }
        },
        save(data) {
            axios
                .patch(window.location.href, {
                    data: data,
                })
                .then(({ data }) => {
                    this.is_saved = true;
                });
        },

        submit() {
            this.debounced_save.cancel();

            axios
                .patch(window.location.href, {
                    data: this.form,
                    status: "complete",
                })
                .then(({ data }) => {
                    window.location.href = "/reports";
                });
        },
    },
};
</script>
