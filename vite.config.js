import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/toastr.min.css',
                'resources/js/toastr.min.js',
                'resources/js/tall-toasts.js',
            ],
            refresh: true,
        }),
    ],
});
