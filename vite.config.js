import { defineConfig } from 'vite';
import symfonyPlugin from 'vite-plugin-symfony';

export default defineConfig({
    plugins: [
        symfonyPlugin({
            stimulus: true
        }),
    ],
    css: {
        preprocessorOptions: {
            scss: {
                // Cette option désactive les avertissements de dépréciation
                // pour les fichiers situés dans node_modules
                quietDeps: true,
                // Sur les versions très récentes de Sass, vous pouvez aussi avoir besoin de :
                silenceDeprecations: ['color-functions', 'import', 'global-builtin'],
            },
        },
    },
    build: {
        rollupOptions: {
            input: {
                app: "./assets/app.ts"
            },
        }
    },
});