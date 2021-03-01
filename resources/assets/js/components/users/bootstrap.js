/**
 * User Components...
 */

// About Components
Vue.component('about-main', require('./about/aboutMain.vue').default);
Vue.component('about', require('./about/about.vue').default);
Vue.component('about-browser', require('./about/aboutBrowser.vue').default);

// User Profile Components
Vue.component('user-profile-main', require('./profile/userProfileMain.vue').default);
Vue.component('user-profile', require('./profile/userProfile.vue').default);
Vue.component('user-profile-general', require('./profile/userProfileGeneral.vue').default);
Vue.component('user-profile-project', require('./profile/userProfileProject.vue').default);
Vue.component('user-profile-notification', require('./profile/userProfileNotification.vue').default);
Vue.component('user-profile-lastlogin', require('./profile/userLastLogin.vue').default);
Vue.component('user-profile-activity-specimen', require('./profile/userProfileActivitySpecimen.vue').default);
Vue.component('user-profile-activity-dna', require('./profile/userProfileActivityDNA.vue').default);
Vue.component('localization', require('./profile/localization.vue').default);

// Common Components
Vue.component('user-instruments', require('./common/userInstruments').default);
Vue.component('user-projects', require('./common/userProjects').default);

// Management Components
Vue.component('user-management', require('./userManagement').default);
Vue.component('user-crud', require('./userCrud').default);
