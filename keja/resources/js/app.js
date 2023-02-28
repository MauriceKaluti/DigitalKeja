require('./bootstrap');
window.Vue = require('vue');
import swal from 'sweetalert';
import ElementUI from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'

Vue.use(ElementUI, { locale })

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('dashboard-metric', require('./components/DashbordMetrics.vue').default);
Vue.prototype.$baseUri = document.querySelector("meta[name='baseuri']").content
//xios.defaults.baseURL = baseUri;
axios.defaults.baseURL = document.querySelector("meta[name='baseuri']").content


const app = new Vue({
    el: '#app',
});
