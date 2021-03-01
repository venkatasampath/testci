<template>
    <v-simple-table>
        <template v-slot:default>
            <tbody>
                <tr><td>{{browsernamelabel}}</td><td>{{browserName}}</td></tr>
                <tr><td>{{browserversionlabel}}</td><td>{{appVersion}}</td></tr>
                <tr><td>{{cookieslabel}}</td><td>{{cookieEnabled}}</td></tr>
                <tr><td>{{languagelabel}}</td><td>{{language}}</td></tr>
                <tr><td>{{onlinelabel}}</td><td>{{onLine}}</td></tr>
                <tr><td>{{productlabel}}</td><td>{{product}}</td></tr>
                <tr><td>{{oslabel}}</td><td>{{platform}}</td></tr>
                <tr><td>{{useragentlabel}}</td><td>{{userAgent}}</td></tr>
            </tbody>
        </template>
    </v-simple-table>
</template>

<script>
    export default {
        name: "about-browser",
        props:{
            browsernamelabel:String,
            browserversionlabel:String,
            cookieslabel:String,
            languagelabel:String,
            onlinelabel:String,
            productlabel:String,
            oslabel:String,
            useragentlabel:String,
        },
        data(){
            return{
                appName:'',
                appCodeName:'',
                browserName:'',
                appVersion:'',
                cookieEnabled:'',
                language:'',
                onLine:'',
                product:'',
                platform:'',
                userAgent:''
            }
        },
        beforeMount() {
            this.appName=navigator.appName;
            this.appCodeName=navigator.appCodeName;
            this.browserName=this.appName+' (codename: '+this.appCodeName+')';
            this.appVersion=navigator.appVersion;
            this.cookieEnabled=navigator.cookieEnabled;
            this.language=navigator.language;
            this.onLine=navigator.onLine;
            this.product=navigator.product;
            this.platform=navigator.platform;
            this.userAgent=navigator.userAgent;
        }
    }
</script>

<style scoped>

</style>