import './bootstrap';

import Alpine from 'alpinejs';
import collapse from '@alpinejs/collapse'; // 👈 Ajout

window.Alpine = Alpine;
Alpine.plugin(collapse); // 👈 Ajout (avant Alpine.start)
Alpine.start();

import axios from 'axios';
window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';