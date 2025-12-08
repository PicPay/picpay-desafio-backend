import {defineConfig} from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        strictPort: true,
        port: 5173,
        host: '0.0.0.0',
        origin: 'http://localhost:5173',
        cors: {
            origin: ['http://localhost:8080', 'http://localhost:5173'],
            credentials: true,
        },
        hmr: {
            host: 'localhost',
            protocol: 'ws',
        },
        watch: {
            ignored: ['./app/**', './bootstrap/**', './config/**', './database/**', './lang/**', './node_modules/**', './public/**', './routes/**', './storage/**', './tests/**', './vendor/**'],
        },
    },
});
