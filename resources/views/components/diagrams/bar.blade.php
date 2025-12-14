@props([
    'data' => [],
    'categories' => [],
    'colors' => ['#10B981', '#EF4444'],
    'height' => 280,
    'satuan' => 'Hari', // Default satuan
])

<div class="w-full" x-data="barChart({
    data: @js($data),
    categories: @js($categories),
    colors: @js($colors),
    height: {{ $height }},
    satuan: '{{ $satuan }}' // Kirim satuan ke JS
})">
    <div x-ref="chartContainer" class="w-full"></div>
</div>

@once
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('barChart', (config) => ({
                chart: null,

                init() {
                    let checkApex = () => {
                        if (typeof window.ApexCharts !== 'undefined') {
                            this.render();
                        } else {
                            setTimeout(checkApex, 100);
                        }
                    };
                    checkApex();
                },

                render() {
                    const options = {
                        series: [{
                            name: 'Total', // Nama generik, atau bisa dipass via props
                            data: config.data
                        }],
                        chart: {
                            type: 'bar',
                            height: config.height,
                            fontFamily: 'inherit',
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {
                            bar: {
                                borderRadius: 6,
                                columnWidth: '45%',
                                distributed: true,
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false
                        },
                        xaxis: {
                            categories: config.categories,
                            labels: {
                                style: {
                                    fontSize: '12px',
                                    fontWeight: 600
                                }
                            },
                            axisBorder: {
                                show: false
                            },
                            axisTicks: {
                                show: false
                            }
                        },
                        yaxis: {
                            show: false
                    },
                        colors: config.colors,
                        grid: {
                            borderColor: '#f3f4f6',
                            strokeDashArray: 4,
                        },
                        tooltip: {
                            theme: 'light',
                            y: {
                                // Gunakan satuan dinamis dari config
                                formatter: (val) => val + " " + config.satuan
                            }
                        }
                    };

                    if (this.$refs.chartContainer) {
                        this.$refs.chartContainer.innerHTML = "";
                        this.chart = new window.ApexCharts(this.$refs.chartContainer, options);
                        this.chart.render();
                    }
                }
            }));
        });
    </script>
@endonce
