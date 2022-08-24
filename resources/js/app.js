require("./bootstrap");

import { createApp } from "vue";
import KForm from "./Layouts/KForm";
import KStats from "./Layouts/KStats";

if (document.getElementById("report")) {
    let report = createApp({
        components: {
            KForm,
        },
    });

    report.mount("#report");
}

if (document.getElementById("stats")) {
    let stats = createApp({
        components: {
            KStats,
        },
    });

    stats.mount("#stats");
}
