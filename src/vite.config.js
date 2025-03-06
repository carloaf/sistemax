import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from 'tailwindcss';
import fs from 'fs'; // Caso precise ler certificados
import path from 'path'; // Import the 'path' module

export default defineConfig({
    server: {
        host: '0.0.0.0',
        port: 5173,
        strictPort: true,
        https: {
            key: fs.readFileSync(path.resolve(__dirname, '/etc/apache2/ssl/localhost-key.pem')),
            cert: fs.readFileSync(path.resolve(__dirname, '/etc/apache2/ssl/localhost.pem')),
        },
        cors: true,
        hmr: {
            host: '172.22.0.4', // Atualize com o IP do seu container se necessário
            protocol: 'wss', // WebSocket seguro
        }
    },
    define: {
        'process.env': {},
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
