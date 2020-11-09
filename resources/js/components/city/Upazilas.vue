<template>    
    <div class="form-group">
        <label :for="id">Upazila</label>
        <select 
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
            class="form-control custom-select" :id="id"
        >
          <option value="" :disabled="disable">Please select one</option>                          
          <option v-for="upazila in upazilasByDistrict(district)" v-bind:value="upazila.name">
            {{ upazila.name }}
          </option> 
        </select>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex';
    
    export default {
        props: [
            'modelValue',
            'district',
            'id'
        ],        
        data() {
            return {
                disable: false 
            }
        },
        async mounted() {
            await this.getUpazilas();           
            this.disable = true;
        },
        computed: {                   
            ...mapGetters('city', [
                'upazilasByDistrict'
            ])            
        },
        methods: { 
            ...mapActions('city', [
                'getUpazilas',
            ]),
        },
    }
</script>
