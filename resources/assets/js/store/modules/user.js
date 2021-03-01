// User User

import axios from "axios";

export default {
    state: {
        currentUser: null,
        currentUserId: 0,
        userProfiles: [],
        permissions: [],
        projects: [],
        instruments: [],
        role: null,
    },

    getters: {
        api_token(state, getters) {
            return state.currentUser.api_token;
        },
        can: (state, getters, rootState) => (name) => {
            let key = "role-"+state.currentUser.role.name+"-"+"permissions";
            // console.log("can - " + name + " in permissions[]: " + key);
            let permission = state.permissions.find(permission => { return permission.key === name});
            return !!permission;
        },
        getUserProfileByName: (state, getters, rootState) => (name) => {
            let profile = null;
            // First try and get from state
            profile = state.userProfiles.find(profile => { return profile.name === name});
            if (!profile || (typeof profile === 'undefined')) {
                let key = "user-"+state.currentUserId+"-"+"profiles-list";
                // Next try and get from local cache.
                if (localStorage.getItem(key)) {
                    let cached_profiles = JSON.parse(localStorage.getItem(key));
                    profile = cached_profiles.find(profile => { return profile.name === name});
                    if (!profile || (typeof profile === 'undefined')) {
                        profile = getters.getProfileByName(name);
                        return profile;
                    }
                    return profile;
                }
            }
            return profile;
        },
        getUserProfileValueByName: (state, getters, rootState) => (name) => {
            let profile = null;
            // First try and get from state
            profile = state.userProfiles.find(profile => { return profile.name === name});
            if (!profile || (typeof profile === 'undefined')) {
                let key = "user-"+state.currentUserId+"-"+"profiles-list";
                // Next try and get from local cache.
                if (localStorage.getItem(key)) {
                    let cached_profiles = JSON.parse(localStorage.getItem(key));
                    profile = cached_profiles.find(profile => { return profile.name === name});
                    if (!profile || (typeof profile === 'undefined')) {
                        profile = getters.getProfileByName(name);
                        return profile.default_value;
                    }
                    return profile.pivot.value;
                }
            }
            return profile.pivot.value;
        },
        getUserInstruments (state, getters) {
            let key = "user-"+state.currentUserId+"-"+"instruments-list";
            if (localStorage.getItem(key)) {
                return JSON.parse(localStorage.getItem(key));
            }
            return state.instruments;
        },
        getUserProjects (state, getters) {
            let key = "user-"+state.currentUserId+"-"+"projects-list";
            if (localStorage.getItem(key)) {
                return JSON.parse(localStorage.getItem(key));
            }
            return state.projects;
        },
    },

    mutations: {
        setCurrentUser(state, user) {
            state.currentUser = user;
            state.currentUserId = (user) ? user.id : 0;
            state.role = (user) ? user.role : null;
        },
        setUserProfiles(state, items) {
            state.userProfiles = items;
        },
        setUserPermissions(state, items) {
            state.permissions = items;
        },
        setUserInstruments(state, items) {
            state.instruments = items;
        },
        setUserProjects(state, items) {
            state.projects = items;
        },
    },

    // typically make ajax calls and then
    // call appropriate mutations to change state.
    actions: {
        fetchUserList: function(context, payload) {
            return new Promise((resolve, reject) => {
                let type = payload.type;
                let key = "user-"+context.state.currentUserId+"-"+type+"-list";
                let url = '/api/users/'+ context.state.currentUserId + '/' + type + ((payload.list === true) ? '?list=true' : '');

                console.log('fetchUserList payload: ' + JSON.stringify(payload));
                if (localStorage.getItem(key) && (!payload.force)) {
                    try {
                        console.log('getting user ' + type + ' from localStorage.');
                        if (type === 'profiles') {
                            context.commit('setUserProfiles', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'projects') {
                            context.commit('setUserProjects', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'instruments') {
                            context.commit('setUserInstruments', JSON.parse(localStorage.getItem(key)));
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
                                context.commit('setUserProfiles', response.data.data);
                            } else if (type === 'projects') {
                                context.commit('setUserProjects', response.data.data);
                            } else if (type === 'instruments') {
                                context.commit('setUserInstruments', response.data.data);
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
        updateUserProfile: function(context, payload) {
            return new Promise((resolve, reject) => {
                let url = '/api/users/'+ context.state.currentUserId + '/profile?name=' + payload.name + "&value=" + payload.value;
                console.log('updateUserProfile payload: ' + JSON.stringify(payload));
                console.log('url: ' + url);

                axios
                    .request({ url: url, method: 'PUT',
                        headers:{ 'Content-Type' : 'application/json', 'Authorization' : context.getters.bearerToken, },
                    })
                    .then(response=>{
                        context.dispatch('fetchUserList', { 'type': 'profiles', 'force': true });
                        console.log('User Profile ' + payload.name + ' successfully updated.');
                        resolve();
                    })
                    .catch(error => {
                        console.log(error);
                        error();
                    })
            })
        },

    },
}