<template>
    <div class="mb-4">
        <div class="flex">
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
                    :class="{ 'is-active': section === 99 }"
                    @click="section = 99"
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
            <k-form-section v-if="section === 1">
                <div>
                    <k-label value="Group Entities" />
                    <k-textarea
                        v-model="form.group_entities"
                        :disabled="is_locked"
                    />
                </div>
                <div class="mt-4">
                    <k-label value="Related Parties" />
                    <k-textarea
                        v-model="form.related_parties"
                        :disabled="is_locked"
                    />
                </div>
                <div class="mt-4">
                    <k-label value="Ground Status" />
                    <k-input
                        v-model="form.ground_status"
                        :disabled="is_locked"
                    />
                </div>
                <div class="mt-4">
                    <k-label value="Local Authority" />
                    <k-input
                        v-model="form.local_authority"
                        :disabled="is_locked"
                    />
                </div>
                <div class="mt-4">
                    <k-label value="Turnover Band" />
                    <k-select
                        class="mt-1 w-full"
                        :options="['??1000-??1999', '??2000-??3000']"
                        v-model="form.turnover_band"
                        :disabled="is_locked"
                    />
                </div>
                <div class="mt-4">
                    <k-label value="Details of Related Parties" />
                    <k-textarea
                        v-model="form.related_party_details"
                        :disabled="is_locked"
                    />
                </div>
                <div class="mt-4">
                    <k-label value="Accounts Upload" />
                    <k-upload />
                </div>
                <div class="mt-4">
                    <k-label value="Howden's Risk Assesment Data" />
                    <k-textarea v-model="form.howden_risk_assesment" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <k-button @click="section = 2">Next</k-button>
                </div>
            </k-form-section>
            <k-form-section v-if="section === 2">
                <h2 class="text-lg font-bold mt-4 mb-2">
                    Current Financial Position
                </h2>

                <k-table>
                    <tbody>
                        <tr
                            v-for="(item, key) in {
                                current_bank_balance: 'Current bank balance',
                                club_reserves: 'Club reserves',
                            }"
                            :key="item"
                        >
                            <td>{{ item }}</td>
                            <td>
                                <k-input
                                    class="w-full"
                                    type="number"
                                    v-model="
                                        form.current_financial_position[key]
                                    "
                                />
                            </td>
                        </tr>
                    </tbody>
                </k-table>

                <div class="w-full flex justify-between font-bold">
                    <p>Total</p>
                    <p>??0.00</p>
                </div>

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
                            <th>Monthly ??</th>
                            <th>Note</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, key) in {
                                rent_lease: 'Rent/Lease (Building)',
                                rates: 'Rates',
                                water: 'Water',
                                gas_electric: 'Gas & Electricity',
                                kit: 'Kit',
                                travel: 'Travel',
                                pitch_maintenance: 'Pitch Maintenance',
                                bar_purchases: 'Bar Purchases',
                                food_purchases: 'Food Purchases',
                                international_tickets: 'International Tickets',
                                interest: 'Interest',
                                grant_repayments: 'Grant Repayments',
                                broadband: 'Broadband/phone/TV',
                                building_insurance: 'Buildings Insurance',
                                contents_insurance: 'Contents Insurance',
                                other_insurance: 'Insurance Other',
                                equipment_rental: 'Equipment Rental',
                                loan_repyments: 'Loan Repayments',
                                cleaning_contract: 'Cleaning Contract',
                                security_alarm: 'Security/alarm',
                                sanitary: 'Sanitary',
                                laundry: 'Laundry',
                                building_maintenance: 'Building maintenance',
                                vat: 'VAT',
                            }"
                            :key="item"
                        >
                            <td>{{ item }}</td>
                            <td>
                                <k-input
                                    class="w-full"
                                    type="number"
                                    v-model="form.club_running_costs[key].value"
                                />
                            </td>
                            <td>
                                <k-input
                                    class="w-full"
                                    v-model="form.club_running_costs[key].note"
                                />
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

                <h2 class="text-lg font-bold mt-4 mb-2">Staffing Costs</h2>

                <k-table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>Monthly ??</th>
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
                    <k-button @click="section = 4">Next</k-button>
                </div>
            </k-form-section>

            <k-form-section v-if="section === 4">
                <h2 class="text-lg font-bold mt-4 mb-2">
                    Club Income Generated Revenue
                </h2>

                <k-table>
                    <thead>
                        <tr>
                            <th>Activity</th>
                            <th>??</th>
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
                    <k-button @click="section = 5">Next</k-button>
                </div>
            </k-form-section>

            <k-form-section v-if="section === 5">
                <h2 class="text-lg font-bold mt-4 mb-2">Balance Sheet</h2>

                <k-table>
                    <thead>
                        <tr>
                            <th>Asset</th>
                            <th>Accounting Value (??)</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in [
                                'Freehold Property',
                                'Plant & Equipment',
                                'Other Fixed Assets',
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
                    </tbody>
                </k-table>

                <div class="w-full flex justify-between font-bold">
                    <p>Total Fixed Assets</p>
                    <p>??0.00</p>
                </div>

                <k-table>
                    <thead>
                        <tr>
                            <th>Asset</th>
                            <th>Accounting Value (??)</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in [
                                'Rugby Stock',
                                'Clubhouse Stock',
                                'Investments',
                                'Debtors',
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
                    </tbody>
                </k-table>

                <div class="w-full flex justify-between font-bold">
                    <p>Total Current Assets</p>
                    <p>??0.00</p>
                </div>

                <div class="w-full flex justify-between font-bold">
                    <p>Total Assets</p>
                    <p>??0.00</p>
                </div>

                <hr />

                <k-table>
                    <thead>
                        <tr>
                            <th>Liability</th>
                            <th>Due within 12 months</th>
                            <th>Due after 12 months</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in [
                                'HMRC',
                                'Rugby Creditors',
                                'GRFU Loans',
                                'RFU/RFF Loans',
                                'Banks Loans',
                                'Accruals',
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
                        <tr v-for="item in other_liabilities" :key="item">
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
                                <k-button @click="other_liabilities++">
                                    Add Additional Liability
                                </k-button>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </k-table>

                <k-table>
                    <thead>
                        <tr>
                            <th>Off balance sheet liabilities</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="item in [
                                'Related party guarantees',
                                'Cross holdings',
                            ]"
                            :key="item"
                        >
                            <td>{{ item }}</td>
                            <td>
                                <k-input class="w-full" type="number" />
                            </td>
                        </tr>
                        <tr
                            v-for="item in other_off_balance_liabilities"
                            :key="item"
                        >
                            <td>
                                <k-input class="w-full" />
                            </td>
                            <td>
                                <k-input class="w-full" type="number" />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center">
                                <k-button
                                    @click="other_off_balance_liabilities++"
                                >
                                    Add Additional Off Balance Sheet Liability
                                </k-button>
                            </td>
                            <td></td>
                        </tr>
                    </tbody>
                </k-table>

                <div class="flex items-center justify-end mt-4">
                    <k-button @click="section = 99">Next</k-button>
                </div>
            </k-form-section>

            <k-form-section v-if="section === 99">
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
    created() {
        axios.get(window.location.href + "/data").then(({ data }) => {
            if (data.status !== "complete") {
                this.is_locked = false;
            }

            if (data.data) {
                this.form = data.data;
            }
        });
    },
    mounted() {
        this.debounced_save = _.debounce(this.save, 1000);
    },
    data: function () {
        return {
            section: 1,
            other_club_running_costs: 0,
            other_staffing_costs: 0,
            other_club_income_generated_revenue: 0,
            other_liabilities: 0,
            other_off_balance_liabilities: 0,
            is_saved: true,
            is_locked: true,
            form: {
                group_entities: null,
                related_parties: null,
                ground_status: null,
                local_authority: null,
                turnover_band: null,
                current_financial_position: {
                    current_bank_balance: null,
                    club_reserves: null,
                },
                club_running_costs: {
                    rent_lease: {
                        value: null,
                        note: null,
                    },
                    rates: {
                        value: null,
                        note: null,
                    },
                    water: {
                        value: null,
                        note: null,
                    },
                    gas_electric: {
                        value: null,
                        note: null,
                    },
                    kit: {
                        value: null,
                        note: null,
                    },
                    travel: {
                        value: null,
                        note: null,
                    },
                    pitch_maintenance: {
                        value: null,
                        note: null,
                    },
                    bar_purchases: {
                        value: null,
                        note: null,
                    },
                    food_purchases: {
                        value: null,
                        note: null,
                    },
                    international_tickets: {
                        value: null,
                        note: null,
                    },
                    interest: {
                        value: null,
                        note: null,
                    },
                    grant_repayments: {
                        value: null,
                        note: null,
                    },
                    broadband: {
                        value: null,
                        note: null,
                    },
                    building_insurance: {
                        value: null,
                        note: null,
                    },
                    contents_insurance: {
                        value: null,
                        note: null,
                    },
                    other_insurance: {
                        value: null,
                        note: null,
                    },
                    equipment_rental: {
                        value: null,
                        note: null,
                    },
                    loan_repyments: {
                        value: null,
                        note: null,
                    },
                    cleaning_contract: {
                        value: null,
                        note: null,
                    },
                    security_alarm: {
                        value: null,
                        note: null,
                    },
                    sanitary: {
                        value: null,
                        note: null,
                    },
                    laundry: {
                        value: null,
                        note: null,
                    },
                    building_maintenance: {
                        value: null,
                        note: null,
                    },
                    vat: {
                        value: null,
                        note: null,
                    },
                },
            },
        };
    },
    computed: {
        save_status() {
            if (this.is_saved) {
                return "Saved";
            }

            return "...Saving";
        },
    },
    watch: {
        form: {
            handler(value) {
                console.log(value);

                if (!this.is_locked) {
                    this.is_saved = false;
                    this.debounced_save(value);
                }
            },
            deep: true,
        },
    },
    methods: {
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
