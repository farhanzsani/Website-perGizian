import "./bootstrap";
import ApexCharts from "apexcharts";
import Alpine from "alpinejs";
import { createIcons, icons } from "lucide";

window.Alpine = Alpine;

Alpine.start();

createIcons({
    icons,
});
window.ApexCharts = ApexCharts;
