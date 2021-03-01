/**
 * Project Management Components...
 */
Vue.component('project-management', require('./projectManagement').default);
Vue.component('project-crud', require('./projectCrud').default);

// project association components: assigned users and assigned instruments
Vue.component('project-users', require('./common/projectUsers').default);
Vue.component('project-instruments', require('./common/projectInstruments').default);
