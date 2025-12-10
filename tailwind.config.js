import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.js",
        "./node_modules/preline/dist/*.js",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Poppins", "Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                // Primary
                leaf: "#2E9A62",
                mint: "#CFF4E1",

                // Accents
                coral: "#FF8A66",
                sunshine: "#FFD77A",

                // Backgrounds & Surface
                beige: "#FBF7F2",
                eggshell: "#F3F7F4",

                // Text & UI
                slate: "#6B7A7A",
                charcoal: "#243233",

                // Status
                fresh: "#32C48D",
                tomato: "#E04E3D",
            },
        },
    },

    plugins: [forms],
};
