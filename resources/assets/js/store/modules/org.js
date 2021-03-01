// Org Module

import axios from "axios";

export default {
    state: {
        currentOrg: null,
        currentOrgId: 0,
        orgProfiles: [],
        users: [],
        projects: [],
        instruments: [],
    },

    getters: {
        getOrgProfileByName: (state, getters, rootState) => (name) => {
            let profile = null;
            // First try and get from state
            profile = state.orgProfiles.find(profile => { return profile.name === name});
            if (!profile || (typeof profile === 'undefined')) {
                let key = "org-"+state.currentOrgId+"-"+"profiles-list";
                // Next try and get from local cache.
                if (localStorage.getItem(key)) {
                    let cached_profiles = JSON.parse(localStorage.getItem(key));
                    profile = cached_profiles.find(profile => { return profile.name === name});
                    // below code should be fixed to call fucntion from rootstate profiles
                    if (!profile || (typeof profile === 'undefined')) {
                        profile = getters.getProfileByName(name);
                        return profile;
                    }
                    return profile;
                }
            }
            return profile;
        },
        getOrgProfileValueByName: (state, getters, rootState) => (name) => {
            let profile = null;
            // First try and get from state
            profile = state.orgProfiles.find(profile => { return profile.name === name});
            if (!profile || (typeof profile === 'undefined')) {
                let key = "org-"+state.currentOrgId+"-"+"profiles-list";
                // Next try and get from local cache.
                if (localStorage.getItem(key)) {
                    let cached_profiles = JSON.parse(localStorage.getItem(key));
                    profile = cached_profiles.find(profile => { return profile.name === name});
                    // below code should be fixed to call fucntion from rootstate profiles
                    if (!profile || (typeof profile === 'undefined')) {
                        profile = getters.getProfileByName(name);
                        return profile.default_value;
                    }
                    return profile.pivot.value;
                }
            }
            return profile.pivot.value;
        },
        getOrgUsers (state, getters) {
            let key = "org-"+state.currentOrgId+"-"+"users-list";
            if (localStorage.getItem('key')) {
                return JSON.parse(localStorage.getItem("key"));
            }
            return state.users;
        },
        getOrgUserById: (state, getters, rootState) => (id) => {
            if (state.users.length) {
                return state.users.find(user => { return user.id === id });
            } else {
                let key = "org-"+state.currentOrgId+"-"+"users-list";
                if (localStorage.getItem('key')) {
                    let users = JSON.parse(localStorage.getItem("key"));
                    return users.find(user => { return user.id === id});
                }
            }
            return null;
        },
        getOrgProjects (state, getters) {
            let key = "org-"+state.currentOrgId+"-"+"projects-list";
            if (localStorage.getItem('key')) {
                return JSON.parse(localStorage.getItem("key"));
            }
            return state.projects;
        },
        getOrgProjectById: (state, getters, rootState) => (id) => {
            if (state.projects.length) {
                return state.projects.find(project => { return project.id === id });
            } else {
                let key = "org-"+state.currentOrgId+"-"+"projects-list";
                if (localStorage.getItem('key')) {
                    let projects = JSON.parse(localStorage.getItem("key"));
                    return projects.find(project => { return project.id === id});
                }
            }
            return null;
        },
        getOrgInstruments (state, getters) {
            let key = "org-"+state.currentOrgId+"-"+"instruments-list";
            if (localStorage.getItem('key')) {
                return JSON.parse(localStorage.getItem("key"));
            }
            return state.instruments;
        },
    },

    mutations: {
        setOrgUsers(state, users) {
            state.users = users;
        },
        setCurrentOrg(state, org) {
            state.currentOrg = org;
            state.currentOrgId = (org) ? org.id : 0;
        },
        setOrgProfiles(state, items) {
            state.orgProfiles = items;
        },
        setOrgProjects(state, items) {
            state.instruments = items;
        },
        setOrgInstruments(state, items) {
            state.instruments = items;
        },
    },

    // typically make ajax calls and then
    // call appropriate mutations to change state.
    actions: {
        fetchOrgList: function(context, payload) {
            return new Promise((resolve, reject) => {
                let type = payload.type;
                let key = "org-"+context.state.currentOrgId+"-"+type+"-list";
                let url = '/api/orgs/'+ context.state.currentOrgId + '/' + type + ((payload.list === true) ? '?list=true' : '');

                console.log('fetchOrgList payload: ' + JSON.stringify(payload));
                if (localStorage.getItem(key) && (!payload.force)) {
                    try {
                        console.log('getting org ' + type + ' from localStorage.');
                        if (type === 'profiles') {
                            context.commit('setOrgProfiles', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'users') {
                            context.commit('setOrgUsers', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'projects') {
                            context.commit('setOrgProjects', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'instruments') {
                            context.commit('setOrgInstruments', JSON.parse(localStorage.getItem(key)));
                        }
                    } catch(e) {
                        localStorage.removeItem(key);
                    }
                } else { // Go fetch from server and store in browser cache
                    console.log("url: " + url);
                    axios
                        .request({ url: url, method: 'GET',
                            headers:{ 'Content-Type' : 'application/json', 'Authorization' : context.getters.bearerToken, },
                        })
                        .then(response=>{
                            if (type === 'profiles') {
                                context.commit('setOrgProfiles', response.data.data);
                            } else if (type === 'users') {
                                context.commit('setOrgUsers', response.data.data);
                            } else if (type === 'projects') {
                                context.commit('setOrgProjects', response.data.data);
                            } else if (type === 'instruments') {
                                context.commit('setOrgInstruments', response.data.data);
                            }
                            localStorage.setItem(key, JSON.stringify(response.data.data));
                            console.log('making API call and setting ' + type + ' in localStorage.');
                            resolve();
                        })
                        .catch(error => {
                            console.log(error);
                            error();
                        })
                }
                context.getters.sizeofLocalStorage;
            })
        },
        updateOrgProfile: function(context, payload) {
            return new Promise((resolve, reject) => {
                let url = '/api/orgs/'+ context.state.currentOrgId + '/profile?name=' + payload.name + "&value=" + payload.value;
                console.log('updateOrgProfile payload: ' + JSON.stringify(payload));
                console.log('url: ' + url);

                axios
                    .request({ url: url, method: 'PUT',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : context.getters.bearerToken, },
                    })
                    .then(response=>{
                        context.dispatch('fetchOrgList', { 'type': 'profiles', 'force': true });
                        console.log('Org Profile ' + payload.name + ' successfully updated.');
                        resolve();
                    })
                    .catch(error => {
                        console.log(error);
                        error();
                    })
            })
        },
    }
}