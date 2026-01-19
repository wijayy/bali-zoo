import { defineConfig } from "vite";
import tailwindcss from "@tailwindcss/vite";
// import livewire from "livewire-vite-plugin";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        tailwindcss(),
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: false,
        }),
    ],
});
