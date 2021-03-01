// Project Module

import axios from "axios";

export default {
    state: {
        projects: [],
        currentProject: null,
        currentProjectId: 0,
        currentProjectSelection: 0,

        // Project specific attributes
        listcount: 0,
        accessions: [],
        provenance1: [],
        provenance2: [],
        anp1p2: [],
        individual_numbers: [],
        tags: [],
        users: [],
        specimens: [],
    },

    getters: {
        availableProjects(state, getters) {
            // ToDO: this is temporary, needs to be fixed
            return state.projects.filter(project => project.isActve)
        },
        getProjectById: (state, getters) => (id) => {
            return state.projects.filter(el => { return el.id === id});
        },
        getProjectNameById: (state, getters) => (id) => {
            let project = state.projects.find(el => { return el.id === id});
            return (project) ? project.name : "";
        },
        getProjectAccessions(state, getters, rootState) {
            if (state.accessions.length === 0) {
                let key = "project-"+state.currentProjectId+"-accessions-list";
                console.log("getProjectAccessions getter: "+key);
                if (localStorage.getItem(key)) {
                    return JSON.parse(localStorage.getItem(key));
                }
            }
            return state.accessions;
        },
        getProjectProvenance1(state, getters, rootState) {
            if (state.provenance1.length === 0) {
                let key = "project-"+state.currentProjectId+"-provenance1-list";
                console.log("getProjectProvenance1 getter: "+key);
                if (localStorage.getItem(key)) {
                    return JSON.parse(localStorage.getItem(key));
                }
            }
            return state.provenance1;
        },
        getProjectProvenance2(state, getters, rootState) {
            if (state.provenance2.length === 0) {
                let key = "project-"+state.currentProjectId+"-provenance2-list";
                console.log("getProjectProvenance2 getter: "+key);
                if (localStorage.getItem(key)) {
                    return JSON.parse(localStorage.getItem(key));
                }
            }
            return state.provenance2;
        },
        getProjectAnP1P2(state, getters, rootState) {
            if (state.anp1p2.length === 0) {
                let key = "project-"+state.currentProjectId+"-anp1p2-list";
                console.log("getProjectAnP1P2 getter: "+key);
                if (localStorage.getItem(key)) {
                    return JSON.parse(localStorage.getItem(key));
                }
            }
            return state.anp1p2;
        },
        getProjectIndividualNumbers(state, getters, rootState) {
            if (state.individual_numbers.length === 0) {
                let key = "project-"+state.currentProjectId+"-individual-numbers-list";
                console.log("getProjectIndividualNumbers getter: "+key);
                if (localStorage.getItem(key)) {
                    return JSON.parse(localStorage.getItem(key));
                }
            }
            return state.individual_numbers;
        },
        getProjectTags(state, getters, rootState) {
            if (state.tags.length === 0) {
                let key = "project-"+state.currentProjectId+"-tags-list";
                console.log("getProjectTags getter: "+key);
                if (localStorage.getItem(key)) {
                    return JSON.parse(localStorage.getItem(key));
                }
            }
            return state.tags;
        },
        getProjectTagsByType: (state, getters, rootState) => (type) => {
            if (state.tags.length === 0) {
                let key = "project-"+state.currentProjectId+"-tags-list";
                if (localStorage.getItem(key)) {
                    let tags = JSON.parse(localStorage.getItem(key));
                    return tags.filter(tag => { return tag.type === type});
                }
            }
            return state.tags.filter(tag => { return tag.type === type});
        },

        getProjectSpecimens(state, getters, rootState) {
            if (state.specimens.length === 0) {
                let key = "project-"+state.currentProjectId+"-specimens-list";
                console.log("getProjectSpecimens getter: "+key);
                if (localStorage.getItem(key)) {
                    return JSON.parse(localStorage.getItem(key));
                }
            }
            return state.specimens;
        },
        getProjectUsers(state, getters, rootState) {
            if (state.users.length === 0) {
                let key = "project-"+state.currentProjectId+"-users-list";
                console.log("getProjectUsers getter: "+key);
                if (localStorage.getItem(key)) {
                    return JSON.parse(localStorage.getItem(key));
                }
            }
            return state.users;
        },
    },

    mutations: {
        setProjects(state, projects) {
            state.projects = projects;
        },
        setCurrentProject(state, project) {
            state.currentProject = project;
            state.currentProjectId = (project) ? project.id : 0;
        },
        setCurrentProjectSelection(state, id) {
            state.currentProjectSelection = id;
        },
        setListCount(state, count) {
            state.listcount = count;
        },
        setAccessions(state, items) {
            state.accessions = items;
            state.listcount = (items) ? items.length : 0;
        },
        setProvenance1(state, items) {
            state.provenance1 = items;
            state.listcount = (items) ? items.length : 0;
        },
        setProvenance2(state, items) {
            state.provenance2 = items;
            state.listcount = (items) ? items.length : 0;
        },
        setAnP1P2(state, items) {
            state.anp1p2 = items;
            state.listcount = (items) ? items.length : 0;
        },
        setIndividualNumbers(state, items) {
            state.individual_numbers = items;
            state.listcount = (items) ? items.length : 0;
        },
        setTags(state, items) {
            state.tags = items;
            state.listcount = (items) ? items.length : 0;
        },
        setSpecimens(state, items) {
            state.specimens = items;
            state.listcount = (items) ? items.length : 0;
        },
        setUsers(state, items) {
            state.users = items;
            state.listcount = (items) ? items.length : 0;
        },
    },

    // typically make ajax calls and then
    // call appropriate mutations to change state.
    actions: {
        // This is the switchProject that is currently used that submits the form.
        switchProjectAPI(context, user) {
            return new Promise((resolve, reject) => {
                let formProjectSwitch =  document.querySelector('#form-project-switch');
                $("input#currentProject", formProjectSwitch).val(context.state.currentProjectSelection);
                $("input#_token", formProjectSwitch).val(document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
                formProjectSwitch.submit();
                resolve();
            })
        },
        switchProjectAPI1(context, user) {
            return new Promise((resolve, reject) => {
                axios
                    .post("/users/" + user.id + "/refreshDashboard", {
                        currentProject: context.state.currentProjectSelection,
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    })
                    .then(function (response) {
                        console.log(response.data)
                        context.commit('setCurrentProject', response.data.data)
                        alert("Success! You are currently in project " + context.state.currentProject.name);
                        resolve();
                    })
            })
        },
        switchProjectAPI2(context, user) {
            return new Promise((resolve, reject) => {
                axios
                    .request({
                        url: "/api/users/" + user.id + "/current-project",
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization' : context.getters.bearerToken,
                        },
                        params: {
                            "id": context.state.currentProjectSelection,
                        }
                    })
                    .then((response) => {
                        console.log(response.data)
                        context.commit('setCurrentProject', response.data.data)
                        console.log('Calling axios get "/')
                        axios.get("/");
                        resolve();
                    })
                    .catch(error => {
                        console.log(error);
                        error();
                    })
            })
        },

        fetchProjectList: function(context, payload) {
            return new Promise((resolve, reject) => {
                let type = payload.type;
                let key = "project-"+context.state.currentProjectId+"-"+type+"-list";
                let url = '/api/projects/'+ context.state.currentProjectId + '/' + type + '?list=true';

                console.log('fetchProjectList payload - ' + JSON.stringify(payload));
                if (localStorage.getItem(key) && (!payload.force)) {
                    try {
                        console.log('getting ' + type + ' from localStorage.');
                        if (type === 'accessions') {
                            context.commit('setAccessions', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'provenance1') {
                            context.commit('setProvenance1', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'provenance2') {
                            context.commit('setProvenance2', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'anp1p2') {
                            context.commit('setAnP1P2', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'individual-numbers') {
                            context.commit('setIndividualNumbers', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'tags') {
                            context.commit('setTags', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'specimens') {
                            context.commit('setSpecimens', JSON.parse(localStorage.getItem(key)));
                        } else if (type === 'users') {
                            context.commit('setUsers', JSON.parse(localStorage.getItem(key)));
                        }
                    } catch(e) {
                        localStorage.removeItem(key);
                    }
                } else { // Go fetch from server and store in browser cache
                    console.log('url: ' + url);
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
                            if (type === 'accessions') {
                                context.commit('setAccessions', response.data.data);
                            } else if (type === 'provenance1') {
                                context.commit('setProvenance1', response.data.data);
                            } else if (type === 'provenance2') {
                                context.commit('setProvenance2', response.data.data);
                            } else if (type === 'anp1p2') {
                                context.commit('setAnP1P2', response.data.data);
                            } else if (type === 'individual-numbers') {
                                context.commit('setIndividualNumbers', response.data.data);
                            } else if (type === 'tags') {
                                context.commit('setTags', response.data.data);
                            } else if (type === 'specimens') {
                                context.commit('setSpecimens', response.data.data);
                            } else if (type === 'users') {
                                context.commit('setUsers', response.data.data);
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
    }
}