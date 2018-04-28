
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
require('./bootstrap');
import Vue from 'vue'
import VueRouter from 'vue-router'
import routes from './rutas';
Vue.router = new VueRouter({ routes: routes});
let AppLayout= require('./components/ExampleComponent');
//ELEMENT UI.
import ElementUI from 'element-ui'
import lang from 'element-ui/lib/locale/lang/es'
import locale from 'element-ui/lib/locale'
import 'element-ui/lib/theme-default/index.css'
import 'vue2-animate/dist/vue2-animate.min.css'
import './assets/icon.css'
//Axios
import axios from 'axios'
import VueAxios from 'vue-axios'
//jwt
import VueAuth from '@websanova/vue-auth'
//emoji
import {Picker, Emoji, emojiIndex} from 'emoji-mart-vue'
import Droply from 'droply'

//import Popover from 'vue-js-popover'
import VueChatScroll from 'vue-chat-scroll'


import 'emojionearea/dist/emojionearea.min.css'
import 'emojionearea/dist/emojionearea.min.js'

//youtube
import VueYouTubeEmbed from 'vue-youtube-embed'
Vue.use(VueYouTubeEmbed)

//linkfy
import linkify from 'vue-linkify'
Vue.directive('linkified', linkify)

require('vue2-autocomplete-js/dist/style/vue2-autocomplete.css')

//import VueTimeago from 'vue-timeago'

/*Vue.use(VueTimeago, {
  name: 'timeago', // component name, `timeago` by default
  locale: 'es-ES',
  locales: {
    // you will need json-loader in webpack 1
    'es-ES': require('vue-timeago/locales/es-ES.json')
  }
})*/
window.emojioneVersion = "2.1.1";
Vue.use(VueChatScroll)

Vue.component('chat-messages', require('./components/Home/ChatMessages.vue'));
Vue.component('chat-form', require('./components/Home/ChatForm.vue'));



Vue.component('picker', Picker)
Vue.component('emoji', Emoji)
 
Vue.use(VueAxios, axios)
Vue.use(ElementUI);
locale.use(lang)

Vue.use(VueAuth, {
   auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
   http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
   router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
   rolesVar: 'type',
   loginData: {url: ' api/auth/login'},
   logoutData: {url: ' api/auth/logout'},
   fetchData: {url: ' api/auth/user'},
   refreshData: {enabled: false},
});
Vue.use(VueRouter);
const router = new VueRouter({ mode: 'history', routes: routes})


AppLayout.router = Vue.router;

new Vue(AppLayout).$mount('#app');