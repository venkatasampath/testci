/**
 * Auth Components...
 */
Vue.component('coralogin', require('./coralogin.vue').default);

// password related components such as reset password, change password
Vue.component('reset-password', require('./resetPassword').default);
Vue.component('change-password', require('./changePassword').default);
