<template>
    <v-app>
        <CoraHeader></CoraHeader>
        <CoraContainer></CoraContainer>
        <CoraFooter></CoraFooter>
    </v-app>
</template>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/0.1.10/vue-resource.min.js"></script>
<script>
    import CoraHeader from './components/layout/Header'
    import CoraFooter from './components/layout/Footer'
    import CoraContainer from './components/layout/Container'

    // import MySidebar from './components/Sidebar'
    // Vue.component('reco', function (resolve, reject) {
    //   Vue.http.post('https://cors-anywhere.herokuapp.com/', function (data, status, request) {
    //     resolve({
    //       template: data
    //     })
    //   })
    // })
    export default {
        name: "CORA",
        props: {
            theOrg: Object,
            theUser: Object,
            theProject: Object,
            loading: false,
        },
        components: {
            CoraHeader,
            CoraFooter,
            CoraContainer
        },
        created() {
            console.log('App Main Component created.');
            this.loading = true;
            this.$store.dispatch('userLogin', this.theOrg, this.theUser, this.theProject)
                .then(() => this.loading = false);
        },
    }
</script>

<style>
    html, body{
        margin: 0;
        min-height: 100vh
    }
</style>