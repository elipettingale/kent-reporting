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

        <h2 class="text-lg font-bold mt-4 mb-2">Current Financial Position</h2>
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
                        <k-input class="w-full" type="number" prefix="£" />
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
                <tr>
                    <td>Rent/Lease (Building)</td>
                    <td>
                        <k-input class="w-full" type="number" />
                    </td>
                    <td>
                        <k-input class="w-full" />
                    </td>
                </tr>
                <tr>
                    <td>Rates</td>
                    <td>
                        <k-input class="w-full" type="number" />
                    </td>
                    <td>
                        <k-input class="w-full" />
                    </td>
                </tr>
                <tr>
                    <td>Water</td>
                    <td>
                        <k-input class="w-full" type="number" />
                    </td>
                    <td>
                        <k-input class="w-full" />
                    </td>
                </tr>
            </tbody>
        </k-table>
    </k-form-section>
</template>

<script>
import KLabel from "../KLabel.vue";
import KInput from "../KInput.vue";
import KTextarea from "../KTextarea.vue";
import KUpload from "../KUpload.vue";
import KFormSection from "../KFormSection.vue";
import KButton from "../KButton.vue";
import KTable from "../KTable.vue";
import KTableRow from "../KTableRow.vue";

export default {
    name: "V1",
    components: {
        KLabel,
        KInput,
        KTextarea,
        KUpload,
        KFormSection,
        KButton,
        KTable,
        KTableRow,
    },
    data: function () {
        return {
            section: 1,
        };
    },
};
</script>
