<template>
    <div>
        <div class="mb-4">
            <div class="flex">
                <div class="flex">
                    <!-- todo: color red if has errors -->
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
                    <template
                        v-for="(field, index) in current_section.fields"
                        :key="index"
                    >
                        <template v-if="field.component === 'KTable'">
                            <k-table>
                                <thead v-if="field.headings">
                                    <tr>
                                        <th></th>
                                        <th
                                            v-for="(
                                                heading, index
                                            ) in field.headings"
                                            :key="index"
                                        >
                                            {{ heading }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="row in field.rows"
                                        :key="row.key"
                                    >
                                        <td>{{ row.name }}</td>
                                        <td
                                            v-for="rowField in field.rowFields"
                                            :key="`${row.key}_${rowField.key}`"
                                        >
                                            <component
                                                :is="rowField.component"
                                                :key="`${current_section.key}_${field.key}_${row.key}_${rowField.key}`"
                                                :validationRules="
                                                    rowField.validationRules
                                                "
                                                v-bind="rowField.props"
                                                v-model="
                                                    form_data[
                                                        `${current_section.key}_${field.key}_${row.key}_${rowField.key}`
                                                    ]
                                                "
                                            ></component>
                                        </td>
                                    </tr>
                                </tbody>
                            </k-table>
                        </template>

                        <template v-else-if="field.component === 'KTotal'">
                            <k-total
                                v-bind="field.props"
                                :value="getTotal(field.values)"
                            />
                        </template>

                        <template v-else>
                            <component
                                :is="field.component"
                                :label="field.name"
                                :key="`${current_section.key}_${field.key}`"
                                :disabled="is_locked || field.disabled === true"
                                :validationRules="field.validationRules"
                                v-bind="field.props"
                                v-model="
                                    form_data[
                                        `${current_section.key}_${field.key}`
                                    ]
                                "
                            ></component>
                        </template>
                    </template>

                    <div class="flex items-center justify-end mt-4">
                        <k-button @click="goToNextSection">Next</k-button>
                    </div>
                </k-form-section>
                <k-form-section v-if="current_section_index === 99">
                    Confirmation
                    <!-- todo: message -->
                    <!-- todo: list of sections with number of validation errors (3 issues) etc. click to navigate to section -->
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
import KTotal from "../Components/KTotal.vue";

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
        KTotal,
    },
    created() {
        this.blueprint = require(`../data/form/V${this.version}.json`);

        let form_data = {};

        this.blueprint.sections.forEach((section) => {
            section.fields.forEach((field) => {
                if (field.component === "KTable") {
                    field.rows.forEach((row) => {
                        field.rowFields.forEach((rowField) => {
                            console.log(
                                `${section.key}_${field.key}_${row.key}_${rowField.key}`
                            );
                            form_data[
                                `${section.key}_${field.key}_${row.key}_${rowField.key}`
                            ] = {
                                value: null,
                                error: null,
                            };
                        });
                    });
                } else if (field.key) {
                    form_data[`${section.key}_${field.key}`] = {
                        value: null,
                        error: null,
                    };
                }
            });
        });

        this.form_data = form_data;
        this.is_locked = false;

        // axios.get(window.location.href + "/data").then(({ data }) => {
        //     if (data.status !== "complete") {
        //         this.is_locked = false;
        //     }

        //     if (data.data) {
        //         this.form = data.data;
        //     }
        // });

        // todo: instead of overwriting full data from save, save just the values and patch them into the above data structure
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
        getTotal(matches) {
            let total = 0;

            matches.forEach((match) => {
                let keys = Object.keys(this.form_data).filter((key) => {
                    return new RegExp(match).test(key);
                });

                keys.forEach((key) => {
                    total += parseFloat(this.form_data[key].value || 0);
                });
            });

            return new Intl.NumberFormat("en-UK", {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(total);
        },

        goToNextSection() {
            // todo: validate current section, show warning if they want to continue anyway

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
