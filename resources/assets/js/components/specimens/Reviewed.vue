<template>
    <v-row>
        <v-col>
            <v-switch id="reviewed" name="reviewed" v-model="review.reviewed" :value="review.reviewed"
                      :label="label" :disabled="disabled" dusk="se-reviewed">
            </v-switch>
        </v-col>
        <v-col>
            <date v-if="showDate && review.reviewed" v-model="review.reviewed_at" name="reviewed_at" label="Reviewed At" :disabled="disabled"/>
        </v-col>
    </v-row>
</template>

<script>
    export default {
        name: "reviewed",
        props: {
            value: { type: Object, default: () => {} },
            disabled: { type: Boolean, default: false },
            label: { type: String, default: "Reviewed" },
            showDate: { type: Boolean, default: true },
        },
        data() {
            return {
                review: this.value
            }
        },
        watch: {
            value(val) {
                this.review = val;
            }
        }
    }
</script>
