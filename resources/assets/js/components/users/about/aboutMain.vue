<template>
    <div class="m-2 align-center">
        <contentheader :trail="trail" :title="heading" :help_menu="true"></contentheader>
        <v-row align="center" justify="center">
            <v-col cols="12" md="8">
                <v-tabs centered>
                    <v-tab><v-icon left>mdi-info</v-icon>About</v-tab>
                    <v-tab><v-icon left>mdi-google-chrome</v-icon>About Browser</v-tab>
                    <v-tab><v-icon left>mdi-human-greeting</v-icon>Welcome</v-tab>
                    <v-tab><v-icon left>mdi-alpha-e-circle</v-icon>EULA</v-tab>
                    <v-tab-item>
                        <v-card>
                            <about :applabel="applabel"
                                   :appname="appname"
                                   :versionlabel="versionlabel"
                                   :version="version"
                                   :copyrightlabel="copyrightlabel"
                                   :copyright="copyright"
                                   :productprotectlabel="productprotectlabel"
                                   :productprotect="productprotect"
                                   :optimizedbrowserlabel="optimizedbrowserlabel"
                                   :optimizedbrowser="optimizedbrowser"
                                   :browserslabel="browserslabel"
                                   :popupblockerlabel="popupblockerlabel"
                                   :popupblocker="popupblocker">
                            </about>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item>
                        <v-card>
                            <about-browser :browsernamelabel="browsernamelabel"
                                    :browserversionlabel="browserversionlabel"
                                    :cookieslabel="cookieslabel"
                                    :languagelabel="languagelabel"
                                    :onlinelabel="onlinelabel"
                                    :productlabel="productlabel"
                                    :oslabel="oslabel"
                                    :useragentlabel="useragentlabel">
                            </about-browser>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item>
                        <v-card>
                            <v-card-text align="center" justify="center">
                                {{welcometext}}
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                    <v-tab-item>
                        <v-card>
                            <v-card-text align="center" justify="center">
                                Eula page coming soon.
                            </v-card-text>
                        </v-card>
                    </v-tab-item>
                </v-tabs>
            </v-col>
        </v-row>
    </div>
</template>

<script>
    import about from "./about";
    import aboutBrowser from "./aboutBrowser";

    export default {
        components:{
            'about':about,
            'about-browser':aboutBrowser
        },
        name: "about-main",
        props:{
            heading: { type: String, default: "About CoRA" },
            applabel:String,
            appname:String,
            versionlabel:String,
            version:String,
            copyrightlabel:String,
            copyright:String,
            productprotectlabel:String,
            productprotect:String,
            optimizedbrowserlabel:String,
            optimizedbrowser:String,
            browserslabel:String,
            popupblockerlabel:String,
            popupblocker:String,
            browsernamelabel:String,
            browserversionlabel:String,
            cookieslabel:String,
            languagelabel:String,
            onlinelabel:String,
            productlabel:String,
            oslabel:String,
            useragentlabel:String,
            welcometext:String,
        },
        data() {
            return {
                trail: [{ text: 'Home', disabled: false, href: '/', }, { text: 'About', disabled: true, href: '/', }, ],
            };
        },
    }
</script>

<style scoped>

</style>