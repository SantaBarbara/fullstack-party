/* eslint-disable no-new */

import Vue from 'vue';
import Issues from './components/Issues';

require('./bootstrap');

Vue.component('issues', Issues);

new Vue({
    el: '#app'
});

window.replaceQueryParam = (param, newval, search) => {
    const regex = new RegExp(`([?;&])${param}[^&;]*[;&]?`);
    const query = search.replace(regex, '$1').replace(/&$/, '');

    return (query.length > 2 ? `${query}&` : '?') + (newval ? `${param}=${newval}` : '');
}
