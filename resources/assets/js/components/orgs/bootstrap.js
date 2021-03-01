/**
 * Org Components...
 */

// Org Profile Components
Vue.component('org-profile-main', require('./profile/orgProfileMain').default);
Vue.component('org-profile-about', require('./profile/orgAbout').default);
Vue.component('org-profile-general', require('./profile/orgGeneral').default);
Vue.component('org-profile-uom', require('./profile/orgUom').default);
Vue.component('org-profile-apikeys', require('./profile/orgApiKeys').default);

// Org Management Components
Vue.component('org-management', require('./orgManagement').default);
Vue.component('org-crud', require('./orgCrud').default);
