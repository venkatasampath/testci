<template>
    <v-row>
        <v-col>
            <v-switch id="inventoried" name="inventoried" v-model="inventory.inventoried" :value="inventory.inventoried"
                      :label="label" :disabled="disabled" class="mt-0" dusk="se-inventory_completed">
            </v-switch>
        </v-col>
        <v-col>
            <date v-if="showDate && inventory.inventoried" v-model="inventory.inventoried_at" name="inventoried_at" dusk="se-inventory_date" label="Inventoried At" :disabled="disabled"/>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "InventoryCompleted",
        props: {
            value: { type: Object, default: () => {} },
            disabled: { type: Boolean, default: false },
            label: { type: String, default: "Inventory Completed" },
            showDate: { type: Boolean, default: true },
        },
        data() {
            return {
                inventory: this.value
            }
        },
        watch: {
            value(val) {
                this.inventory = val;
            }
        }
    }
</script>
