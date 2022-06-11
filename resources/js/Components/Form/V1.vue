<template>
    <div class="mb-4">
        <div class="flex">
            <k-form-nav-item
                v-for="index in 5"
                :key="index"
                class="mr-4"
                :class="{ 'is-active': section === index }"
                @click="section = index"
            >
                Section {{ index }}
            </k-form-nav-item>
            <k-form-nav-item
                :class="{ 'is-active': section === 6 }"
                @click="section = 6"
            >
                Confirmation
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

                <div class="flex items-center justify-end mt-4">
                    <k-button @click="section = 3">Next</k-button>
                </div>
            </k-form-section>

            <k-form-section v-if="section === 3">
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

                <div class="flex items-center justify-end mt-4">
                    <k-button @click="section = 4">Next</k-button>
                </div>
            </k-form-section>

            <k-form-section v-if="section === 4">
                <h2 class="text-lg font-bold mt-4 mb-2">Staffing Costs</h2>

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
                                'Bar Staff',
                                'Admin Staff',
                                'Coach',
                                'Medics',
                                'Players',
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
                        <tr v-for="item in other_staffing_costs" :key="item">
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
                                <k-button @click="other_staffing_costs++">
                                    Add Additional Category
                                </k-button>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </k-table>

                <div class="flex items-center justify-end mt-4">
                    <k-button @click="section = 5">Next</k-button>
                </div>
            </k-form-section>

            <k-form-section v-if="section === 5">
                <h2 class="text-lg font-bold mt-4 mb-2">
                    Club Income Generated Revenue
                </h2>

                <k-table>
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>£</th>
                            <th>Brief description of activity</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in [
                                'Player membership',
                                'Other membership',
                                'Tickets & Programmes',
                                'Kit sales',
                                'Bar sales',
                                'Food sales',
                                'Social & Fund raising',
                                'Hire of facilities',
                                'Sponsorship & Advertising',
                                'Ticket sales',
                                'Grants',
                                'Other grants',
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
                            v-for="item in other_club_income_generated_revenue"
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
                                <k-button
                                    @click="
                                        other_club_income_generated_revenue++
                                    "
                                >
                                    Add Additional Category
                                </k-button>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </k-table>

                <div class="flex items-center justify-end mt-4">
                    <k-button @click="section = 6">Next</k-button>
                </div>
            </k-form-section>

            <k-form-section v-if="section === 6">
                <p>
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed
                    do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                    ullamco laboris nisi ut aliquip ex ea commodo consequat.
                    Duis aute irure dolor in reprehenderit in voluptate velit
                    esse cillum dolore eu fugiat nulla pariatur.
                </p>
                <p class="mt-6">
                    Please check your details then when you are happy please
                    click the submit button below.
                </p>
                <div class="flex items-center justify-end mt-4">
                    <k-button @click="submit">Complete and Submit</k-button>
                </div>
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
            other_staffing_costs: 0,
            other_club_income_generated_revenue: 0,
        };
    },
};
</script>
