require('./bootstrap');
import { createApp } from 'vue';
import App from './components/App.vue';
import VueAxios from 'vue-axios';
import axios from 'axios';

import { createRouter, createWebHistory } from 'vue-router';
import { routes } from './routes';

const router = createRouter({
    history: createWebHistory(),
    routes
});

const app = createApp(App)
    .use(router)
    .use(VueAxios, axios);

app.mixin(require('./pathassets'));

app.mount('#app');

/*require('./bootstrap');

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();  */