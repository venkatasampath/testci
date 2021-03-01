<v-card flat>
    <dashboardtable
            :reporturl="'http://cora25.test/api/dashboard/projects/specimens/complete?details=true'"
            :apitoken="'zijaNN5p3v250jSlA4XN9BpeRawTYXcT93kGgkptQMxGLamGwdDFyEGD3P5M'"
            :headers="[
                                    {text: 'Key', value: 'key', width: '6rem', visibility: true},
                                    {text: 'Bone', value: 'sb_id', width: '6rem', visibility: true},
                                    {text: 'Side', value: 'side', width: '6rem', visibility: true},
                                    {text: 'Bone Group', value: 'bone_group', width: '6rem', visibility: true},
                                    {text: 'Individual Number', value: 'individual_number', width: '10rem', visibility: true},
                                    {text: 'DNA Sampled', value: 'dna_sampled', width: '6rem', visibility: true},
                                    {text: 'Mito Sequence Number', value: 'mito_sequence_number', width: '6rem', visibility: true},
                                    {text: 'Measured', value: 'measured', width: '6rem', visibility: true},
                                    {text: 'Isotope Sampled', value: 'isotope_sampled', width: '6rem', visibility: true},
                                    {text: 'Clavicle Triage', value: 'clavicle_triage', width: '6rem', visibility: true},
                                    {text: 'CT Scanned', value: 'ct_scanned', width: '6rem', visibility: false},
                                    {text: 'Xray Scanned', value: 'xray_scanned', width: '6rem', visibility: false},
                                    {text: 'Inventoried', value: 'inventoried', width: '6rem', visibility: false},
                                    {text: 'Reviewed', value: 'reviewed', width: '6rem', visibility: false},
                                    {text: 'Inventoried At', value: 'inventoried_at', width: '6rem', visibility: false},
                                    {text: 'Reviewed At', value: 'reviewed_at', width: '6rem', visibility: false},
                                    {text: 'Created By', value: 'created_by', width: '6rem', visibility: false},
                                    {text: 'Created At', value: 'created_at', width: '6rem', visibility: false},
                                    {text: 'Updated By', value: 'updated_by', width: '6rem', visibility: false},
                                    {text: 'Updated At', value: 'updated_at', width: '6rem', visibility: false},
                                   ]"
    >

    </dashboardtable>
    <v-divider></v-divider>
</v-card>