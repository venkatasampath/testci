<template>
    <div id="vue-app">
    <v-app>
        <v-app-bar app>
            <a href="/"><v-img src="/cora-logo-new-gray.svg" style="max-height: 32px; max-width: 128px; margin-right: 24px"></v-img></a>
            <v-flex></v-flex>
            <a href="/"><v-img src="/cora-logo-new-gray.svg" style="max-height: 32px; max-width: 128px; margin-right: 24px"></v-img></a>
        </v-app-bar>
        <v-card width="400" class="mx-auto" style="margin-top: 100px;">
            <v-card-title class="pb-0">
                <h1>Login</h1>
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-text-field label="Email" prepend-icon="mdi-email" autocomplete="username"/>
                    <v-text-field :type="showPassword ? 'text' : 'password'" label="Password" prepend-icon="mdi-lock" autocomplete="current-password"
                            :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'" @click:append="showPassword = !showPassword">
                    </v-text-field>
                    <v-switch primary label="Remember me"/>
                </v-form>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-btn color="primary">Login</v-btn>
                <v-btn color="lightgray">Forgot Your Password?</v-btn>
            </v-card-actions>
        </v-card>
    </v-app>
    </div>
</template>
<script>
    export default {
        name: "cora.login",
        data () {
            return {
                showPassword: false
            }
        }
    }
</script>

<style scoped>

</style>