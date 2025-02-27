import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import fs from 'fs'; // Caso precise ler certificados
import path from 'path'; // Import the 'path' module

export default defineConfig({
    server: {
        https: {
            key: fs.readFileSync(path.resolve(__dirname, '/etc/apache2/ssl/server.key')),
            cert: fs.readFileSync(path.resolve(__dirname, '/etc/apache2/ssl/server.crt')),
        },
        host: '0.0.0.0',
        cors: {
        origin: true,  // Permite todas origens
        credentials: true
        },
        strictPort: true
    },
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
    css: {
        postcss: {
            plugins: [
                tailwindcss(),
            ],
        },
    },
});
