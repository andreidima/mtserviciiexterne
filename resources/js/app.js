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

Vue.directive('click-outside', {
    bind: function (el, binding, vnode) {
        el.clickOutsideEvent = function (event) {
            // here I check that click was outside the el and his children
            if (!(el == event.target || el.contains(event.target))) {
                // and if it did, call method provided in attribute value
                vnode.context[binding.expression](event);
            }
        };
        document.body.addEventListener('click', el.clickOutsideEvent)
    },
    unbind: function (el) {
        document.body.removeEventListener('click', el.clickOutsideEvent)
    },
});


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
            salariati_selectati: salariatiSelectati,

            // Campuri pentru afisarea confirmarii cand se face salvarea cu axios
            axiosActualizatSalariatId: '',
            axiosActualizatCamp: '',
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
            },
            axiosActualizeazaSalariat(salariatId, camp, valoare) {
                // console.log('yea');
                // console.log(salariatId, camp, valoare);

                axios
                    .post('/ssm/salariati/axios-modificare-salariati-direct-din-index',
                        {
                            salariatId: salariatId,
                            camp: camp,
                            valoare: valoare
                        },
                        {
                            params: {
                                request: 'actualizareSuma',
                            }
                        })
                    .then(function (response) {
                        app.axiosActualizatSalariatId = response.data.salariatId;
                        app.axiosActualizatCamp = response.data.camp;
                        // console.log(app.axiosActualizatSalariatId, app.axiosActualizatCamp);
                    });
            },

        },
    });
}

if (document.querySelector('#firmeIndex')) {
    const app = new Vue({
        el: '#firmeIndex',
        data: {
            // Campuri pentru afisarea confirmarii cand se face salvarea cu axios
            axiosActualizatFirmaId: '',
            axiosActualizatCamp: '',
        },
        methods: {
            axiosActualizeazaFirma(firmaId, camp, valoare) {
                // console.log('yea');
                axios
                    .post('/ssm/firme/axios-modificare-firme-direct-din-index',
                        {
                            firmaId: firmaId,
                            camp: camp,
                            valoare: valoare
                        },
                        {
                            params: {
                                // request: 'actualizareSuma',
                            }
                        })
                    .then(function (response) {
                        app.axiosActualizatFirmaId = response.data.firmaId;
                        app.axiosActualizatCamp = response.data.camp;
                        // console.log(app.axiosActualizatFirmaId, app.axiosActualizatCamp);
                    });
            },

        },
    });
}

if (document.querySelector('#medicinaMunciiIndexAxiosUpdate')) {
    const app = new Vue({
        el: '#medicinaMunciiIndexAxiosUpdate',
        data: {
            // Campuri pentru afisarea confirmarii cand se face salvarea cu axios
            axiosMesaj: '',
            axiosActualizatSalariatId: '',
            axiosActualizatCamp: '',
        },
        methods: {
            axiosActualizeazaSalariat(salariatId, camp, valoare) {
                // console.log('yea');
                // console.log(salariatId, camp, valoare);
                axios
                    .post('/firme-salariati/axios-modificare-salariati-direct-din-index',
                        {
                            salariatId: salariatId,
                            camp: camp,
                            valoare: valoare
                        },
                        {
                            params: {
                                // request: 'actualizareSuma',
                            }
                        })
                    .then(function (response) {
                        // console.log('response');
                        app.axiosMesaj = response.data.mesaj;
                        app.axiosActualizatSalariatId = response.data.salariatId;
                        app.axiosActualizatCamp = response.data.camp;
                        // console.log(app.axiosActualizatSalariatId, app.axiosActualizatCamp);
                    });
            },

        },
    });
}

if (document.querySelector('#formularObservatii')) {
    const app = new Vue({
        el: '#formularObservatii',
        data: {
            firmaId: firmaIdVechi,
            firmaNume: '',
            firme: firme,
            firmeListaAutocomplete: [],

            buttonSubmitFormApasat: false,
        },
        created: function () {
            if (this.firmaId) {
                for (var i = 0; i < this.firme.length; i++) {
                    if (this.firme[i].id == this.firmaId) {
                        this.firmaNume = this.firme[i].nume;
                    }
                }
            }
        },
        methods: {
            autocompleteFirme() {
                this.firmeListaAutocomplete = [];

                for (var i = 0; i < this.firme.length; i++) {
                    if (this.firme[i].nume && this.firme[i].nume.toLowerCase().includes(this.firmaNume.toLowerCase())) {
                        this.firmeListaAutocomplete.push(this.firme[i]);
                    }
                }
            },
            golesteFirmeListaAutocomplete() {
                this.firmeListaAutocomplete = [];
            },
        },
    });
}
