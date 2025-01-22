import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    server: {
        host: 'localhost', 
        
        hmr: {
          host: 'localhost'
      },// Ensure it's set to localhost
      },
  plugins: [
    
    laravel({
      input: [
        'resources/css/app.css',  // Use app.css instead of app.scss
        'resources/js/app.js',
      ],
      refresh: true,
    }),
    
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false,
        },
      },
    }),
  ],
  resolve: {
    alias: {
      vue: 'vue/dist/vue.esm-bundler.js',
    },
  },
});
