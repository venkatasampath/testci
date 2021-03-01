<!--Swetha: V-model name changed from date to dateValue and menu to showMenu as date and menu are native values.-->
<template>
    <v-col cols="12" :md="mdvalue" :sm="smvalue" :class="colval">
    <v-menu ref="menu" v-model="showMenu" :close-on-content-click="false" :return-value.sync="dateValue"
            transition="scale-transition" >
        <template v-slot:activator="{ on }">
            <v-text-field :name="name" v-bind="$attrs" v-model="dateValue" :label="label" placeholder="yyyy-mm-dd" :class="textval"
                          :disabled="disabled" clearable v-on="on" @input="updateDate" @click:clear="dateValue = null">
            </v-text-field>
        </template>
        <v-date-picker header-color="#1E88E5" text color="#1E88E5" v-model="dateValue" @input="updateDate" :min="minvalue">
            <v-spacer></v-spacer>
            <v-btn font="bold" color="#1E88E5" @click="showMenu = false">Cancel</v-btn>
            <v-btn font="bold" color="#1E88E5" @click="setDate">OK</v-btn>
        </v-date-picker>
    </v-menu>
    </v-col>
</template>

<script>
    import {eventBus} from "../../eventBus";

    export default {
        inheritAttrs: false,
        name: "date",

        data() {
            return {
                showMenu: this.menu,
                dateValue: this.value,
            };
        },

        props: {
            value: [String, Array],
            menu: Boolean,
            label: String,
            disabled: Boolean,
            minvalue:String,
            name: String,
            type: String,
            mdvalue: {type: Number, default: 0},
            smvalue: {type: Number, default: 0},
            colval: {type: String, default: null},
            textval:{type: String, default: null}
        },

        // triggers to notify the child component in case of changes through emit
        watch: {
            value(val) {
                this.dateValue = val;
            },
            dateValue(val) {
                this.$emit("input", val);
            }
        },

        methods: {
            setDate() {
                this.$refs.menu.save(this.dateValue);
            },

            updateDate() {
                this.value = this.dateValue;

                switch (this.type) {
                    case 'btbrequestdate':
                        eventBus.$emit('updatebtbrequestdate', this.dateValue);
                        break;
                    case 'btbreceivedate':
                        eventBus.$emit('updatebtbreceivedate', this.dateValue);
                        break;
                    case 'MitoReceiveDate':
                        eventBus.$emit('updateMitoReceiveDate', this.dateValue);
                        break;
                    case 'MitoRequestDate':
                        eventBus.$emit('updateMitoRequestDate', this.dateValue);
                        break;
                    case 'MitoMccDate':
                        eventBus.$emit('updatedMitoMccDate', this.dateValue);
                        break;
                    case 'AustrRequestDate':
                        eventBus.$emit('updateAustrRequestDate', this.dateValue);
                        break;
                    case 'AustrReceiveDate':
                        eventBus.$emit('updateAustrReceiveDate', this.dateValue);
                        break;
                    case 'AustrMccDate':
                        eventBus.$emit('updateAustrMccDate', this.dateValue);
                        break;
                    case 'YstrRequestDate':
                        eventBus.$emit('updateYstrRequestDate', this.dateValue);
                        break;
                    case 'YstrReceiveDate':
                        eventBus.$emit('updateYstrReceiveDate', this.dateValue);
                        break;
                    case 'YstrMccDate':
                        eventBus.$emit('updateYstrMccDate', this.dateValue);
                        break;
                    default:
                }
            }
        }
    };
</script>
