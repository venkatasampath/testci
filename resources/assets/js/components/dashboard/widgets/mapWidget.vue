<template>
    <v-card class="m-2 p-0" v-if="show_widget">
        <v-card-title class="m-0 p-0">
            <v-toolbar dense>
                <v-toolbar-title>{{ title }}</v-toolbar-title>
                <v-spacer></v-spacer>
                <v-btn title="Help - CoRA Docs" icon color="primary" :href="help_url" target="_blank"><v-icon>mdi-help-circle-outline</v-icon></v-btn>
                <v-btn :title="!isCollapse ? 'Collapse' : 'Expand'" icon color="primary" @click="collapse">
                    <v-icon v-text="isCollapse ? 'mdi-arrow-collapse-down' : 'mdi-arrow-collapse-up'"></v-icon>
                </v-btn>
                <v-btn title="Close" icon color="primary" @click="close" :loading="loading"><v-icon>mdi-close</v-icon></v-btn>
            </v-toolbar>
        </v-card-title>
        <v-card-text v-if="!isCollapse" class="m-0 p-0">
            <div id="google-maps-widget">
                <div id="cora-google-map-widget" class="google-map" ref="googleMap"></div>
            </div>
        </v-card-text>
        <v-card-actions v-if="!isCollapse" class="m-0 p-0">
            <v-toolbar dense>
                <v-toolbar-title dense><v-icon title="Last updated at" icon color="primary" class="mr-2">mdi-calendar</v-icon>{{last_updated_at}}</v-toolbar-title>
<!--                <v-spacer></v-spacer>-->
<!--                <v-btn title="Details" icon color="primary" @click=""><v-icon>mdi-clipboard-text</v-icon></v-btn>-->
            </v-toolbar>
        </v-card-actions>
    </v-card>
</template>

<script>
    import {mapGetters, mapState} from "vuex";
    import axios from "axios";
    import {eventBus} from "../../../eventBus";
    // import GoogleMapsApiLoader from 'google-maps-api-loader';
    // import gmapsInit from './gmaps';

    export default {
        name: "map-widget",
        props: {
            index: { type: Number },
            type: { type: String, default: "projects_map" }, // valid values "projects", "orgs", "accessions"
            help_url: { type: String, default: "https://cora-docs.readthedocs.io" },
            title: { type: String, default: "Projects Location Map" },
            default_items: { type: Array, default: () => ([]) },

            mapConfig: Object,
            apiKey: String,
        },
        data () {
            return {
                loading: false,
                show_widget: true,
                isCollapse: false,
                last_updated_at: new Date().toISOString().slice(0,19).replace("T", " "),
                url: '/api/dashboard/users/allprojectsummary?by=project',

                // Original
                mapName: "cora-google-map-widget",
                projects: this.default_items,
                map: null,
                google: null,
                bounds: null,
                markers: [],
                markerCluster: null,
            }
        },
        created() {
            // Listen for the visible and expand events.
            eventBus.$on('dashboard-event', payload => {
                this.isCollapse = payload.expanded;
            });

            // If data is not passed by parent dashboard container, go fetch it
            if (!this.projects) {
                this.getMapData();
            }
        },
        mounted() {
            this.bounds = new google.maps.LatLngBounds();
            const element = document.getElementById(this.mapName);
            const mapCenter = {lat: 41.2473820, lng: -96.0167990} // Omaha - UNO-PKI
            const options = {
                center: {lat: 41.2473820, lng: -96.0167990} // Omaha - UNO-PKI
            };
            this.map = new google.maps.Map(element, options);
            var lastInfoWindow;

            this.projects.forEach((project) => {
                if (project) {
                    const position = new google.maps.LatLng(project.latitude, project.longitude);
                    const marker = new google.maps.Marker({
                        position: new google.maps.LatLng(project.latitude, project.longitude),
                        map: this.map,
                        content:
                            '<div id="content">' +
                            '<div id="siteNotice">' +
                            '</div>' +
                            '<h4 id="firstHeading" class="firstHeading" style="margin-top: 0px; margin-bottom: 0px; " >' + project.project_name + '  <a href="/projectDashboard/' + project.project_id + '"' + 'class="fas fa-tachometer-alt" ><a/></h4>' +
                            '<div id="bodyContent">' +
                            '<p><strong> Description:  </strong>' + project.project_description +
                            '<br><strong>Project Manager:  </strong>' + project.project_manager +
                            '<br><strong>Project Status:  </strong>' + project.project_status +
                            '<br>' + '<br>' +
                            '</div>' +
                            '</div>'
                    });

                    this.markers.push(marker);

                    var infowindow = new google.maps.InfoWindow({
                        content: marker.content
                    });

                    marker.addListener('mouseover', function () {
                        // Close the previous infowindow and open the current one
                        if (lastInfoWindow) {
                            lastInfoWindow.close();
                        }

                        infowindow.open(this.mapName, marker);
                        lastInfoWindow = infowindow;
                    });

                    this.map.fitBounds(this.bounds.extend(position))
                }
            });

            // Add a marker clusterer to manage the markers.
            this.markerCluster = new MarkerClusterer(this.map, this.markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'} );
        },

        // async mounted() {
        //     console.log("Map-Widget: projects: "+JSON.stringify(this.projects));
        //     try {
        //         const google = this.google = await gmapsInit();
        //         const element = document.getElementById(this.mapName);
        //         this.renderLocations();
        //     } catch (error) {
        //         console.error(error);
        //     }
        // },
        methods:{
            renderLocations() {
                this.bounds = new google.maps.LatLngBounds();
                const element = document.getElementById(this.mapName);
                const options = {
                    center: {lat: 41.2473820, lng: -96.0167990} // Omaha - UNO-PKI
                    // center: new google.maps.LatLng(mapCentre.latitude, mapCentre.longitude)
                };
                this.map = new google.maps.Map(element, options);
                var lastInfoWindow;

                this.projects.forEach((project) => {
                    if (project) {
                        const position = new google.maps.LatLng(project.latitude, project.longitude);
                        const marker = new google.maps.Marker({
                            position: new google.maps.LatLng(project.latitude, project.longitude),
                            map: this.map,
                            content:
                                '<div id="content">' +
                                '<div id="siteNotice">' +
                                '</div>' +
                                '<h4 id="firstHeading" class="firstHeading" style="margin-top: 0px; margin-bottom: 0px; " >' + project.project_name + '  <a href="/projectDashboard/' + project.project_id + '"' + 'class="fas fa-tachometer-alt" ><a/></h4>' +
                                '<div id="bodyContent">' +
                                '<p><strong> Description:  </strong>' + project.project_description +
                                '<br><strong>Project Manager:  </strong>' + project.project_manager +
                                '<br><strong>Project Status:  </strong>' + project.project_status +
                                '<br>' + '<br>' +
                                '</div>' +
                                '</div>'
                        });

                        this.markers.push(marker);

                        var infowindow = new google.maps.InfoWindow({
                            content: marker.content
                        });

                        marker.addListener('mouseover', function () {
                            // Close the previous infowindow and open the current one
                            if (lastInfoWindow) {
                                lastInfoWindow.close();
                            }

                            infowindow.open(this.mapName, marker);
                            lastInfoWindow = infowindow;
                        });

                        this.map.fitBounds(this.bounds.extend(position))
                    }
                });

                // Add a marker clusterer to manage the markers.
                this.markerCluster = new MarkerClusterer(this.map, this.markers, {imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'} );
            },
            getMapData: function () {
                this.loading = true;
                axios
                    .request({ url: this.url, method: 'GET',
                        headers: { 'Content-Type': 'application/json', 'Authorization': this.$store.getters.bearerToken },
                    })
                    .then(response => {
                        this.projects = response.data.data.projects;
                        console.log("getMapData: " + this.projects);
                        // this.renderLocations();
                        this.loading = false;
                    })
            },
            collapse() {
                // emit event for dashboard before setting isCollapse
                let payload = { 'index': this.index, 'visible': this.show_widget, 'expanded': this.isCollapse };
                eventBus.$emit('dashboard-widget-event', payload);
                this.isCollapse = !this.isCollapse;
            },
            close() {
                this.show_widget = !this.show_widget;
                // emit event for dashboard after setting show_widget
                let payload = { 'index': this.index, 'visible': this.show_widget, 'expanded': this.isCollapse };
                eventBus.$emit('dashboard-widget-event', payload);
            },
        },
        computed:{
            ...mapState({
                //
            }),
            ...mapGetters({
                bearerToken: 'bearerToken',
                csrfToken: 'csrfToken',
                theOrg: 'theOrg',
                theUser: 'theUser',
                theProject: 'theProject',
            }),
        },
    }
</script>

<style scoped>
    .google-map {
        width: auto;
        height: 450px;
        margin: 0 auto;
        background: gray;
    }
</style>
