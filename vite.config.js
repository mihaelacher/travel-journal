import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/style.scss",
                "resources/js/app.js",
                "resources/css/login.scss",
                "resources/js/utils/jquery.js"
            ],
            refresh: true,
        }),
    ],
    optimizeDeps: {
        include: ['jquery'],
    },
});
