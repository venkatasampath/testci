<template>
    <div>
        <!--    <v-footer>-->
        <!--        <div class="dpaa-icon-section left">-->
        <!--            <a href="http://www.dpaa.mil" class="logo left" target="_blank"><img src="/dpaa-logo-512.png" style="height: 48px;"></a>-->
        <!--            <div class="left">-->
        <!--                <span>Defense POW/MIA Accounting Agency</span>-->
        <!--                <span class="dpaa-subtitle">Fulfilling Our Nation's Promise</span>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--        <div class="footer-text">-->
        <!--            <span>The Commingled Remains and Analytics (CoRA) ecosystem is the product of a partnership between the Defense POW/MIA Accounting Agency (DPAA) and the University of Nebraska Omaha, College of Information Science and Technology (UNO IS&T). This collaborative effort between the students and faculty of UNO IS&T and the forensic anthropology staff of DPAA, is an effort to support the global forensic community.</span>-->
        <!--        </div>-->
        <!--        <div class="uno-footer-section right">-->
        <!--            <a href="http://www.unomaha.edu" class="logo right" target="_blank"><img src="uno-logo-long-darkbg.png" style="height: 48px;"></a>-->
        <!--        </div>-->
        <!--        <v-spacer></v-spacer>-->
        <!--    </v-footer>-->

        <v-footer>
            <v-row>
                <v-divider class="m-0"></v-divider>
                <v-col class="p-2" cols="2" align="start" justify="start">
                    <a href="http://www.dpaa.mil" target="_blank"><img src="/dpaa-logo-512.png" style="height: 48px;"></a>
                    <v-row class="px-3 py-2" v-if="$vuetify.breakpoint.mdAndUp" style="font-size: 10px; line-height: 1.25">
                        <span>Defense POW/MIA Accounting Agency</span>
                        <span class="dpaa-subtitle">Fulfilling Our Nation's Promise</span>
                    </v-row>
                </v-col>
                <v-col cols="8">
                    <!--                <v-card flat light class="text-center">-->
                    <v-card-text class="p-1 text-center">
                        <v-btn v-for="icon in icons" :key="icon" class="mx-4" icon>
                            <v-icon size="24px">{{ icon }}</v-icon>
                        </v-btn>
                        <!--                        <span class="float-right">-->
                        <!--                            <a href="/"><v-img src="/cora-logo-new-gray.svg" style="max-height: 32px; max-width: 128px; margin-right: 24px"></v-img></a>-->
                        <!--                            {{ new Date().getFullYear() }} — <strong>Vuetify</strong>-->
                        <!--                        </span>-->
                    </v-card-text>

                    <v-card-text class="p-1" style="font-size: 10px; line-height: 1.25">
                        <span>The Commingled Remains and Analytics (CoRA) ecosystem is the product of a partnership between the Defense POW/MIA Accounting Agency (DPAA) and the University of Nebraska Omaha, College of Information Science and Technology (UNO IS&T). This collaborative effort between the students and faculty of UNO IS&T and the forensic anthropology staff of DPAA, is an effort to support the global forensic community.</span>
                    </v-card-text>

                    <!--                    <v-card-text class="white&#45;&#45;text">-->
                    <!--                        <a href="/"><v-img src="/cora-logo-new-gray.svg" style="max-height: 32px; max-width: 128px; margin-right: 24px"></v-img></a>-->
                    <!--                        {{ new Date().getFullYear() }} — <strong>CoRA</strong>-->
                    <!--                    </v-card-text>-->
                    <!--                </v-card>-->
                </v-col>
                <v-col v-if="$vuetify.breakpoint.mdAndUp" class="p-2" cols="2" align="end" justify="end">
                    <a href="http://www.unomaha.edu" target="_blank"><img src="/uno-logo-long-darkbg.png" style="height: 48px;"></a>
                </v-col>
                <v-col v-else class="p-2" cols="2" align="end" justify="end">
                    <a href="http://www.unomaha.edu" target="_blank"><img src="/uno-logo-color.png" style="height: 48px;"></a>
                </v-col>
            </v-row>
        </v-footer>
    </div>
</template>

<script>
    export default {
        data: () => ({
            icons: [
                'mdi-facebook',
                'mdi-twitter',
                'mdi-linkedin',
                'mdi-instagram',
            ],
        }),
    }
</script>
<style scoped>
    .dpaa-icon-section {
        font-size: 10px;
        width: 20%
    }
    .uno-footer-section{
        width:15%
    }
    .footer-text{
        width: 65%;
        font-size: 12px;
        /*color: rgb(99, 107, 111);*/
    }
    .dpaa-title{
        margin-top: 18px;
        margin-left: 5px;
        margin-bottom: 0;
        color: white;
        display: block;
    }
    .dpaa-subtitle{
        margin: 0 0 2px;
        color: #3399cc;
        display: block;
    }
</style>