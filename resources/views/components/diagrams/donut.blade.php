@props([
    'series' => [],
    'labels' => [],
    'colors' => ['#3b82f6', '#eab308', '#f97316'],
    'height' => 250,
    'satuan' => '', // Default kosong jika tidak diisi
    'showTotal' => true, // Opsi menampilkan total di tengah (true/false)
])

<div class="w-full flex justify-center" x-data="donutChart({
    series: @js($series),
    labels: @js($labels),
    colors: @js($colors),
    height: {{ $height }},
    satuan: '{{ $satuan }}',
    showTotal: {{ $showTotal ? 'true' : 'false' }}
})">
    <div x-ref="chartContainer" class="w-full"></div>
</div>

@once
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('donutChart', (config) => ({
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
                    const numericSeries = config.series.map(val => parseFloat(val) || 0);
                    // Tambahkan spasi sebelum satuan agar rapi (misal: "100 kkal")
                    const unitLabel = config.satuan ? ' ' + config.satuan : '';

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
                                        show: config
                                            .showTotal, // Kontrol tampil/tidaknya label tengah
                                        name: {
                                            fontSize: '11px',
                                            color: '#64748b',
                                            offsetY: -10,
                                            fontWeight: 600
                                        },
                                        value: {
                                            fontSize: '22px',
                                            fontWeight: '900',
                                            color: '#1e293b',
                                            offsetY: 5,
                                            formatter: (val) =>
                                                val // Angka tengah polos tanpa satuan agar bersih
                                        },
                                        total: {
                                            show: config.showTotal,
                                            label: 'Total',
                                            fontSize: '11px',
                                            color: '#64748b',
                                            formatter: (w) => {
                                                // Default: Menampilkan nilai data pertama (Series[0])
                                                // Cocok untuk chart "Target vs Sisa"
                                                let val = w.globals.series[0];
                                                return Math.round(val) + unitLabel;
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
                                formatter: (val) => val + unitLabel // Satuan muncul saat hover
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
