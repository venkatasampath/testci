<template>
    <v-row>
        <v-col cols="6" md="3">
            <group v-model="values[groupModelKey]" :name="groupModelKey" label="Group" :options="group"></group>
        </v-col>
        <v-col cols="6" md="3">
            <Side v-model="values[groupSideModelKey]" :name="groupSideModelKey" label="Group Side" :options="groupSide" :required="false"></Side>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "GroupSide",
        props: {
            value: { type: Object, default: () => { } },
            modelKeys: { type: Object, default: () => { } },
            group: { type: Object, default: () => { } },
            groupSide: { type: Object, default: () => { } },
        },
        data() {
            return {
                values: this.value
            };
        },
        computed: {
            groupModelKey() {
                return this.modelKeys.group ? this.modelKeys.group : "group_select";
            },
            groupSideModelKey() {
                return this.modelKeys.groupSide ? this.modelKeys.groupSide : "group_side_select";
            }
        },
        watch: {
            value(val) {
                this.values = val;
            }
        }
    };
</script>
