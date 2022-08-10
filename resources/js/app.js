require("./bootstrap");

import { createApp } from "vue";
import KForm from "./Layouts/KForm";

let report = createApp({
    components: {
        KForm,
    },
});

report.mount("#report");
