require("./bootstrap");

import { createApp } from "vue";
import VInput from "./Components/VInput";
import VLabel from "./Components/VLabel";

let report = createApp({
    components: {
        VInput,
        VLabel,
    },
});

report.mount("#report");
