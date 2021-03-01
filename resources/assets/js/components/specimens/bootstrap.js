/**
 * Specimen Components...
 */
// Common Components
Vue.component('an', require('./common/an').default);
Vue.component('p1', require('./common/p1').default);
Vue.component('p2', require('./common/p2').default);
Vue.component('dn', require('./common/dn').default);
Vue.component('bone', require('./common/bone').default);
Vue.component('side', require('./common/side').default);
Vue.component('bone-side', require('./common/bone_side').default);
Vue.component('completeness', require('./common/completeness').default);

// Specimen Create Components
Vue.component('specimen-create', require('./specimen-create').default);
Vue.component('specimen-create-by-bone-group', require('./specimen-create-by-bone-group').default);

// add the specimen create by bone group
// add the specimen create by homonculus

// Specimen Highlights Components
Vue.component('specimen-highlights', require('./specimenHighlights').default);

// Specimen Association Components
Vue.component('measurements', require('./measurements').default);
Vue.component('zones', require('./zones').default);

// Biological Profile Components
Vue.component('biological-profile-methods', require('./biologicalprofile/bioMethods').default);

// Pathology Components
Vue.component('pat', require('./pathology/pat').default);
Vue.component('pat-crud', require('./pathology/patCrud').default);

// Review Components
Vue.component('review-main', require('./review/reviewMain.vue').default);
Vue.component('review-general', require('./review/reviewGeneral.vue').default);
Vue.component('review-taphonomy', require('./review/reviewTaphonomy').default);
Vue.component('review-measurements', require('./review/reviewMeasurements').default);
Vue.component('review-zones', require('./review/reviewZones').default);
Vue.component('review-association', require('./review/reviewAssociation').default);
Vue.component('association', require('./../specimens/Association/Association').default);
Vue.component('review-pathology', require('./../specimens/review/reviewPathology').default);
Vue.component('review-anomaly', require('./../specimens/review/reviewAnomaly').default);
Vue.component('review-trauma', require('./../specimens/review/reviewTrauma').default);
Vue.component('review-methods', require('./../specimens/review/reviewMethods').default);

// Specimen Isotope batch Components
Vue.component('isotopebatch', require('./isotope/batch/IsotopeBatch').default);
Vue.component('isotopeList', require('./isotope/batch/IsotopeList').default);
Vue.component('isotopebatchcreate', require('./isotope/batch/isotopeBatchCreate.vue').default);
Vue.component('associateisotope', require('./isotope/batch/associateIsotopes.vue').default);

// Specimen Dna Components
Vue.component('dna-list', require('../dnas/dnaList').default);
Vue.component('labs', require('../dnas/labs').default);


