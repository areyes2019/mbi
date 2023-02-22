/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import $ from 'jquery';
window.$ = window.jQuery = $
require('./bootstrap');
window.Vue = require('vue').default;

import Toaster from 'v-toaster'
 
// You need a specific loader for CSS files like https://github.com/webpack/css-loader
import 'v-toaster/dist/v-toaster.css'
 
// optional set default imeout, the default is 10000 (10 seconds).
Vue.use(Toaster, {timeout: 5000})
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('crud-component', require('./components/CrudComponent.vue').default);

Vue.component('store-component', require('./components/StoreComponent.vue').default);
Vue.component('shop-component', require('./components/ShopComponent.vue').default);
Vue.component('item-component', require('./components/ItemComponent.vue').default);
Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('table-component', require('./components/TableComponent.vue').default);
Vue.component('menu-component', require('./components/MenuComponent.vue').default);
Vue.component('contact-component', require('./components/ContactComponent.vue').default);
Vue.component('contacts-component', require('./components/ContactsComponent.vue').default);
Vue.component('woocommerce-component', require('./components/WoocommerceComponent.vue').default);
Vue.component('woolist-component', require('./components/WooArticlesListComponent.vue').default);
Vue.component('wooarticle-component', require('./components/WooArticleComponent.vue').default);
Vue.component('articles-component', require('./components/ArticlesComponent.vue').default);
Vue.component('cataloges-component', require('./components/CatalogesComponent.vue').default);
Vue.component('categories-component', require('./components/CategoriesComponent.vue').default);
Vue.component('quotations-component', require('./components/QuotationsComponent.vue').default);
Vue.component('quotation-component', require('./components/QuotationComponent.vue').default);
Vue.component('orders-component', require('./components/OrdersComponent.vue').default);
Vue.component('order-component', require('./components/OrderComponent.vue').default);
Vue.component('stock-component', require('./components/StockComponent.vue').default);
Vue.component('expenses-component', require('./components/ExpensesComponent.vue').default);
Vue.component('pos-component', require('./components/PosComponent.vue').default);
Vue.component('sale-component', require('./components/SaleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
