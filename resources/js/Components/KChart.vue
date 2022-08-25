<template>
    <div>
        <canvas ref="canvas"></canvas>
    </div>
</template>

<script>
import { Chart, registerables } from "chart.js";

export default {
    name: "KChart",
    props: ["stat", "labels", "values"],
    mounted() {
        Chart.register(...registerables);

        let chart = new Chart(this.$refs.canvas, {
            type: "line",
            data: {
                labels: this.labels,
                datasets: [
                    {
                        label: this.stat,
                        data: this.values,
                        borderColor: "rgb(61, 61, 61)",
                        segment: {
                            borderColor: (ctx) =>
                                parseFloat(ctx.p0.raw) > parseFloat(ctx.p1.raw)
                                    ? "rgb(192,75,75)"
                                    : "rgb(75, 192, 192)",
                        },
                    },
                ],
            },
            options: {
                animation: false,
                plugins: {
                    legend: null,
                },
            },
        });
    },
};
</script>
