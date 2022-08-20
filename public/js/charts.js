'use strict';

// Apex Chart
var options = {
    series: [{
        name: "Visitors",
        data: [0, 50, 20, 40, 27, 50, 35, 60]
    }],
    chart: {
        height: 360,
        type: 'area',
        toolbar: {
            export: {
                csv: {
                    filename: 'Store Visitors',
                    columnDelimiter: ',',
                    headerCategory: 'Date',
                },
                svg: {
                    filename: 'Store Visitors',
                },
                png: {
                    filename: 'Store Visitors',
                }
            },
        }
    },
    colors: ['#2DCD7A'],
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 90, 100]
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'smooth'
    },
    xaxis: {
        type: 'datetime',
        categories: [
            "01 Jan 2021",
            "02 Jan 2021",
            "03 Jan 2021",
            "04 Jan 2021",
            "05 Jan 2021",
            "06 Jan 2021",
            "07 Jan 2021",
            "08 Jan 2021"
        ],
        labels: {
            style: {
                colors: 'var(--text-color)',
                fontSize: '10px',
                fontFamily: 'Montserrat,sans-serif',
                fontWeight: 400,
                cssClass: 'apexcharts-xaxis-label',
            },
        },
    },
    yaxis: {
        labels: {
            style: {
                colors: 'var(--text-color)',
                fontSize: '10px',
                fontFamily: 'Montserrat,sans-serif',
                fontWeight: 400,
                cssClass: 'apexcharts-xaxis-label',
            },
        },
    },
    tooltip: {
        theme: 'dark',
        style: {
            fontSize: '12px',
            fontFamily: 'Montserrat,sans-serif',
        },
        x: {
            format: 'dd MMM, yyyy',
        },

    },
    title: {
        text: 'Store Visitors',
        align: 'left',
        style: {
            fontSize: '20px',
            fontWeight: '400',
            fontFamily: "Montserrat,sans-serif",
            color: 'var(--text-color)'
        },
    },
};

var chartElement = document.querySelector("#chart");
if (typeof(chartElement) != 'undefined' && chartElement != null) {
    var chart = new ApexCharts(chartElement, options);
    chart.render();
}

// ==================================================================
// ==================================================================
// ==================================================================


var totalSalesOptions = {
    series: [
		{
			name: "Main Data",
			data: [0, 50, 20, 40, 27, 50, 35, 60]
		},
		{
			name: "Compare Data",
			data: [0, 40, 10, 30, 17, 40, 25, 50]
		}
	],
	legend: {
		height: 40,
		offsetY: 15,
		labels: {
			colors: 'var(--text-color)',
			useSeriesColors: false
		},
		itemMargin: {
			horizontal: 15,
			vertical: 0
		},
	},
    chart: {
        height: 400,
        type: 'area',
        toolbar: {
            export: {
                csv: {
                    filename: 'Store Total Sales',
                    columnDelimiter: ',',
                    headerCategory: 'Date',
                },
                svg: {
                    filename: 'Store Total Sales',
                },
                png: {
                    filename: 'Store Total Sales',
                }
            },
        }
    },
    fill: {
        type: "gradient",
        gradient: {
            shadeIntensity: 1,
            opacityFrom: 0.7,
            opacityTo: 0.5,
            stops: [0, 90, 100]
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        curve: 'smooth'
    },
    xaxis: {
        type: 'datetime',
        categories: [
            "01 Jan 2021",
            "02 Jan 2021",
            "03 Jan 2021",
            "04 Jan 2021",
            "05 Jan 2021",
            "06 Jan 2021",
            "07 Jan 2021",
            "08 Jan 2021"
        ],
        labels: {
            style: {
                colors: 'var(--text-color)',
                fontSize: '10px',
                fontFamily: 'Montserrat,sans-serif',
                fontWeight: 400,
                cssClass: 'apexcharts-xaxis-label',
            },
        },
    },
    yaxis: {
        labels: {
            style: {
                colors: 'var(--text-color)',
                fontSize: '10px',
                fontFamily: 'Montserrat,sans-serif',
                fontWeight: 400,
                cssClass: 'apexcharts-xaxis-label',
            },
        },
    },
    tooltip: {
        theme: 'dark',
        style: {
            fontSize: '12px',
            fontFamily: 'Montserrat,sans-serif',
        },
        x: {
            format: 'dd MMM, yyyy',
        },

    },
    title: {
        text: 'Total Sales',
        align: 'left',
        style: {
            fontSize: '20px',
            fontWeight: '400',
            fontFamily: "Montserrat,sans-serif",
            color: 'var(--text-color)'
        },
    },
};

var chartElement = document.querySelector("#total-sales-chart");
if (typeof(chartElement) != 'undefined' && chartElement != null) {
    var chart = new ApexCharts(chartElement, totalSalesOptions);
    chart.render();
}

// ==================================================================
// ==================================================================
// ==================================================================

var orderOverviewOptions = {
    series: [
		{
			name: "Main Data",
			data: [0, 20, 40, 18, 50, 18, 22, 60]
		},
		{
			name: "Compare Data",
			data: [0, 5, 10, 30, 17, 40, 25, 50]
		}
	],
	legend: {
		height: 40,
		offsetY: 15,
		labels: {
			colors: 'var(--text-color)',
			useSeriesColors: false
		},
		itemMargin: {
			horizontal: 15,
			vertical: 0
		},
	},
    chart: {
        height: 400,
        type: 'line',
        toolbar: {
            export: {
                csv: {
                    filename: 'Store Orders Overview',
                    columnDelimiter: ',',
                    headerCategory: 'Date',
                },
                svg: {
                    filename: 'Store Orders Overview',
                },
                png: {
                    filename: 'Store Orders Overview',
                }
            },
        }
    },
    dataLabels: {
        enabled: false,
    },
    xaxis: {
        type: 'datetime',
        categories: [
            "01 Jan 2021",
            "02 Jan 2021",
            "03 Jan 2021",
            "04 Jan 2021",
            "05 Jan 2021",
            "06 Jan 2021",
            "07 Jan 2021",
            "08 Jan 2021"
        ],
        labels: {
            style: {
                colors: 'var(--text-color)',
                fontSize: '10px',
                fontFamily: 'Montserrat,sans-serif',
                fontWeight: 400,
                cssClass: 'apexcharts-xaxis-label',
            },
        },
    },
    yaxis: {
        labels: {
            style: {
                colors: 'var(--text-color)',
                fontSize: '10px',
                fontFamily: 'Montserrat,sans-serif',
                fontWeight: 400,
                cssClass: 'apexcharts-xaxis-label',
            },
        },
    },
    tooltip: {
        theme: 'dark',
        style: {
            fontSize: '12px',
            fontFamily: 'Montserrat,sans-serif',
        },
        x: {
            format: 'dd MMM, yyyy',
        },

    },
    title: {
        text: 'Orders Overview',
        align: 'left',
        style: {
            fontSize: '20px',
            fontWeight: '400',
            fontFamily: "Montserrat,sans-serif",
            color: 'var(--text-color)'
        },
    },
};

var chartElement = document.querySelector("#orders-overview-chart");
if (typeof(chartElement) != 'undefined' && chartElement != null) {
    var chart = new ApexCharts(chartElement, orderOverviewOptions);
    chart.render();
}

// ==================================================================
// ==================================================================
// ==================================================================

var itemsSoldOptions = {
    series: [
		{
			name: "Main Data",
			data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
		},
		{
			name: "Compare Data",
			data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
		}
	],
	legend: {
		height: 40,
		offsetY: 15,
		labels: {
			colors: 'var(--text-color)',
			useSeriesColors: false
		},
		itemMargin: {
			horizontal: 15,
			vertical: 0
		},
	},
    chart: {
        height: 400,
        type: 'bar',
        toolbar: {
            export: {
                csv: {
                    filename: 'Store Items Sold',
                    columnDelimiter: ',',
                    headerCategory: 'Date',
                },
                svg: {
                    filename: 'Store Items Sold',
                },
                png: {
                    filename: 'Store Items Sold',
                }
            },
        }
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
		show: true,
		width: 2,
		colors: ['transparent']
	},
    xaxis: {
        categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
        labels: {
            style: {
                colors: 'var(--text-color)',
                fontSize: '10px',
                fontFamily: 'Montserrat,sans-serif',
                fontWeight: 400,
                cssClass: 'apexcharts-xaxis-label',
            },
        },
    },
    yaxis: {
        labels: {
            style: {
                colors: 'var(--text-color)',
                fontSize: '10px',
                fontFamily: 'Montserrat,sans-serif',
                fontWeight: 400,
                cssClass: 'apexcharts-xaxis-label',
            },
        },
    },
    tooltip: {
        theme: 'dark',
        style: {
            fontSize: '12px',
            fontFamily: 'Montserrat,sans-serif',
        },
        x: {
            format: 'dd MMM, yyyy',
        },

    },
    title: {
        text: 'Items Sold',
        align: 'left',
        style: {
            fontSize: '20px',
            fontWeight: '400',
            fontFamily: "Montserrat,sans-serif",
            color: 'var(--text-color)'
        },
    },
};

var chartElement = document.querySelector("#items-sold-chart");
if (typeof(chartElement) != 'undefined' && chartElement != null) {
    var chart = new ApexCharts(chartElement, itemsSoldOptions);
    chart.render();
}

// ==================================================================
// ==================================================================
// ==================================================================

var totalTaxOptions = {
    series: [
		{
			name: "Main Data",
			data: [44, 50, 44, 56, 61, 58, 63, 60]
		},
		{
			name: "Compare Data",
			data: [50, 52, 48, 55, 45, 55, 38, 42]
		}
	],
	legend: {
		height: 40,
		offsetY: 15,
		labels: {
			colors: 'var(--text-color)',
			useSeriesColors: false
		},
		itemMargin: {
			horizontal: 15,
			vertical: 0
		},
	},
    chart: {
        height: 400,
        type: 'line',
        toolbar: {
            export: {
                csv: {
                    filename: 'Store Total Tax',
                    columnDelimiter: ',',
                    headerCategory: 'Date',
                },
                svg: {
                    filename: 'Store Total Tax',
                },
                png: {
                    filename: 'Store Total Tax',
                }
            },
        }
    },
    dataLabels: {
        enabled: false,
    },
    xaxis: {
        type: 'datetime',
        categories: [
            "01 Jan 2021",
            "02 Jan 2021",
            "03 Jan 2021",
            "04 Jan 2021",
            "05 Jan 2021",
            "06 Jan 2021",
            "07 Jan 2021",
            "08 Jan 2021"
        ],
        labels: {
            style: {
                colors: 'var(--text-color)',
                fontSize: '10px',
                fontFamily: 'Montserrat,sans-serif',
                fontWeight: 400,
                cssClass: 'apexcharts-xaxis-label',
            },
        },
    },
    yaxis: {
        labels: {
            style: {
                colors: 'var(--text-color)',
                fontSize: '10px',
                fontFamily: 'Montserrat,sans-serif',
                fontWeight: 400,
                cssClass: 'apexcharts-xaxis-label',
            },
        },
    },
    tooltip: {
        theme: 'dark',
        style: {
            fontSize: '12px',
            fontFamily: 'Montserrat,sans-serif',
        },
        x: {
            format: 'dd MMM, yyyy',
        },

    },
    title: {
        text: 'Total Tax',
        align: 'left',
        style: {
            fontSize: '20px',
            fontWeight: '400',
            fontFamily: "Montserrat,sans-serif",
            color: 'var(--text-color)'
        },
    },
};

var chartElement = document.querySelector("#total-tax-chart");
if (typeof(chartElement) != 'undefined' && chartElement != null) {
    var chart = new ApexCharts(chartElement, totalTaxOptions);
    chart.render();
}