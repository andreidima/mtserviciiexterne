/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('vue2-datepicker', require('./components/DatePicker.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


if (document.querySelector('#app')) {
    const app = new Vue({
        el: '#app',
    });
}

if (document.querySelector('#salariatiIndex')) {
    const app = new Vue({
        el: '#salariatiIndex',
        data:{
            modificari_globale: ((typeof modificariGlobale !== 'undefined') ? ((modificariGlobale == "true") ? true : false) : false),

            salariati: salariati,
            salariati_selectati: salariatiSelectati
        },
        methods: {
            select: function (event) {
                var salariati_selectati = this.salariati_selectati;

                if (event.target.checked) {
                    this.salariati.forEach(function (salariat) {
                        if (!salariati_selectati.includes(salariat.id)) {
                            salariati_selectati.push(salariat.id);
                        }
                    });
                } else {
                    this.salariati.forEach(function (salariat) {
                        for (var i = salariati_selectati.length - 1; i >= 0; i--) {
                            if (salariati_selectati[i] == salariat.id) {
                                salariati_selectati.splice(i, 1);
                            }
                        }
                    });
                }

                this.salariati_selectati = salariati_selectati;
            }

        },
    });
}
