import Vuex from 'vuex'
import Vue from 'vue'

import search from "./modules/search";
import org from "./modules/org";
import user from "./modules/user";
import project from "./modules/project";
import axios from "axios";
import {objToValueTextArray} from "../utilities/objToArray";

Vue.use(Vuex)

// Vuex State management related
const debug = process.env.NODE_ENV !== 'production';

export default new Vuex.Store({
    modules: {
        search,
        project,
        user,
        org,
        // dashboard
    },

    state: { // = data
        auth: false,
        loading: false,
        baseURL: "",
        bones: [],
        bone_groups: [],
        profiles: [],
        labs: [],
        dna_analysis_types: [],
        measurements: [],
        zones: [],
        taphonomies: [],
        methods: [],
        methodfeatures: [],
        pathologies: [],
        tramuas: [],
        anomalies: [],
        project_statuses: [],
        // country, language and timezone codes
        country: [],
        language: [],
        timezone: [],
        // Roles and Permissions
        roles: [],
        themeDark: false,
        appLeftDrawer: {
            model: null,
            type: 'temporary',
            clipped: true,
            floating: false,
            mini: false,
        },
        apprRightDrawer: {
            model: null,
            clipped: true,
        },
        appFooter: {
            inset: false,
        },
        helpUrl: { type: String, default: "https://cora-docs.readthedocs.io" },
    },

    getters: { // = computed properties
        theOrg(state, getters) {
            return state.org.currentOrg;
        },
        theUser(state, getters) {
            return state.user.currentUser;
        },
        theProject(state, getters) {
            return state.project.currentProject;
        },
        theProjectId(state, getters) {
            return state.project.currentProjectId;
        },
        theUserProjects(state, getters) {
            return state.project.projects;
        },
        csrfToken(state, getters) {
            let token = document.head.querySelector('meta[name="csrf-token"]');
            return token.content
        },
        bearerToken(state, getters) {
            return "Bearer " + getters.theUser.api_token;
        },
        isAdmin(state, getters) {
            return getters.theUser.role.name === 'admin';
        },
        isOrgAdmin(state, getters) {
            return getters.theUser.role.name === 'orgadmin';
        },
        isAdminOrOrgAdmin(state, getters) {
            return (getters.theUser.role.name === 'admin' || getters.theUser.role.name === 'orgadmin');
        },
        isProjectManager: (state, getters) => (project_id) => {
            let project = getters.getProjectById(project);
            if (project && project !== undefined) {
                return (getters.theUser.id === project.manager_id);
            }
            return false;
        },
        getProjectsIdNameArray (state, getters) {
            let arr = [];
            for (let i = 0, len = state.project.projects.length; i < len; i++) {
                arr.push({
                    projectsValue: state.project.projects[i].id,
                    projectsText: state.project.projects[i].name
                });
            }
            return arr;
        },
        sizeofLocalStorage: function () {
            let total = 0.00;
            for(let x in localStorage) {
                let amount = (localStorage[x].length * 2) / 1024;
                if (x === 'length' || x === 'key' || x === 'getItem' || x === 'removeItem' || x === 'clear') {
                    // Don't do anything.
                } else {
                    total += amount;
                    console.log( x + " = " + amount.toFixed(2) + " KB");
                }
            }
            console.log( "Total: " + total.toFixed(2) + " KB");
            return "Total: " + total.toFixed(2) + " KB";
        },
        sizeofSessionStorage: function () {
            let total = 0.00;
            for(let x in sessionStorage) {
                let amount = (sessionStorage[x].length * 2) / 1024;
                if (x === 'length' || x === 'key' || x === 'getItem' || x === 'removeItem' || x === 'clear') {
                    // Don't do anything.
                } else {
                    total += amount;
                    console.log( x + " = " + amount.toFixed(2) + " KB");
                }
            }
            console.log( "Total: " + total.toFixed(2) + " KB");
            return "Total: " + total.toFixed(2) + " KB";
        },
        org_and_role(state, getters) {
            return getters.theOrg.acronym + ": " + getters.theUser.role.display_name;
        },
        themeDark(state, theme) {
            if (localStorage.getItem('theme-dark')) {
                return JSON.parse(localStorage.getItem("theme-dark"));
            }
            return state.themeDark;
        },
        appLeftDrawer(state, drawer) {
            if (localStorage.getItem('app-left-drawer')) {
                return JSON.parse(localStorage.getItem("app-left-drawer"));
            }
            return state.appLeftDrawer;
        },
        appRightDrawer(state, drawer) {
            if (localStorage.getItem('app-right-drawer')) {
                return JSON.parse(localStorage.getItem("app-right-drawer"));
            }
            return state.apprRightDrawer;
        },
        appFooter(state, footer) {
            if (localStorage.getItem('app-footer')) {
                return JSON.parse(localStorage.getItem("app-footer"));
            }
            return state.appFooter;
        },
        getLabs: (state, getters) => (type) => {
            if (state.labs.length === 0) {
                if (localStorage.getItem("labs")) {
                    let labs = JSON.parse(localStorage.getItem("labs"));
                    return labs.filter( el => { return el.type === type});
                }
            }
            return state.labs.filter( el => { return el.type === type});
        },
        getDnaAnalysisTypes: (state, getters) => (type) => {
            if (state.dna_analysis_types.length === 0) {
                if (localStorage.getItem("dna-analysis-types")) {
                    let dna_analysis_types = JSON.parse(localStorage.getItem("dna-analysis-types"));
                    return dna_analysis_types.filter( el => { return el.type === type});
                }
            }
            return state.dna_analysis_types.filter( el => { return el.type === type});
        },
        getBones (state, getters) {
            if (localStorage.getItem('bones')) {
                return JSON.parse(localStorage.getItem("bones"));
            }
            return state.bones;
        },
        getBone: (state, getters) => (id) => {
            if (state.bones.length === 0) {
                if (localStorage.getItem("bones")) {
                    let bones = JSON.parse(localStorage.getItem("bones"));
                    return bones.find(el => { return el.id === id});
                }
            }
            return state.bones.find(el => { return el.id === id});
        },
        getBoneGroups (state, getters) {
            if (localStorage.getItem('bone-groups')) {
                return JSON.parse(localStorage.getItem("bone-groups"));
            }
            return state.bone_groups;
        },
        getBoneGroupsList (state, getters) {
            if (localStorage.getItem('bone-groups')) {
                let groups = JSON.parse(localStorage.getItem("bone-groups"));
                const unique = [...new Set(groups.map(item => item.group_name))];
                return unique;
            }
            return [...new Set(state.bone_groups.map(item => item.group_name))];
        },
        getBonesInGroup: (state, getters) => (group) => {
            if (state.bone_groups.length === 0) {
                if (localStorage.getItem("bone-groups")) {
                    let groups = JSON.parse(localStorage.getItem("bone-groups"));
                    return groups.filter( el => { return el.group_name === group});
                }
            }
            return state.bone_groups.filter( el => { return el.group_name === group});
        },
        getMeasurements (state, getters) {
            if (localStorage.getItem('measurements')) {
                return JSON.parse(localStorage.getItem("measurements"));
            }
            return state.measurements;
        },
        getMeasurementsByBone: (state, getters) => (sb_id) => {
            if (state.measurements.length === 0) {
                if (localStorage.getItem("measurements")) {
                    let measurements = JSON.parse(localStorage.getItem("measurements"));
                    return measurements.filter( el => { return el.sb_id === sb_id});
                }
            }
            return state.measurements.filter( el => { return el.sb_id === sb_id});
        },
        getMeasurementById: (state, getters) => (id) => {
            if (state.measurements.length === 0) {
                if (localStorage.getItem("measurements")) {
                    let measurements = JSON.parse(localStorage.getItem("measurements"));
                    return measurements.find( el => { return el.id === id});
                }
            }
            return state.measurements.find( el => { return el.id === id});
        },
        getZones (state, getters) {
            if (localStorage.getItem('zones')) {
                return JSON.parse(localStorage.getItem("zones"));
            }
            return state.zones;
        },
        getZonesByBone: (state, getters) => (sb_id) => {
            if (state.zones.length === 0) {
                if (localStorage.getItem("zones")) {
                    let zones = JSON.parse(localStorage.getItem("zones"));
                    return zones.filter( el => { return el.sb_id === sb_id});
                }
            }
            return state.zones.filter( el => { return el.sb_id === sb_id});
        },
        getZoneById: (state, getters) => (id) => {
            if (state.zones.length === 0) {
                if (localStorage.getItem("zones")) {
                    let zones = JSON.parse(localStorage.getItem("zones"));
                    return zones.find( el => { return el.id === id});
                }
            }
            return state.zones.find( el => { return el.id === id});
        },
        getTaphonomies(state, getter) {
            if (localStorage.getItem('taphonomies')) {
                return JSON.parse(localStorage.getItem("taphonomies"));
            }
            return state.taphonomies;
        },
        getMethodById: (state, getters) => (id) => {
            if (state.methods.length === 0) {
                if (localStorage.getItem("methods")) {
                    let methods = JSON.parse(localStorage.getItem("methods"));
                    return methods.filter( el => { return el.id === id});
                }
            }
            return state.methods.filter( el => { return el.id === id});
        },
        getMethodsByBone: (state, getters) => (sb_id) => {
            if (state.methods.length === 0) {
                if (localStorage.getItem("methods")) {
                    let methods = JSON.parse(localStorage.getItem("methods"));
                    return methods.filter( el => { return el.sb_id === sb_id});
                }
            }
            return state.methods.filter( el => { return el.sb_id === sb_id});
        },
        getMethodsByBoneAndType: (state, getters, rootState) => (sb_id, type) => {
            if (state.methods.length === 0) {
                if (localStorage.getItem("methods")) {
                    let methods = JSON.parse(localStorage.getItem("methods"));
                    return methods.filter( el => { return (el.sb_id === sb_id && el.type === type)});
                }
            }
            return state.methods.filter( el => { return (el.sb_id === sb_id && el.type === type)});
        },
        getMethodFeaturesByMethodId: (state, getters) => (id) => {
            if (state.methods.length === 0) {
                if (localStorage.getItem("methods")) {
                    let methods = JSON.parse(localStorage.getItem("methods"));
                    let method = methods.filter( el => { return el.id === id});
                    return method[0].features;
                }
            }
            let method = state.methods.filter( el => { return el.id === id});
            return method[0].features;
        },
        getMethodFeatures: (state, getters, rootState) => (method_id) => {
            if (state.methodfeatures.length === 0) {
                if (localStorage.getItem("methodfeatures")) {
                    let methodfeatures = JSON.parse(localStorage.getItem("methodfeatures"));
                    return methodfeatures.filter( el => { return el.method_id === method_id});
                }
            }
            return state.methodfeatures.filter( el => { return el.method_id === method_id});
        },
        getPathologies(state, getters) {
            if (localStorage.getItem('pathologies')) {
                return JSON.parse(localStorage.getItem("pathologies"));
            }
            return state.pathologies;
        },
        getTraumas(state, getters) {
            if (localStorage.getItem('tramuas')) {
                return JSON.parse(localStorage.getItem("tramuas"));
            }
            return state.tramuas;
        },
        getAnomalies (state, getters) {
            if (localStorage.getItem('anomalies')) {
                return JSON.parse(localStorage.getItem("anomalies"));
            }
            return state.anomalies;
        },
        getAnomaliesByBone: (state, getters, rootState) => (sb_id) => {
            if (state.anomalies.length === 0) {
                if (localStorage.getItem("anomalies")) {
                    let anomalies = JSON.parse(localStorage.getItem("anomalies"));
                    return anomalies.filter(el => { return el.sb_id === sb_id});
                }
            }
            return state.anomalies.filter(el => { return el.sb_id === sb_id});
        },
        getProjectStatuses (state, getters) {
            if (localStorage.getItem('project-statuses')) {
                return JSON.parse(localStorage.getItem("project-statuses"));
            }
            return state.project_statuses;
        },
        getRoles (state, getters) {
            if (localStorage.getItem('roles')) {
                return JSON.parse(localStorage.getItem("roles"));
            }
            return state.roles;
        },
        getCountryCodes (state, getters) {
            if (localStorage.getItem('localization-codes')) {
                let codes = JSON.parse(localStorage.getItem("localization-codes"));
                return objToValueTextArray(codes.country);
            }
            return state.country;
        },
        getLanguageCodes (state, getters) {
            if (localStorage.getItem('localization-codes')) {
                let codes = JSON.parse(localStorage.getItem("localization-codes"));
                return objToValueTextArray(codes.language);
            }
            return state.country;
        },
        getTimezoneCodes (state, getters) {
            if (localStorage.getItem('localization-codes')) {
                let codes = JSON.parse(localStorage.getItem("localization-codes"));
                return objToValueTextArray(codes.timezone);
            }
            return state.timezone;
        },
        getHelpUrl(state, getters) {
            return state.helpUrl;
        },
        getProfileByName: (state, getters) => (name) => {
            let profile = null;
            // First try and get from state.
            profile = state.profiles.find(profile => { return profile.name === name});
            if (!profile || (typeof profile === 'undefined')) {
                // Next try and get from local cache.
                let key = "profiles";
                if (localStorage.getItem(key)) {
                    let cached_profiles = JSON.parse(localStorage.getItem(key));
                    profile = cached_profiles.find(profile => { return profile.name === name});
                    return profile;
                }
            }
            return profile;
        },
    },

    mutations: {
        setTheOrg(state, org) {
            state.org.currentOrg = org;
            state.org.currentOrgId = (org) ? org.id : 0;
        },
        setTheUser(state, user) {
            state.user.currentUser = user;
            state.user.currentUserId = (user) ? user.id : 0;
            state.user.role = (user) ? user.role : null;
            state.auth = !!(user);
        },
        setTheProject(state, project) {
            state.project.currentProject = project;
            state.project.currentProjectId = (project) ? project.id : 0;
        },
        setProjects(state, projects) {
            state.project.projects = projects;
        },
        setBaseUrl(state, url) {
            state.baseURL = url;
        },
        setBones(state, bones) {
            state.bones = bones;
        },
        setBoneGroups(state, items) {
            state.bone_groups = items;
        },
        setProfiles(state, profiles) {
            state.profiles = profiles;
        },
        setLabs(state, items) {
            state.labs = items;
        },
        setDnaAnalysisTypes(state, items) {
            state.dna_analysis_types = items;
        },
        setMeasurements(state, items) {
            state.measurements = items;
        },
        setZones(state, items) {
            state.zones = items;
        },
        setTaphonomies(state, items) {
            state.taphonomies = items;
        },
        setMethods(state, items) {
            state.methods = items;
        },
        setMethodFeatures(state, items) {
            state.methodfeatures = items;
        },
        setPathologies(state, items) {
            state.pathologies = items;
        },
        setAnomalies(state, items) {
            state.anomalies = items;
        },
        setTramuas(state, items) {
            state.tramuas = items;
        },
        setProjectStatuses(state, items) {
            state.project_statuses = items;
        },
        setRoles(state, items) {
            state.roles = items;
        },
        setLocalizationCodes(state, items) {
            state.country = objToValueTextArray(items.country);
            state.language = objToValueTextArray(items.language);
            state.timezone = objToValueTextArray(items.timezone);
        },
        setThemeDark(state, theme) {
            state.themeDark = theme;
            localStorage.setItem("theme-dark", state.themeDark);
        },
        setLeftDrawer(state, drawer) {
            state.appLeftDrawer = drawer;
            localStorage.setItem("app-left-drawer", state.appLeftDrawer);
        },
        setRightDrawer(state, drawer) {
            state.apprRightDrawer = drawer;
            localStorage.setItem("app-right-drawer", state.apprRightDrawer);
        },
        setFooter(state, footer) {
            state.appFooter = footer;
            localStorage.setItem("app-footer", state.appFooter);
        },
    },

    // typically make ajax calls and then
    // call appropriate mutations to change state.
    actions: {
        // Once user has logged in set the initial state for
        // org, user, project and other state variables
        userLogin(context, payload) {
            return new Promise((resolve, reject) => {
                context.commit('setTheUser', payload.user);
                context.commit('setTheOrg', payload.org);
                context.commit('setTheProject', payload.project);
                context.commit('setProjects', payload.projects);
                context.commit('setBaseUrl', payload.baseURL);
                if (localStorage.getItem('theme-dark')) {
                    context.commit('setThemeDark', JSON.parse(localStorage.getItem('theme-dark')));
                }
                context.dispatch('fetchRolePermissions', {'role': payload.user.role.name, 'list': true, 'force': true});

                context.dispatch('initializeApp');
                context.dispatch('initializeOrg');
                context.dispatch('initializeUser');
                context.dispatch('initializeProject');
                resolve();
            })
        },
        userLogout(context) {
            return new Promise((resolve, reject) => {
                context.commit('setTheOrg', null);
                context.commit('setTheUser', null);
                context.commit('setTheProject', null);
                context.commit('setProjects', null);
                resolve();
            })
        },
        initializeApp(context) {
            console.log("initializeApp started");

            let app_version = "1.0.0" // Need to address this hardcoding. maybe get app version via API
            context.dispatch('initLocalStorage', app_version).then(() => this.loading = false);

            let app_payload = { 'type': 'bones', 'list': false };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'bone-groups', 'list': false };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'profiles', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'labs', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'dna-analysis-types', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'project-statuses', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'roles', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'localization-codes', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'measurements', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'zones', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'taphonomies', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'methods', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'pathologies', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'anomalies', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);
            app_payload = { 'type': 'traumas', 'list': true };
            context.dispatch('fetchAppList', app_payload).then(() => this.loading = false);

            console.log("initializeApp complete");
        },
        initializeOrg(context) {
            console.log("initializeOrg started");
            // Get the logged in user's org related/associated data
            let org_payload = { 'type': 'profiles', 'force': true };
            context.dispatch('fetchOrgList', org_payload);
            org_payload = { 'type': 'users', 'force': true };
            context.dispatch('fetchOrgList', org_payload);
            org_payload = { 'type': 'projects', 'list': true, 'force': true };
            context.dispatch('fetchOrgList', org_payload);
            org_payload = { 'type': 'instruments', 'list': true, 'force': true };
            context.dispatch('fetchOrgList', org_payload);
            console.log("initializeOrg complete");
        },
        initializeUser(context) {
            console.log("initializeUser started");
            // Get the logged in user's related/associated data
            let user_payload = { 'type': 'profiles', 'force': true };
            context.dispatch('fetchUserList', user_payload);
            user_payload = { 'type': 'projects', 'list': true, 'force': true };
            context.dispatch('fetchUserList', user_payload);
            user_payload = { 'type': 'instruments', 'list': true, 'force': true };
            context.dispatch('fetchUserList', user_payload);
            console.log("initializeUser complete");
        },
        initializeProject(context) {
            console.log("initializeProject started");
            let project_payload = { 'type': 'accessions', 'list': true, 'force': true };
            context.dispatch('fetchProjectList', project_payload);
            project_payload = { 'type': 'provenance1', 'list': true, 'force': true };
            context.dispatch('fetchProjectList', project_payload);
            project_payload = { 'type': 'provenance2', 'list': true, 'force': true };
            context.dispatch('fetchProjectList', project_payload);
            project_payload = { 'type': 'individual-numbers', 'list': true, 'force': true };
            context.dispatch('fetchProjectList', project_payload);
            project_payload = { 'type': 'tags', 'list': true, 'force': true };
            context.dispatch('fetchProjectList', project_payload);
            project_payload = { 'type': 'anp1p2', 'list': true, 'force': true };
            context.dispatch('fetchProjectList', project_payload);
            project_payload = { 'type': 'users', 'list': true, 'force': true };
            context.dispatch('fetchProjectList', project_payload);
            console.log("initializeProject complete");
        },
        initLocalStorage(context, app_version) {
            return new Promise((resolve, reject) => {
                let currentdate = new Date();

                // First initialize local storage
                if(typeof localStorage.app_version === 'undefined' || localStorage.app_version === null) {
                    localStorage.setItem('app_version', app_version);
                    localStorage.setItem('app_storage_start_date', currentdate);
                }
                if(localStorage.app_version !== app_version) {
                    localStorage.clear();
                    localStorage.setItem('app_version', app_version);
                    localStorage.setItem('app_storage_start_date', currentdate);
                } else {
                    console.log('localStorage: current app version '+localStorage.app_version);
                }

                // Next initialize session storage
                if(typeof sessionStorage.app_version === 'undefined' || sessionStorage.app_version === null) {
                    sessionStorage.setItem('app_version', app_version);
                }
                if(sessionStorage.app_version !== app_version) {
                    sessionStorage.clear();
                    sessionStorage.setItem('app_version', app_version);
                } else {
                    console.log('localStorage: current app version '+sessionStorage.app_version);
                }
                resolve();
            })
        },
        fetchUserProjects(context, projects) {
            return new Promise((resolve, reject) => {
                context.commit('setProjects', projects);
                resolve();
            })
        },
        fetchCurrentProject(context, project) {
            return new Promise((resolve, reject) => {
                context.commit('setTheProject', project);
                resolve();
            })
        },
        fetchAppList: function(context, payload) {
            return new Promise((resolve, reject) => {
                let key = payload.type;
                let url = '/api/base-data/' + payload.type + ((payload.list === true) ? '?list=true' : '');

                console.log('fetchAppList payload - ' + JSON.stringify(payload));
                if (localStorage.getItem(key) && (!payload.force)) {
                    try {
                        console.log('getting app list ' + payload.type + ' from localStorage.');
                        if (payload.type === 'bones') {
                            context.commit('setBones', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'bone-groups') {
                            context.commit('setBoneGroups', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'profiles') {
                            context.commit('setProfiles', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'labs') {
                            context.commit('setLabs', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'dna-analysis-types') {
                            context.commit('setDnaAnalysisTypes', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'measurements') {
                            context.commit('setMeasurements', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'zones') {
                            context.commit('setZones', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'taphonomies') {
                            context.commit('setTaphonomies', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'methods') {
                            context.commit('setMethods', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'methodfeatures') {
                            context.commit('setMethodFeatures', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'pathologies') {
                            context.commit('setPathologies', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'anomalies') {
                            context.commit('setAnomalies', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'traumas') {
                            context.commit('setTramuas', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'project-statuses') {
                            context.commit('setProjectStatuses', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'roles') {
                            context.commit('setRoles', JSON.parse(localStorage.getItem(key)));
                        } else if (payload.type === 'localization-codes') {
                            context.commit('setLocalizationCodes', JSON.parse(localStorage.getItem(key)));
                        }
                    } catch(e) {
                        localStorage.removeItem(key);
                    }
                } else { // Go fetch from server and store in browser cache
                    console.log('url - ' + url);
                    axios
                        .request({
                            url: url,
                            method: 'GET',
                            headers:{
                                'Content-Type' : 'application/json',
                                'Authorization' : context.getters.bearerToken,
                            }
                        })
                        .then(response=>{
                            if (payload.type === 'bones') {
                                context.commit('setBones', response.data.data);
                            } else if (payload.type === 'bone-groups') {
                                context.commit('setBoneGroups', response.data.data);
                            } else if (payload.type === 'profiles') {
                                context.commit('setProfiles', response.data.data);
                            } else if (payload.type === 'labs') {
                                context.commit('setLabs', response.data.data);
                            } else if (payload.type === 'dna-analysis-types') {
                                context.commit('setDnaAnalysisTypes', response.data.data);
                            } else if (payload.type === 'measurements') {
                                context.commit('setMeasurements', response.data.data);
                            } else if (payload.type === 'zones') {
                                context.commit('setZones', response.data.data);
                            } else if (payload.type === 'taphonomies') {
                                context.commit('setTaphonomies', response.data.data);
                            } else if (payload.type === 'methods') {
                                context.commit('setMethods', response.data.data);
                            } else if (payload.type === 'methodfeatures') {
                                context.commit('setMethodFeatures', response.data.data);
                            } else if (payload.type === 'pathologies') {
                                context.commit('setPathologies', response.data.data);
                            } else if (payload.type === 'anomalies') {
                                context.commit('setAnomalies', response.data.data);
                            } else if (payload.type === 'traumas') {
                                context.commit('setTramuas', response.data.data);
                            } else if (payload.type === 'project-statuses') {
                                context.commit('setProjectStatuses', response.data.data);
                            } else if (payload.type === 'roles') {
                                context.commit('setRoles', response.data.data);
                            } else if (payload.type === 'localization-codes') {
                                context.commit('setLocalizationCodes', response.data.data);
                            }
                            localStorage.setItem(key, JSON.stringify(response.data.data));
                            console.log('making API call and setting ' + payload.type + ' data: ' + response.data.data);
                            console.log('making API call and setting ' + payload.type + ' in localStorage.');
                            resolve();
                        })
                        .catch(error => {
                            console.log(error);
                        })
                }
                context.getters.sizeofLocalStorage;
            })
        },
        fetchRolePermissions: function(context, payload) {
            return new Promise((resolve, reject) => {
                let key = 'role-' + payload.role + '-permissions';
                let url = '/api/base-data/role-permissions?role=' + payload.role + ((payload.list === true) ? '&list=true' : '');

                console.log('fetchRolePermissions payload - ' + JSON.stringify(payload));
                if (localStorage.getItem(key) && (!payload.force)) {
                    try {
                        console.log('getting ' + key + ' from localStorage.');
                        context.commit('setUserPermissions', JSON.parse(localStorage.getItem(key)));
                    } catch(e) {
                        localStorage.removeItem(key);
                    }
                } else { // Go fetch from server and store in browser cache
                    console.log('url - ' + url);
                    axios
                        .request({
                            url: url,
                            method: 'GET',
                            headers:{
                                'Content-Type' : 'application/json',
                                'Authorization' : context.getters.bearerToken,
                            }
                        })
                        .then(response=>{
                            context.commit('setUserPermissions', response.data.data);
                            localStorage.setItem(key, JSON.stringify(response.data.data));
                            console.log('making API call and setting ' + payload.type + ' in localStorage.');
                            context.getters.sizeofLocalStorage;
                            resolve();
                        })
                        .catch(error => {
                            console.log(error);
                        })
                }
            })
        },
    },

    strict: debug,
    // plugins: debug ? [createLogger()] : []
})