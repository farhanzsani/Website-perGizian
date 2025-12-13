@props([
    'data' => [], // Array [Jumlah Terpenuhi, Jumlah Tidak Terpenuhi]
    'categories' => ['Terpenuhi', 'Tidak Terpenuhi'],
    'colors' => ['#10B981', '#EF4444'], // Hijau (Sukses), Merah (Gagal)
    'height' => 280,
])

<div class="w-full" x-data="barChart({
    data: @js($data),
    categories: @js($categories),
    colors: @js($colors),
    height: {{ $height }}
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
                            name: 'Jumlah Hari',
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
                                distributed: true, // Agar warna bisa beda per bar
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
                                formatter: (val) => val + " Hari"
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
