/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router';

import VueResource from 'vue-resource';

import VueI18n from 'vue-i18n';

import AddGood from './components/AddGood.vue';
import CreateGood from './components/CreateGood.vue';
import EditGood from './components/EditGood.vue';
import CreateCategory from './components/CreateCategory.vue';
import EditCategory from './components/EditCategory.vue';
import locales from './components/locale.vue';

window.busevents = new Vue();

Vue.use(VueRouter);
Vue.use(VueResource);
Vue.use(VueI18n);


const i18n = new VueI18n({
    locale: 'ru',
    messages: locales,
});

Vue.http.headers.common['X-CSRF-TOKEN'] = Laravel.csrfToken;

var router = new VueRouter({
    routes: [
        {path: '/', name: '/'},
        {path: '/creategood/:id', name: 'creategood' , component: CreateGood},
        {path: '/updategood/:id', name: 'updategood', component: EditGood},
        {path: '/addgood/:id', name: 'addgood', component: AddGood},
        {path: '/createcategory/:id', name: 'createcategory' , component: CreateCategory},
        {path: '/updatecategory/:id', name: 'updatecategory' , component: EditCategory},
    ],
});


new Vue({
  el: '#app',
  router: router,
  i18n,
  data: function (){
     return {
        prefix_url: '/api/v1'
     }
  },
  methods: {
  },
  render: h => h(App)
})
