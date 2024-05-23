import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.scss', 
                    'resources/js/app.js',
                    'resources/css/index.css',
                    'resources/css/tokens.css',
                    'resources/css/emisor.css',
                    'resources/css/receptor.css',
                    'resources/js/main.js'],
            refresh: true,
        }),
    ],
});
