import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js', 'resources/js/call.js'],
            refresh: true,
        }),
        tailwindcss(),
        {
            name: 'blade',
            handleHotUpdate({ file, server }) {
                if (file.endsWith('.blade.php')) {
                    server.ws.send({
                        type: 'full-reload',
                        path: '*',
                    });
                }
            }
        }
    ],
    server: {
        // host: '0.0.0.0',
        // origin: 'http://0.0.0.0:8000',
        cors: true,
        // cors: {
        //     origin: [
        //         'http://localhost:8000',
        //         'http://192.168.90.191:8000',
        //         'http://0.0.0.0:8000',
        //         'http://telemedicine.test:8000',
        //     ]
        // },
        // https: {
        //     key: 'D:/Tools/laragon/etc/ssl/laragon.key',
        //     cert: 'D:/Tools/laragon/etc/ssl/laragon.crt'
        // },
    }
});
