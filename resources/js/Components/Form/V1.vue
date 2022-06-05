<template>
    <div class="mb-4">
        <div class="flex">
            <k-form-nav-item
                class="mr-4"
                :class="{ 'is-active': section === 1 }"
                @click="section = 1"
            >
                Section 1
            </k-form-nav-item>

            <k-form-nav-item
                class="mr-4"
                :class="{ 'is-active': section === 2 }"
                @click="section = 2"
            >
                Section 2
            </k-form-nav-item>
        </div>
    </div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <k-form-section v-if="section === 1">
                <div>
                    <k-label value="Group Entities" />
                    <k-textarea />
                </div>
                <div class="mt-4">
                    <k-label value="Related Parties" />
                    <k-textarea />
                </div>
                <div class="mt-4">
                    <k-label value="Ground Status" />
                    <k-input />
                </div>
                <div class="mt-4">
                    <k-label value="Local Authority" />
                    <k-input />
                </div>
                <div class="mt-4">
                    <k-label value="Turnover Band" />
                    <k-select
                        class="mt-1 w-full"
                        :options="['£1000-£1999', '£2000-£3000']"
                    />
                </div>
                <div class="mt-4">
                    <k-label value="Details of Related Parties" />
                    <k-textarea />
                </div>
                <div class="mt-4">
                    <k-label value="Accounts Upload" />
                    <k-upload />
                </div>
                <div class="mt-4">
                    <k-label value="Howden's Risk Assesment Data" />
                    <k-textarea />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <k-button @click="section = 2">Next</k-button>
                </div>
            </k-form-section>
            <k-form-section v-if="section === 2">
                <div>
                    <k-label value="Club" />
                    <k-input type="number" prefix="£" />
                </div>

                <h2 class="text-lg font-bold mt-4 mb-2">
                    Current Financial Position
                </h2>
                <k-table>
                    <tbody>
                        <tr>
                            <td>Current Balance</td>
                            <td>
                                <k-input class="w-full" type="number" />
                            </td>
                        </tr>

                        <tr>
                            <td>Club Reserves</td>
                            <td>
                                <k-input class="w-full" type="number" />
                            </td>
                        </tr>

                        <tr class="font-bold">
                            <td>Total</td>
                            <td>
                                <k-input
                                    class="w-full"
                                    type="number"
                                    prefix="£"
                                />
                            </td>
                        </tr>
                    </tbody>
                </k-table>

                <h2 class="text-lg font-bold mt-4 mb-2">Club Running Costs</h2>
                <k-table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Monthly £</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in [
                                'Rent/Lease (Building)',
                                'Rates',
                                'Water',
                                'Gas & Electricity',
                                'Kit',
                                'Travel',
                                'Pitch Maintenance',
                                'Bar Purchases',
                                'Food Purchases',
                                'International Tickets',
                                'Interest',
                                'Grant Repayments',
                                'Broadband/phone/TV',
                                'Buildings Insurance',
                                'Contents Insurance',
                                'Insurance Other',
                                'Equipment Rental',
                                'Loan Repayments',
                                'Cleaning Contract',
                                'Security/alarm',
                                'Sanitary',
                                'Laundry',
                                'Building maintenance',
                                'VAT',
                            ]"
                            :key="item"
                        >
                            <td>{{ item }}</td>
                            <td>
                                <k-input class="w-full" type="number" />
                            </td>
                            <td>
                                <k-input class="w-full" />
                            </td>
                        </tr>
                        <tr
                            v-for="item in other_club_running_costs"
                            :key="item"
                        >
                            <td>
                                <k-input class="w-full" />
                            </td>
                            <td>
                                <k-input class="w-full" type="number" />
                            </td>
                            <td>
                                <k-input class="w-full" />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center">
                                <k-button @click="other_club_running_costs++">
                                    Add Additional Category
                                </k-button>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </k-table>
            </k-form-section>
        </div>
    </div>
</template>

<script>
import KLabel from "../KLabel.vue";
import KInput from "../KInput.vue";
import KSelect from "../KSelect.vue";
import KTextarea from "../KTextarea.vue";
import KUpload from "../KUpload.vue";
import KFormSection from "../KFormSection.vue";
import KFormNavItem from "../KFormNavItem.vue";
import KButton from "../KButton.vue";
import KTable from "../KTable.vue";
import KTableRow from "../KTableRow.vue";

export default {
    name: "V1",
    components: {
        KLabel,
        KInput,
        KSelect,
        KTextarea,
        KUpload,
        KFormSection,
        KFormNavItem,
        KButton,
        KTable,
        KTableRow,
    },
    data: function () {
        return {
            section: 1,
            other_club_running_costs: 0,
        };
    },
};
</script>
