// Search Module

import axios from "axios";

export default {
    state: { // = data
        searchOption: "SE-SB",
        searchFor: "Specimen",
        searchBy: "",
        searchString: "",
        searchName: "",
        searchDisplay: "",
        currentSearchResults: null,
        history: [],
        historyLength: 10,
        favorite: [],
        favoriteLength: 10,
        loading: false,
        rowsPerPageItems: [25, 50, 100, 250, 500],
        perPage: 100,
    },

    getters: { // = computed properties
        searchHistory(state, getters, rootState) {
            if (state.history.length === 0) {
                let key = "project-"+rootState.project.currentProjectId+"-search-history";
                console.log("searchHistory Key in serachHistory getter: "+key);
                if (localStorage.getItem(key)) {
                    return JSON.parse(localStorage.getItem(key));
                }
            }
            return state.history;
        },
        defaultSearchOption(state, getters) {
            let history = getters.searchHistory;
            // console.log('history: ' + JSON.stringify(history));
            return (history.length) ? history[0].searchOption : state.searchOption;
        },
        defaultSearchFor(state, getters) {
            let history = getters.searchHistory;
            // console.log('history: ' + JSON.stringify(history));
            return (history.length) ? history[0].searchFor : state.searchFor;
        },
        defaultSearchBy(state, getters) {
            let history = getters.searchHistory;
            // console.log('history: ' + JSON.stringify(history));
            return (history.length) ? history[0].searchBy : state.searchBy;
        },
        defaultSearchString(state, getters) {
            let history = getters.searchHistory;
            // console.log('history: ' + JSON.stringify(history));
            return (history.length) ? history[0].searchString : state.searchString;
        },
        defaultSearchName(state, getters) {
            let history = getters.searchHistory;
            // console.log('history: ' + JSON.stringify(history));
            return (history.length) ? history[0].searchName : state.searchName;
        },
        defaultSearchDisplay(state, getters) {
            let history = getters.searchHistory;
            // console.log('history: ' + JSON.stringify(history));
            return (history.length) ? history[0].searchDisplay : state.searchDisplay;
        },
        searchFavorite(state, getters, rootState) {
            if (state.favorite.length === 0) {
                let key = "project-"+rootState.project.currentProjectId+"-search-favorite";
                console.log("searchFavorite Key in serachFavorite getter: "+key);
                if (localStorage.getItem(key)) {
                    return JSON.parse(localStorage.getItem(key));
                }
            }
            return state.favorite;
        },
    },

    mutations: {
        setHistory(state, history) {
            state.history = history;
        },
        setSearch(state, search) {
            state.searchOption = search.searchOption;
            state.searchFor = search.searchFor;
            state.searchBy = search.searchBy;
            state.searchString = search.searchString;
            state.searchName = search.searchName;
            let sFor = (state.searchFor === 'SE') ? "Specimen" : (state.searchFor === 'DNA') ? "DNA" : (state.searchFor === 'ISO') ? "Isotope" : "Dental";
            search.searchDisplay = sFor + " search by " + state.searchName + ": " + state.searchString;
            state.searchDisplay = search.searchDisplay;
            let key = "project-"+search.projectId+"-search-history";
            console.log("searchHistory Key in setSearch: "+key);

            if (state.history.length === 0 && localStorage.getItem(key)) {
                state.history = JSON.parse(localStorage.getItem(key));
            }

            // Keep the history array in the right order.
            let reverse_history = [];
            reverse_history.push(search);
            state.history.forEach(element => reverse_history.push(element));
            state.history = reverse_history;
            // state.history.push(search);
            // if (state.history.length > state.historyLength) {
            //     state.history.shift();
            // }
            if (state.history.length > state.historyLength) {
                state.history.pop();
            }
            localStorage.setItem(key, JSON.stringify(state.history));
        },
        setFavorite(state, search) {
            let key = "project-"+search.projectId+"-search-favorite";
            console.log("searchFavorite Key in setFavorite: "+key);

            if (state.favorite.length === 0 && localStorage.getItem(key)) {
                state.favorite = JSON.parse(localStorage.getItem(key));
            }

            // Keep the favorite array in the right order.
            let reverse_favorite = [];
            reverse_favorite.push(search);
            state.favorite.forEach(element => reverse_favorite.push(element));
            state.favorite = reverse_favorite;
            if (state.favorite.length > state.favoriteLength) {
                state.favorite.pop();
            }
            localStorage.setItem(key, JSON.stringify(state.favorite));
        },
        deleteFavorite(state, search) {
            let key = "project-"+search.projectId+"-search-favorite";
            if (state.favorite.length === 0 && localStorage.getItem(key)) {
                state.favorite = JSON.parse(localStorage.getItem(key));
            }
            console.log("deleteFavorite: "+JSON.stringify(state.favorite));

            let favIndex = state.favorite.indexOf(search)
            console.log("search: "+JSON.stringify(search));
            console.log("favIndex: "+favIndex);
            if (favIndex > -1) {
                state.favorite.splice(favIndex, 1);
                localStorage.setItem(key, JSON.stringify(state.favorite));
            }
        },
    },

    actions: {
        fetchSearchList: function(context, search) {
            return new Promise((resolve, reject) => {
                console.log('fetchSearchList - search' + JSON.stringify(search));
                search['projectId'] = context.rootState.project.currentProjectId;
                context.commit('setSearch', search);
                return;

                let key = "project-"+context.state.currentProjectId+"-"+type+"-list";
                let url = '/api/projects/'+ context.state.currentProjectId + '/' + type + '?list=true';

                console.log('fetchSearchList payload - ' + JSON.stringify(search));
                let type = search.type;
                if (localStorage.getItem(key)) {
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
        fetchFavoriteList: function(context, searchItem) {
            return new Promise((resolve, reject) => {
                console.log('fetchFavoriteList - search' + JSON.stringify(searchItem));
                context.commit('setFavorite', searchItem);
                return context.state.favorite;
            })
        },
        deleteFavoriteSearch: function(context, searchItem) {
            return new Promise((resolve, reject) => {
                console.log('fetchFavoriteList - search' + JSON.stringify(searchItem));
                context.commit('deleteFavorite', searchItem);
                return context.state.favorite;
            })
        },
    }
}