require("./bootstrap");

import { createApp } from "vue";
import KForm from "./Layouts/KForm";
import KStats from "./Layouts/KStats";
import Swal from "sweetalert2";

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

var debounced_check_password = _.debounce(function (fill, value) {
    axios.get(`api/password-strength?password=${value}`).then(({ data }) => {
        if (data.success) {
            fill.setAttribute("data-score", data.score);
        }
    });
}, 500);

document.querySelectorAll(".password-strength__bar").forEach((bar) => {
    let input = document.querySelector(`#${bar.getAttribute("data-input")}`);
    let fill = bar.querySelector(".password-strength__fill");

    input.addEventListener("input", () => {
        if (input.value === "") {
            fill.setAttribute("data-score", "0");
            return;
        }

        debounced_check_password(fill, input.value);
    });
});

if (document.querySelector("#register-form select#club")) {
    let select = document.querySelector("#register-form select#club");

    select.addEventListener("change", () => {
        let club = select.value;

        if (!club) {
            return;
        }

        axios.get(`api/club-registered?club=${club}`).then(({ data }) => {
            let registered = Boolean(data.exists);

            if (registered) {
                let modal = document.getElementById("already-registered-modal");
                modal.querySelector("#email-hint").innerHTML = data.hint;
                modal.style.display = "";
            }
        });
    });
}

if (document.querySelector("#clubs-table")) {
    document
        .querySelectorAll("#clubs-table #send-reminder")
        .forEach((button) => {
            button.addEventListener("click", () => {
                button.disabled = true;

                let club = button.getAttribute("data-club");
                let email = button.getAttribute("data-email");
                let user = button.getAttribute("data-user");

                Swal.fire({
                    title: "Are you sure?",
                    text: `An email will be sent to ${club} ${email}.`,
                    showCancelButton: true,
                    confirmButtonText: "Yes, Continue",
                    confirmButtonColor: "#354473",
                    cancelButtonText: "No, Go Back",
                    cancelButtonColor: "#ed5858",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .post("api/send-reminder", { user_id: user })
                            .then(({ data }) => {
                                if (data.success) {
                                    document.querySelector(
                                        `td[data-reminder="${user}"`
                                    ).innerHTML = `<p class="text-xs">Reminder Sent: ${data.sent_at}</p>`;
                                }
                            });
                    } else {
                        button.disabled = false;
                    }
                });
            });
        });

    let statusSearch = document.querySelector("#club-search #status");

    statusSearch.addEventListener("change", () => {
        let value = statusSearch.value;

        if (value === "all") {
            document.querySelectorAll("#clubs-table tr").forEach((tr) => {
                tr.style.display = "table-row";
            });
        } else {
            document.querySelectorAll("#clubs-table tbody tr").forEach((tr) => {
                if (tr.getAttribute("data-status") === value) {
                    tr.style.display = "table-row";
                } else {
                    tr.style.display = "none";
                }
            });
        }
    });

    let seasonFilter = document.querySelector("#clubs-table #season-filter");

    seasonFilter.addEventListener("change", () => {
        let value = seasonFilter.value;

        document
            .querySelectorAll("#clubs-table span[data-season]")
            .forEach((season) => {
                if (season.getAttribute("data-season") == value) {
                    season.style.display = "inline";
                } else {
                    season.style.display = "none";
                }
            });
    });

    let reminderForm = document.querySelector("#reminder-form");
    let reminderSend = document.querySelector("#send-reminder");
    let reminderMessage = document.querySelector("#send-message");

    reminderSend.addEventListener("click", () => {
        let data = {
            message_before: reminderForm.querySelector("#message_before").value,
            message_after: reminderForm.querySelector("#message_after").value,
        };

        reminderForm.querySelector("fieldset").disabled = true;
        reminderSend.disabled = true;
        reminderSend.innerHTML = "Sending...";

        axios
            .post("api/send-reminders", data)
            .then(({ data }) => {
                if (data.success) {
                    reminderMessage.innerHTML =
                        "All reminders sent successfully.";
                    reminderSend.style.display = "none";
                } else {
                    reminderMessage.innerHTML =
                        "An error occured, please contact support.";
                    reminderSend.style.display = "none";
                }
            })
            .catch(() => {
                reminderMessage.innerHTML =
                    "An error occured, please contact support.";
                reminderSend.style.display = "none";
            });
    });
}
