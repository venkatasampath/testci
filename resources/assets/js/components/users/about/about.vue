<template>
    <v-simple-table>
        <template v-slot:default>
            <tbody>
                <tr><td>{{applabel}}</td><td>{{appname}}</td></tr>
                <tr><td>{{versionlabel}}</td><td>{{version}}</td></tr>
                <tr><td>{{copyrightlabel}}</td><td>{{copyright1}}&copy;{{copyright2}}</td></tr>
                <tr><td>{{productprotectlabel}}</td><td>{{productprotect}}</td></tr>
                <tr><td>{{optimizedbrowserlabel}}</td><td>{{optimizedbrowser}}</td></tr>
                <tr>
                    <td>{{browserslabel}}</td>
                    <td>
                        <ul class="supportedbrowser">
                            <li><a href="http://www.google.com/chrome" target="_blank">http://www.google.com/chrome</a></li>
                            <li><a href="http://www.microsoft.com/en-us/windows/microsoft-edge" target="_blank">http://www.microsoft.com/en-us/windows/microsoft-edge</a></li>
                        </ul>
                    </td>
                </tr>
                <tr><td>{{popupblockerlabel}}</td><td>{{popupblocker}}</td></tr>
            </tbody>
        </template>
    </v-simple-table>
</template>

<script>
    export default {
        name: "about",
        props:{
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
        },
        data(){
            return{
                copyright1:this.copyright.split('&copy;')[0],
                copyright2:this.copyright.split('&copy;')[1],
            }
        }
    }
</script>
