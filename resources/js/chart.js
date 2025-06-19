export function multiLineChart(title, x, ys, labels) {
    const series = ys.map((y, index) => ({
        name: labels[index],
        data: y,
    }));

    return {
        series: series,
        chart: {
            height: 350,
            type: "line",
            dropShadow: {
                enabled: true,
                color: "#000",
                top: 18,
                left: 7,
                blur: 10,
                opacity: 0.5,
            },
            zoom: {
                enabled: false,
            },
            toolbar: {
                show: true,
            },
        },
        xaxis: {
            categories: x,
            title: {
                text: "Tahun",
            },
        },
        yaxis: {
            title: {
                text: "Total",
            },
        },
        legend: {
            position: "bottom",
            horizontalAlign: "center",
        },
        title: {
            text: title,
            align: "left",
        },
    };
}

export function pieChart(title, labels, values) {
    return {
        series: values,
        chart: {
            width: 380,
            type: "pie",
        },
        labels: labels,
        responsive: [
            {
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200,
                    },
                    legend: {
                        position: "bottom",
                    },
                },
            },
        ],
        title: {
            text: title,
            align: "left",
        },
        dataLabels: {
            formatter: function (_, opts) {
                return opts.w.config.series[opts.seriesIndex];
            },
        },
    };
}

export function barChart(title, labels, values) {
    return {
        series: [
            {
                name: "Rata-rata rating",
                data: values,
            },
        ],
        chart: {
            type: "bar",
            height: 350,
        },
        plotOptions: {
            bar: {
                borderRadius: 4,
                borderRadiusApplication: "end",
                horizontal: true,
            },
        },
        title: {
            text: title,
            align: "left",
        },
        dataLabels: {
            enabled: false
        },
        xaxis: {
            categories: labels,
        },
    };
}
