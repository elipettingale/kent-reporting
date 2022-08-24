<template>
    <div>
        <div>
            <k-select label="Club" v-model="club" :options="clubs" />
            <p v-if="club_error">This club has not registered yet.</p>
        </div>
        <div class="flex" v-if="club_id">
            <div class="w-full"></div>
            <div class="w-full"></div>
        </div>
    </div>
</template>

<script>
import KButton from "../Components/KButton";
import KLabel from "../Components/KLabel.vue";
import KInput from "../Components/KInput.vue";
import KSelect from "../Components/KSelect.vue";
import clubs from "../data/clubs.json";
import Swal from "sweetalert2";

export default {
    name: "KStats",
    components: {
        KButton,
        KLabel,
        KInput,
        KSelect,
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
        };
    },
    watch: {
        "club.value": function (club) {
            this.club_id = null;
            this.club_error = false;

            if (!club) {
                return;
            }

            axios
                .get(window.location.href + "/club?club=" + club)
                .then(({ data }) => {
                    if (data.success) {
                        this.club_id = data.id;
                    } else {
                        this.club_error = true;
                    }
                });
        },
    },
};
</script>
