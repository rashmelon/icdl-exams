/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Vue from 'vue';
window.Vue = require('vue');
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('categories', require('./components/categories.vue').default);
Vue.component('view-category', require('./components/viewCategory.vue').default);
Vue.component('skills-card', require('./components/skillsCard.vue').default);
Vue.component('subject', require('./components/subject.vue').default);
Vue.component('candidate', require('./components/candidate.vue').default);
Vue.component('exam', require('./components/exam.vue').default);
Vue.component('view-exam', require('./components/viewExam.vue').default);
Vue.component('reserve', require('./components/reserve.vue').default);
Vue.component('candidate-payment', require('./components/candidatePayment.vue').default);
Vue.component('instruction', require('./components/instruction.vue').default);
Vue.component('view-candidate', require('./components/viewCandidate.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */




/*
*   Import Vue Bootstrap
* */
import BootstrapVue from 'bootstrap-vue'; //Importing
Vue.use(BootstrapVue); // Telling Vue to use this in whole application




let app = new Vue({
    el: '#app',
});
