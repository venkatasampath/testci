<template>
    <div :id="calculatedClass">
        <div class="google-map" :id="mapName"></div>
    </div>
</template>

<style scoped>
    .google-map {
        width: auto;
        height: 354px;
        margin: 0 auto;
        background: gray;
    }
</style>

<script>
    export default {
        name: 'google-map',
        props: {
            projectDetailsArray: Array,
            calculatedClass: String
        },
        data: function () {
            return {
                mapName: this.name + "-map",
                projectDetails: this.projectDetailsArray,
                map: null,
                bounds: null,
                markers: [],
                markerCluster: null,
            }
        },
        mounted:
            function () {
                this.bounds = new google.maps.LatLngBounds();
                const element = document.getElementById(this.mapName);
                const mapCentre = this.projectDetails[0];
                const options = {
                    center: {lat: 41.2473820, lng: -96.0167990} // Omaha - UNO-PKI
                    // center: new google.maps.LatLng(mapCentre.latitude, mapCentre.longitude)
                };
                this.map = new google.maps.Map(element, options);
                var lastInfoWindow;

                this.projectDetails.forEach((project) => {
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
            }
    };
</script>

