@props([
    'series' => [],
    'labels' => [],
    'colors' => ['#3b82f6', '#eab308', '#f97316'],
    'height' => 250,
])

{{-- 1. HTML Wrapper --}}
{{-- Kita panggil komponen Alpine 'donutChart' dan kirim data sebagai parameter object --}}
<div class="w-full flex justify-center" x-data="donutChart({
    series: @js($series),
    labels: @js($labels),
    colors: @js($colors),
    height: {{ $height }}
})">
    <div x-ref="chartContainer" class="w-full"></div>
</div>

{{-- 2. Script Definisi (Hanya dimuat sekali berkat @once) --}}
@once
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('donutChart', (config) => ({
                chart: null,

                init() {
                    // Polling: Tunggu sampai ApexCharts siap
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
                    // FIX ERROR CONSOLE: Paksa konversi data ke Float (Angka)
                    // Jika data string "3.50", diubah jadi angka 3.5
                    const numericSeries = config.series.map(val => parseFloat(val) || 0);

                    const options = {
                        series: numericSeries,
                        labels: config.labels,
                        colors: config.colors,
                        chart: {
                            type: 'donut',
                            height: config.height,
                            fontFamily: 'inherit',
                            background: 'transparent',
                            toolbar: {
                                show: false
                            }
                        },
                        plotOptions: {
                            pie: {
                                donut: {
                                    size: '70%',
                                    labels: {
                                        show: true,
                                        name: {
                                            fontSize: '12px',
                                            color: '#64748b',
                                            offsetY: -5
                                        },
                                        value: {
                                            fontSize: '16px',
                                            fontWeight: 'bold',
                                            color: '#1e293b',
                                            offsetY: 5,
                                            formatter: (val) => val + 'g'
                                        },
                                        total: {
                                            show: true,
                                            label: 'Total',
                                            color: '#64748b',
                                            formatter: (w) => {
                                                // Hitung total dengan aman
                                                return w.globals.seriesTotals.reduce((a, b) =>
                                                    a + b, 0).toFixed(1) + 'g';
                                            }
                                        }
                                    }
                                }
                            }
                        },
                        dataLabels: {
                            enabled: false
                        },
                        legend: {
                            show: false
                        },
                        stroke: {
                            show: true,
                            colors: ['#ffffff'],
                            width: 2
                        },
                        tooltip: {
                            y: {
                                formatter: (val) => val + ' gram'
                            }
                        }
                    };

                    if (this.$refs.chartContainer) {
                        this.chart = new window.ApexCharts(this.$refs.chartContainer, options);
                        this.chart.render();
                    }
                }
            }));
        });
    </script>
@endonce
