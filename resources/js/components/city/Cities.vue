<template>
    <div class="form-group">
        <label :for="id">City</label>                       
        <select 
            class="form-control custom-select" :id="id"
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        >            
            <option value="" :disabled="disable">Please select one</option>                          
            <option v-for="district in citiesByDivision(division)" v-bind:value="
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
        ],        
        
        data() {
            return {
                disable: false 
            }
        },

        async mounted() {
            await this.getBusAvailableToCities();
            this.disable = true;
        },

        computed: {                   
            ...mapGetters('city', [
                'citiesByDivision'
            ])            
        },

        methods: { 
            ...mapActions('city', [
                'getBusAvailableToCities'
            ]),            
        },
    }
</script>
