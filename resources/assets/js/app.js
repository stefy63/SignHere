
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Event = new Vue();
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import VueQRCodeComponent from 'vue-qrcode-component';

//Vue.use(require('vue-resource'));
Vue.component('videochat', require('./components/videochat'));
Vue.component('operator', require('./components/operator'));
Vue.component('video-operator', require('./components/video-operator'));
Vue.component('pdf-viewer', require('./components/pdf-viewer'));
Vue.component('qr-code', VueQRCodeComponent);

const app = new Vue({
    el: '#app'
});
