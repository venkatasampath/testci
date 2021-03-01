<template>
        <div class="card">
            <div class="card-header"  style="margin:0">
                <div class="row">
                    <div class="col-md-2" style="text-align: center"><h4>{{slot1}}</h4></div>
                    <div class="col-md-2" style="text-align: center"><h4>{{slot2}}</h4></div>
                    <div class="col-md-2" style="text-align: center"><h4>{{slot3}}</h4></div>
                    <div class="col-md-2" style="text-align: center"><h4>{{slot4}}</h4></div>
                    <div class="col-md-2" style="text-align: center"><h4>{{slot5}}</h4></div>
                    <div class="col-md-2" style="text-align: center"><h4>{{slot6}}</h4></div>
                </div>
            </div>
        </div>
</template>

<script>
    export default {
        name: "ProjectHeader",
        props: {
            slot1: String,
            slot2: String,
            slot3: String,
            slot4: String,
            slot5: String,
            slot6: String
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
