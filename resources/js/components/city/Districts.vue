<template>
    <div class="form-group">
        <label :for="id">District</label>                       
        <select 
            class="form-control custom-select" :id="id"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        >            
            <option value="" :disabled="disable">Please select one</option>                          
            <option v-for="district in districtsByDivision(division)" v-bind:value="
            district.id">
            {{ district.name }}
            </option> 
        </select>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    
    export default {
        props: [
            'modelValue',
            'division',
            'id',
            // 'list'  // 'all' will show districts( frombdistrictList[]) by division. any other text will show cities( from cityList[]) by division
        ],        
        
        data() {
            return {
                disable: false 
            }
        },

        async mounted() {
            await this.getDistricts();           
            // await this.getBusAvailableToCities();
            this.disable = true;
        },

        computed: {                   
            ...mapGetters('city', [
                'districtsByDivision'
            ])            
        },

        methods: { 
            ...mapActions('city', [
                'getDistricts',
                // 'getBusAvailableToCities'
            ]),            
        },
    }
</script>
