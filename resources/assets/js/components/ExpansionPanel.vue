<template>
    <div>
        <v-expansion-panels>
            <v-expansion-panel :accordion="accordion">
                <v-expansion-panel-header> {{ panelHeader }}
                </v-expansion-panel-header>
                <v-expansion-panel-content>
                    <slot>

                    </slot>
                </v-expansion-panel-content>
            </v-expansion-panel>
        </v-expansion-panels>
    </div>
</template>

<script>
    export default {
        name: 'expansionpanel',
        props: {
            accordion: {
                type: Boolean,
                default: false
            },
            panelHeader: String,
        },
        data: () => ({})
    }
</script>

<style>

</style>