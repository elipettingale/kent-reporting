<template>
    <div v-if="form_data">
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
                            'is-complete': sections[section.key].isComplete,
                            'has-errors': sections[section.key].errorCount > 0,
                        }"
                        @click="goToSection(index)"
                    >
                        {{ section.name }}
                    </k-form-nav-item>
                    <k-form-nav-item
                        :class="{
                            'is-active': current_section_index === 99,
                        }"
                        @click="goToConfirmation"
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
                                                :disabled="
                                                    is_locked ||
                                                    field.disabled === true
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
                                    <tr
                                        v-for="index in form_data[
                                            `${current_section.key}_${field.key}_total_additional_rows`
                                        ]"
                                        :key="index"
                                    >
                                        <td>
                                            <k-input
                                                :key="`${current_section.key}_${field.key}_additional_${index}_label`"
                                                :disabled="
                                                    is_locked ||
                                                    field.disabled === true
                                                "
                                                v-model="
                                                    form_data[
                                                        `${current_section.key}_${field.key}_additional_${index}_label`
                                                    ]
                                                "
                                            />
                                        </td>
                                        <td
                                            v-for="(
                                                rowField, fieldIndex
                                            ) in field.rowFields"
                                            :key="fieldIndex"
                                        >
                                            <component
                                                :is="rowField.component"
                                                :key="`${current_section.key}_${field.key}_additional_${index}_${rowField.key}`"
                                                :disabled="
                                                    is_locked ||
                                                    field.disabled === true
                                                "
                                                v-bind="rowField.props"
                                                v-model="
                                                    form_data[
                                                        `${current_section.key}_${field.key}_additional_${index}_${rowField.key}`
                                                    ]
                                                "
                                            ></component>
                                        </td>
                                    </tr>
                                    <tr v-if="field.canAddAdditional">
                                        <td
                                            :colspan="
                                                field.rowFields.length + 1
                                            "
                                        >
                                            <k-button
                                                :disabled="
                                                    is_locked ||
                                                    field.disabled === true
                                                "
                                                @click="
                                                    addAdditionalRow(
                                                        current_section,
                                                        field
                                                    )
                                                "
                                            >
                                                Add Additional Category
                                            </k-button>
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
                        <k-button @click="validateAndGoToNextSection"
                            >Next</k-button
                        >
                    </div>
                </k-form-section>
                <k-form-section v-if="current_section_index === 99">
                    <p class="text-lg mb-3">Confirmation</p>
                    <div
                        v-for="(section, index) in blueprint.sections"
                        :key="index"
                        class="k-confirmation__section"
                        :class="{
                            'has-errors': sections[section.key].errorCount > 0,
                        }"
                    >
                        <p class="k-confirmation__section__name">
                            {{ section.name }}
                        </p>
                        <p class="k-confirmation__section__counts">
                            {{
                                sections[section.key].totalRequiredFields -
                                sections[section.key].errorCount
                            }}/{{ sections[section.key].totalRequiredFields }}
                        </p>
                    </div>

                    <p v-if="!is_locked" class="my-6">
                        Please ensure you have checked the information you have
                        entered and have filled out as many fields as you can.
                        <br />
                        You will NOT be able to edit this form once you have
                        submitted your it.
                    </p>

                    <div
                        v-if="!is_locked"
                        class="flex items-center justify-end mt-4"
                    >
                        <k-button @click="submit"
                            >Confirm & Submit Form</k-button
                        >
                    </div>
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
import { forEachField } from "../includes/helpers.js";

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
        this.debounced_save = _.debounce(this.save, 1000);
        this.blueprint = require(`../data/form/V${this.version}.json`);

        let form_data = {};

        this.blueprint.sections.forEach((section) => {
            let totalRequiredFields = 0;

            section.fields.forEach((field) => {
                if (field.component === "KTable") {
                    field.rows.forEach((row) => {
                        field.rowFields.forEach((rowField) => {
                            form_data[
                                `${section.key}_${field.key}_${row.key}_${rowField.key}`
                            ] = {
                                value: null,
                                error: null,
                            };

                            if (
                                rowField.required !== false &&
                                !rowField.disabled
                            ) {
                                totalRequiredFields++;
                            }
                        });
                    });

                    form_data[
                        `${section.key}_${field.key}_total_additional_rows`
                    ] = 0;
                } else if (field.key) {
                    form_data[`${section.key}_${field.key}`] = {
                        value: null,
                        error: null,
                    };

                    if (field.required !== false && !field.disabled) {
                        totalRequiredFields++;
                    }
                }
            });

            this.sections[section.key] = {
                isComplete: false,
                errorCount: 0,
                totalRequiredFields: totalRequiredFields,
            };
        });

        axios.get(window.location.href + "/data").then(({ data }) => {
            if (data.data) {
                form_data = {
                    ...form_data,
                    ...data.data,
                };
            }

            if (data.status !== "complete") {
                this.is_locked = false;
            }

            this.form_data = form_data;
        });
    },
    data: function () {
        return {
            is_saved: true,
            is_locked: true,
            current_section_index: 0,
            form_data: null,
            sections: [],
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
                if (!this.is_locked) {
                    this.is_saved = false;
                    this.debounced_save(value);
                }
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

        addAdditionalRow(section, table) {
            let prefix = `${section.key}_${table.key}`;
            let index = this.form_data[`${prefix}_total_additional_rows`] + 1;

            this.form_data[`${prefix}_additional_${index}_label`] = {
                value: null,
                error: null,
            };

            table.rowFields.forEach((field) => {
                this.form_data[`${prefix}_additional_${index}_${field.key}`] = {
                    value: null,
                    error: null,
                };
            });

            this.form_data[`${prefix}_total_additional_rows`] = index;
        },

        validateSection(section) {
            let sectionIsValid = true;
            let errorCount = 0;

            forEachField(section, (key, field) => {
                console.log(this.form_data[key]);
                if (field.required !== false) {
                    if (
                        this.form_data[key]["value"] === null ||
                        this.form_data[key]["value"] === ""
                    ) {
                        this.form_data[key]["error"] = true;
                        sectionIsValid = false;
                        errorCount++;
                    }
                }
            });

            this.sections[section.key].errorCount = errorCount;
            if (errorCount === 0) {
                this.sections[section.key].isComplete = true;
            }

            return sectionIsValid;
        },

        validateAndGoToNextSection() {
            let sectionIsValid = this.validateSection(this.current_section);

            if (sectionIsValid) {
                this.goToNextSection();
            } else {
                // todo: alert: you have not filled out all required fields, are you sure you want to continue?
            }
        },

        goToNextSection() {
            if (
                this.current_section_index + 1 <
                this.blueprint.sections.length
            ) {
                this.current_section_index++;
            } else {
                this.goToConfirmation();
            }

            window.scrollTo(0, 0);
        },

        goToSection(index) {
            if (this.current_section) {
                this.validateSection(this.current_section);
            }

            this.current_section_index = index;
        },

        goToConfirmation() {
            this.blueprint.sections.forEach((section) => {
                this.validateSection(section);
            });

            this.current_section_index = 99;
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
                    data: this.form_data,
                    status: "complete",
                })
                .then(({ data }) => {
                    window.location.href = "/reports";
                });
        },
    },
};
</script>
