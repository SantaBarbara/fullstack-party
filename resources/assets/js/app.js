/* eslint-disable no-new */

import Vue from 'vue';
import Issues from './components/Issues';

require('./bootstrap');

Vue.component('issues', Issues);

new Vue({
    el: '#app'
});
