import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from "pinia";
import Highcharts from "highcharts";
import StockModule from "highcharts/modules/stock";
import HighchartsMore from 'highcharts/highcharts-more';
import HeikinAshiModule from 'highcharts/modules/heikinashi';
import HighchartsVue from "highcharts-vue";
import * as bootstrap from 'bootstrap';

StockModule(Highcharts);
HighchartsMore(Highcharts);
HeikinAshiModule(Highcharts);

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', {eager: true})
        return pages[`./Pages/${name}.vue`]
    },
    setup({el, App, props, plugin}) {
        createApp({render: () => h(App, props)})
            .use(plugin)
            .use(createPinia())
            .use(HighchartsVue)
            .mount(el)
    },
    progress: {
        color: 'red',
        showSpinner: true
    }
})
