import './bootstrap';
import '../css/app.css';
import '../css/common.css';
import * as utils from './utils.js';
import * as variables from './variable.js';

import { createApp, defineAsyncComponent  } from 'vue/dist/vue.esm-bundler';
//import HomePage from '@/Pages/Home.vue';


//const app = createApp({});

// 注册组件
//app.component('HomePage', HomePage);
const HomePage =  defineAsyncComponent(() => import('./Pages/Home.vue'));
const testA =  defineAsyncComponent(() => import('./Pages/testA.vue'));
const testB =  defineAsyncComponent(() => import('./Pages/testB.vue'));




const app = createApp({});

Object.keys(utils).forEach(key => {
    app.config.globalProperties[`$${key}`] = utils[key];
});
Object.keys(variables).forEach(key => {
    app.config.globalProperties[`$${key}`] = variables[key];
});

// 动态注册组件s
app.component('home-page', HomePage);
app.component('testA', testA);
app.component('testB', testB);
app.mount('#app');

// 挂载应用到指定的 DOM 元素
//app.mount('#app');


