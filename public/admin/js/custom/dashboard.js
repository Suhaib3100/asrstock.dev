"use strict";
var patientStatisticsOptions = {
    chart: {
        height: 370,
        type: 'radialBar',
        redrawOnParentResize: false,
        redrawOnWindowResize: false,
    },
    series:patiSeris,
    labels: patiLab,
    legend: {
        show: true,
        position: 'bottom',
        customLegendItems:customLegendItems,
        onItemHover: {
            highlightDataSeries: true
        },
    },
    tooltip: {
        enabled: true,
        fillSeriesColor:false
    },
    stroke: {
        lineCap: 'round'
    },
    plotOptions: {
        radialBar: {
            hollow: {
                margin: 5,
                size: '50px',
            },
            track: {
                background: '#F2F6F7',
            },
            dataLabels: {
                name: {
                    fontSize: '22px',
                },
                value: {
                    fontSize: '24px',
                    fontWeight: 600,
                    color: '#4D88FF',
                },
                total: {
                    show: false,

                }
            }
        }
    },
}

var patientStatisticsChart = new ApexCharts(document.querySelector("#patient-statistics-chart"), patientStatisticsOptions);
patientStatisticsChart.render();


var dailySellChartData = {
    series: [{
        name: 'Total Sells',
        data: dailyData1,
        redrawOnParentResize: false,
        redrawOnWindowResize: false,
    },{
        name: 'Sells Count',
        data: dailyData2
    }],
    chart: {
        height: 350,
        type: 'bar',
        stacked: true,
        toolbar:{
            show: true
        }
    },
    color: ['#5991FF'],
    plotOptions: {
        bar: {
            borderRadius: 4,
            dataLabels: {
                position: 'top',
            },
        }
    },
    dataLabels: {
        enabled: true,
        formatter: function (val,opts) {
            if(opts.seriesIndex === 1) {
                return val
            }
            if(val === 0) {
                return val
            }
            return val + ' ' + currencySymble
        },
        offsetY: -20,
        style: {
            fontFamily: 'Inter, sans-serif',
            fontSize: '12px',
            fontWeight: 500,
            colors: ['#596680']
        },
    },

    xaxis: {
        categories: categories,
        position: 'bottom',
        axisBorder: {
            show: false
        },
        axisTicks: {
            show: false
        },
        crosshairs: {
            fill: {
                type: 'gradient',
                gradient: {
                    colorFrom: '#D8E3F0',
                    colorTo: '#BED1E6',
                    stops: [0, 100],
                    opacityFrom: 0.4,
                    opacityTo: 0.5,
                }
            }
        },
        tooltip: {
            enabled: true,
        },
        style: {
            fontFamily: 'Inter, sans-serif',
            cssClass: 'apexcharts-xaxis-label',
        },
    },
};

var dailySell = new ApexCharts(document.querySelector("#saleChart"), dailySellChartData);
dailySell.render();

$(document).ready(function () {
    ("use strict");
    $("#topFiveProducts").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: false,
        processing: true,
        responsive: true,
        searching: false,
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search event",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '',
    });
    $("#dashboardWithdraw").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: false,
        processing: true,
        responsive: true,
        searching: false,
        language: {
            paginate: {
                previous: "<i class='fa-solid fa-angles-left'></i>",
                next: "<i class='fa-solid fa-angles-right'></i>",
            },
            searchPlaceholder: "Search event",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        dom: '',
    });
});
