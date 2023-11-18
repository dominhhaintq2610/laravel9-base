import { defineConfig } from 'vite';
import vue from "@vitejs/plugin-vue";
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        vue(),
        laravel({
            input: ['resources/scss/app.scss', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    server: {
        https: false,
        host: true,
        strictPort: true,
        port: 3000,
        hmr: {host: 'localhost', protocol: 'ws'},
        watch: {
            usePolling:true,
        }
    },
    resolve: {
        alias: {
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap')
        }
    }
});
