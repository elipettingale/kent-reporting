require("./bootstrap");

import { createApp } from "vue";
import VForm from "./Components/VForm";

let report = createApp({
    components: {
        VForm,
    },
});

report.mount("#report");
