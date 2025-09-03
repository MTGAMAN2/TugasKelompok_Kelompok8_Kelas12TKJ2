import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                "neon-blue": "#3b82f6",
                "neon-pink": "#ec4899",
                "neon-purple": "#8b5cf6",
            },
            backgroundImage: {
                "gradient-futuristic":
                    "linear-gradient(135deg, #3b82f6, #8b5cf6, #ec4899)",
            },
        },
    },

    darkMode: "class",
    theme: {
        extend: {
            colors: {
                "light-bg": "#f3f4f6",
                "light-card": "rgba(255,255,255,0.1)",
                "light-border": "rgba(255,255,255,0.2)",
                "dark-bg": "#1f2937",
                "dark-card": "#111827",
                "dark-border": "#374151",
                "neon-blue": "#3b82f6",
                "neon-pink": "#ec4899",
                "neon-purple": "#8b5cf6",
            },
            backgroundImage: {
                "gradient-futuristic":
                    "linear-gradient(135deg, #3b82f6, #8b5cf6, #ec4899)",
            },
        },
    },
    plugins: [require("@tailwindcss/forms")],

    plugins: [forms],
};
