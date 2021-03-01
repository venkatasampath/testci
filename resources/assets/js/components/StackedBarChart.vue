<template>
    <div :id="chartId">
        <canvas :class="chartId"></canvas>
    </div>
</template>
<script>
    export default {
        props: {
            chartId: String,
            chartClass: String,
            chartType: String,
            filteredlist: Array,
            searchList: Array,
            labels: Array
        },
        computed: {
            ReturnList: function () {
                var detailedArray = [];
                for (var x = 0; x < this.filteredlist.length; ++x)
                {
                    var Set = [];
                    var SetIndex = 0;
                    for (var i = 0; i < this.searchList.length; ++i) {
                        if(this.chartClass === "MitoBone") {
                            if (this.searchList[i].mito_sequence_number === this.filteredlist[x].mito_sequence_number) {
                                Set[SetIndex++] = this.searchList[i];
                            }
                        } else if(this.chartClass === "MNIZone") {
                            if (this.searchList[i].zone_display_name === this.filteredlist[x].display_name) {
                                if (this.searchList[i].name === this.filteredlist[x].name) {
                                    Set[SetIndex++] = this.searchList[i];
                                }
                            }
                        } else if(this.chartClass === "ANByP1") {
                            if (this.searchList[i].provenance1 === this.filteredlist[x].provenance1) {
                                Set[SetIndex++] = this.searchList[i];
                            }
                        } else {
                            if(this.searchList[i].name === this.filteredlist[x].name) {
                               Set[SetIndex++] = this.searchList[i];
                            }
                        }
                    }
                    detailedArray[x] = Set;
                }
                return detailedArray;
            },
            dataset: function() {
                var shortArray = [ "#21897E", "#3BA99C", "#56E39F"];
                var shortArrayOption2 = ["#8980F5", "#B6A6CA", "#D5CFE1"];
                var colorArray = ["#002125", "#00414A", "#00626F", "#008293", "#00A2B8", "#17B9CE", "#45C7D8", "#73D5E2", "#A2E3EB", "#D0F1F5"];
                var initialArray = this.ReturnList;
                var returnArray = [];
                var returnArrayCounter = 0;
                for (var x = 0; x < initialArray.length; ++x) {
                    var currentElement = initialArray[x];
                    for (var i = 0; i < currentElement.length; ++i) {
                        var innerElement = currentElement[i];
                        var backgroundColor = colorArray[i];
                        if (this.chartClass === "MNIZone") {
                            backgroundColor = shortArray[i];
                        }
                        if (this.chartClass === "MNIBone") {
                            backgroundColor = shortArrayOption2[i];

                        }
                        var newArray = Array.from(Array(initialArray.length), () => 0);
                        newArray[x] = innerElement.total;
                        var computed_label;
                        if (this.chartClass === "MitoBone" || this.chartClass === "MNIZone") {
                            computed_label = innerElement.name + '-' + innerElement.side;
                        }
                        else {
                            computed_label = innerElement.side;
                        }
                        returnArray[returnArrayCounter++] = {
                            data: newArray,
                            label: computed_label,
                            backgroundColor: backgroundColor
                        };
                    }
                }
                return returnArray;
            },
            display: function() {
                var display = false;
                if (this.chartClass === "MitoBone") {
                    display = true;
                }
                return display;
            }
        },
        mounted() {
            var element = document.querySelector('.'+ this.chartId);
            var graph = new Chart(element, {
                type: this.chartType,
                options: {
                    scales: {
                        xAxes: [{
                            stacked: true,
                            display: this.display
                        }],
                        yAxes: [{
                            stacked: true
                        }]
                    },
                    legend: {
                        display: false
                    }
                },
                data: {
                    labels: this.labels,
                    datasets: this.dataset
                }
            });
        }
    }
</script>
