import ApexCharts from 'apexcharts';

window.ApexCharts = ApexCharts;

window.dashboardApp = function () {
    return {
        sidebarOpen: false,

        performancePeriod: '6',

        performanceChart: null,
        attendanceChart: null,

        init() {
            this.$nextTick(() => {
                this.renderCharts();
            });
        },

        renderCharts() {
            this.createPerformanceChart();
            this.createAttendanceChart();
        },

        createPerformanceChart() {
            const element = document.getElementById(
                'performance-chart'
            );

            if (!element) {
                console.error(
                    'Performance chart element not found.'
                );

                return;
            }

            if (!window.ApexCharts) {
                console.error(
                    'ApexCharts is not loaded.'
                );

                return;
            }

            if (this.performanceChart) {
                this.performanceChart.destroy();
            }

            const options = {
                chart: {
                    type: 'area',
                    height: 300,

                    toolbar: {
                        show: false
                    },

                    zoom: {
                        enabled: false
                    }
                },

                series: [
                    {
                        name: 'Performance',

                        data: [
                            72,
                            76,
                            74,
                            81,
                            84,
                            89
                        ]
                    }
                ],

                xaxis: {
                    categories: [
                        'Apr',
                        'May',
                        'Jun',
                        'Jul',
                        'Aug',
                        'Sep'
                    ],

                    axisBorder: {
                        show: false
                    },

                    axisTicks: {
                        show: false
                    },

                    labels: {
                        style: {
                            colors: '#94a3b8',
                            fontSize: '11px'
                        }
                    }
                },

                yaxis: {
                    min: 60,
                    max: 100,
                    tickAmount: 4,

                    labels: {
                        style: {
                            colors: '#94a3b8',
                            fontSize: '11px'
                        }
                    }
                },

                stroke: {
                    curve: 'smooth',
                    width: 3
                },

                fill: {
                    type: 'gradient',

                    gradient: {
                        opacityFrom: 0.25,
                        opacityTo: 0.03
                    }
                },

                markers: {
                    size: 4,

                    hover: {
                        size: 6
                    }
                },

                grid: {
                    borderColor: '#e2e8f0',
                    strokeDashArray: 4
                },

                dataLabels: {
                    enabled: false
                },

                tooltip: {
                    y: {
                        formatter: function (value) {
                            return value + '%';
                        }
                    }
                }
            };

            this.performanceChart =
                new window.ApexCharts(
                    element,
                    options
                );

            this.performanceChart.render();
        },

        createAttendanceChart() {
            const element = document.getElementById(
                'attendance-chart'
            );

            if (!element) {
                console.error(
                    'Attendance chart element not found.'
                );

                return;
            }

            if (!window.ApexCharts) {
                console.error(
                    'ApexCharts is not loaded.'
                );

                return;
            }

            if (this.attendanceChart) {
                this.attendanceChart.destroy();
            }

            const options = {
                chart: {
                    type: 'donut',
                    height: 270,

                    toolbar: {
                        show: false
                    }
                },

                series: [
                    92,
                    8
                ],

                labels: [
                    'Present',
                    'Absent'
                ],

                colors: [
                    '#10b981',
                    '#ef4444'
                ],

                legend: {
                    show: false
                },

                dataLabels: {
                    enabled: false
                },

                plotOptions: {
                    pie: {
                        donut: {
                            size: '72%',

                            labels: {
                                show: true,

                                name: {
                                    show: true,
                                    fontSize: '13px',
                                    color: '#94a3b8'
                                },

                                value: {
                                    show: true,
                                    fontSize: '28px',
                                    fontWeight: 700,
                                    color: '#0f172a',

                                    formatter: function (
                                        value
                                    ) {
                                        return value + '%';
                                    }
                                },

                                total: {
                                    show: true,
                                    label: 'Attendance',

                                    formatter: function () {
                                        return '92%';
                                    }
                                }
                            }
                        }
                    }
                },

                tooltip: {
                    y: {
                        formatter: function (value) {
                            return value + '%';
                        }
                    }
                }
            };

            this.attendanceChart =
                new window.ApexCharts(
                    element,
                    options
                );

            this.attendanceChart.render();
        },

        updatePerformanceChart() {
            if (!this.performanceChart) {
                return;
            }

            if (this.performancePeriod === '12') {
                this.performanceChart.updateOptions({
                    xaxis: {
                        categories: [
                            'Oct',
                            'Nov',
                            'Dec',
                            'Jan',
                            'Feb',
                            'Mar',
                            'Apr',
                            'May',
                            'Jun',
                            'Jul',
                            'Aug',
                            'Sep'
                        ]
                    }
                });

                this.performanceChart.updateSeries([
                    {
                        name: 'Performance',

                        data: [
                            68,
                            71,
                            70,
                            73,
                            75,
                            78,
                            72,
                            76,
                            74,
                            81,
                            84,
                            89
                        ]
                    }
                ]);
            } else {
                this.performanceChart.updateOptions({
                    xaxis: {
                        categories: [
                            'Apr',
                            'May',
                            'Jun',
                            'Jul',
                            'Aug',
                            'Sep'
                        ]
                    }
                });

                this.performanceChart.updateSeries([
                    {
                        name: 'Performance',

                        data: [
                            72,
                            76,
                            74,
                            81,
                            84,
                            89
                        ]
                    }
                ]);
            }
        }
    };
};