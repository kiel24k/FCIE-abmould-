import { createApp } from 'vue'
import { createPinia } from 'pinia'
import App from './App.vue'
import router from './router'
import 'v-calendar/style.css';
import 'bootstrap/dist/css/bootstrap.min.css'
import './bootstrap';
import VCalendar from 'v-calendar';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';

const pinia = createPinia()
const app = createApp(App)

app.use(pinia)
app.use(router)
app.use(VCalendar, {})
app.use(PrimeVue);
app.use(PrimeVue, {
    theme: {
        preset: Aura
    }
});
app.mount('#app')

