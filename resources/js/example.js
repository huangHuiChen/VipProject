import './bootstrap';
import '../css/app.css';

//import { createApp, h } from 'vue';
import { createApp } from 'vue/dist/vue.esm-bundler';

/*import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';*/
import Header from './Components/Header.vue';


const app = createApp({});
app.component('example-component', Header);

app.mount('#app');

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

//createInertiaApp({
//    title: (title) => `${title} - ${appName}`,
//    resolve: (name) => resolvePageComponent(`./Components/${name}.vue`, import.meta.glob('./Components/**/*.vue')),
//    setup({  App, props, plugin }) {//
//        return createApp({ render: () => h(App, props) })
//            .use(plugin)
//            .use(ZiggyVue)
//            .mount('#app');
//    },
//    progress: {
//        color: '#4B5563',
//    },
//});
