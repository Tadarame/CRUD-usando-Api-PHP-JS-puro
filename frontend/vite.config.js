import {defineConfig} from 'vite';
//professor o meu deu erro então eu coloquei para ir pro front 
export default defineConfig({
    root: 'src',
    server : {
        port: 8080,
        strictPort: true,
    },
    build: {
        outDir: '../dist',
        emptyOutDir:true,
    },
});