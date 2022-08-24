<template>
    <div>
        <div>
            <k-select label="Club" v-model="club" :options="clubs" />
            <p v-if="club_error">This club has not registered yet.</p>
        </div>
        <div class="flex" v-if="club_id">
            <div class="w-full mr-2">
                <k-select
                    label="Financial Year"
                    v-model="financial_year"
                    :options="financial_year_options"
                    :notNull="true"
                />

                <div>
                    <k-info-item
                        v-for="stat in selected_summary_stats.stats"
                        :key="stat.label"
                        :label="stat.label"
                        :value="stat.value"
                    />
                </div>
            </div>
            <div class="w-full ml-2">
                <k-select label="Statistic" v-model="statistic" :options="[]" />
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
import clubs from "../data/clubs.json";
import Swal from "sweetalert2";

export default {
    name: "KStats",
    components: {
        KButton,
        KLabel,
        KInput,
        KSelect,
        KInfoItem,
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
            financial_year: {
                value: null,
                error: false,
            },
            statistic: {
                value: null,
                error: false,
            },
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
                        this.financial_year.value = Object.keys(
                            data.years
                        ).reverse()[0];
                    } else {
                        this.club_error = true;
                    }
                });
        },
    },
};
</script>
