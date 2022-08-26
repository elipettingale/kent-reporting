<template>
    <div>
        <div>
            <k-select label="Club" v-model="club" :options="clubs" />
            <p v-if="club_error">This club has not registered yet.</p>
        </div>
        <div class="flex" v-if="club_id">
            <div class="w-full mr-2">
                <div class="mb-4">
                    <k-select
                        label="Financial Year"
                        v-model="financial_year"
                        :options="financial_year_options"
                        :notNull="true"
                        class="mb-2"
                    />
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4"
                >
                    <k-info-item
                        v-for="stat in selected_summary_stats.stats"
                        :key="stat.label"
                        :label="stat.label"
                        :value="stat.value"
                    />
                    <p
                        class="text-sm mt-3 italic"
                        v-if="selected_summary_stats.status !== 'complete'"
                    >
                        Subject to change, user has not submitted this report
                        yet.
                    </p>
                </div>
            </div>
            <div class="w-full ml-2">
                <div class="mb-4">
                    <k-select
                        label="Statistic"
                        v-model="statistic"
                        :options="stat_list"
                        :notNull="true"
                    />
                </div>

                <div
                    class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4"
                    style="height: 350px"
                >
                    <k-chart
                        v-if="!chart_is_loading"
                        :stat="statistic.value"
                        :labels="chart_labels"
                        :values="chart_values"
                    />
                    <p
                        v-if="chart_error"
                        v-text="chart_error"
                        class="text-red-500"
                    ></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import KButton from "../Components/KButton";
import KLabel from "../Components/KLabel.vue";
import KInput from "../Components/KInput.vue";
import KSelect from "../Components/KSelect.vue";
import KInfoItem from "../Components/KInfoItem.vue";
import KChart from "../Components/KChart.vue";
import clubs from "../data/clubs.json";

export default {
    name: "KStats",
    components: {
        KButton,
        KLabel,
        KInput,
        KSelect,
        KInfoItem,
        KChart,
    },
    created() {
        this.clubs = clubs;
    },
    data: function () {
        return {
            club: {
                value: null,
                error: false,
            },
            club_id: null,
            club_error: false,
            summary_stats: {},
            stat_list: [],
            financial_year: {
                value: null,
                error: false,
            },
            statistic: {
                value: null,
                error: false,
            },
            chart_error: null,
            chart_is_loading: true,
            chart_labels: [],
            chart_values: [],
        };
    },
    computed: {
        financial_year_options() {
            return Object.keys(this.summary_stats).reverse();
        },

        selected_summary_stats() {
            return this.summary_stats[this.financial_year.value];
        },
    },
    watch: {
        "club.value": function (club) {
            this.club_id = null;
            this.club_error = false;
            this.summary_stats = [];

            if (!club) {
                return;
            }

            axios
                .get(window.location.href + "/club?club=" + club)
                .then(({ data }) => {
                    if (data.success) {
                        this.club_id = data.id;
                        this.summary_stats = data.years;
                        this.stat_list = data.statList;
                        this.financial_year.value = Object.keys(
                            data.years
                        ).reverse()[0];
                        this.statistic.value = data.statList[0];
                    } else {
                        this.club_error = true;
                    }
                });
        },

        "statistic.value": function (stat) {
            this.chart_is_loading = true;
            this.chart_error = null;
            this.chart_labels = [];
            this.chart_values = [];

            axios
                .get(
                    window.location.href +
                        `/stat?club=${this.club_id}&stat=${stat}`
                )
                .then(({ data }) => {
                    if (data.success) {
                        this.chart_labels = data.labels;
                        this.chart_values = data.values;
                    } else {
                        this.chart_error = data.error;
                    }

                    this.chart_is_loading = false;
                })
                .catch(({ response }) => {
                    this.chart_error = response.data.message;
                });
        },
    },
};
</script>
