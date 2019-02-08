Nova.booting((Vue, router, store) => {
    Vue.component('detail-conditional', require('./components/DetailField'))
    Vue.component('form-conditional', require('./components/FormField'))
})
