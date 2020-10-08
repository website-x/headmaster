require('./bootstrap');

import Vue from 'vue';

import { InertiaApp } from '@inertiajs/inertia-vue';
import { InertiaForm } from 'laravel-jetstream';
import PortalVue from 'portal-vue';
import vueCountryRegionSelect from 'vue-country-region-select';
//added for search select and datepicker
import 'vue-search-select/dist/VueSearchSelect.css'
import { Datetime } from 'vue-datetime'
import 'vue-datetime/dist/vue-datetime.css'

Vue.use(InertiaApp);
Vue.use(InertiaForm);
Vue.use(PortalVue);
Vue.use(vueCountryRegionSelect);
Vue.use(Datetime)
Vue.component('datetime', Datetime);

const app = document.getElementById('app');

Vue.prototype.$route = (...args) => route(...args).url()

new Vue({
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default
            },
        }),
}).$mount(app);
