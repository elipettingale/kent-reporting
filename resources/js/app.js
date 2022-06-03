require("./bootstrap");

import { createApp } from "vue";
import KForm from "./Components/KForm";

let report = createApp({
    components: {
        KForm,
    },
});

report.mount("#report");
