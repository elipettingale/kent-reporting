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

var debounced_check_password = _.debounce(function(fill, value) {
    axios.get(`api/password-strength?password=${value}`)
        .then(({data}) => {
            if (data.success) {
                fill.setAttribute('data-score', data.score);
            }
        });
}, 500);

document.querySelectorAll('.password-strength__bar').forEach((bar) => {
    let input = document.querySelector(`#${bar.getAttribute('data-input')}`);
    let fill = bar.querySelector('.password-strength__fill');

    input.addEventListener('input', () => {
        if (input.value === '') {
            fill.setAttribute('data-score', '0');
            return;
        }

        debounced_check_password(fill, input.value);
    })
});

if (document.querySelector('#register-form select#club')) {
    let select = document.querySelector('#register-form select#club');

    select.addEventListener('change', () => {
        let club = select.value;

        if (!club) {
            return;
        }

        axios.get(`api/club-registered?club=${club}`)
            .then(({data}) => {
                let registered = Boolean(data.exists);

                if (registered) {
                    let modal = document.getElementById('already-registered-modal')
                    modal.querySelector('#email-hint').innerHTML = data.hint;
                    modal.style.display = '';
                }
            });
    });
}
