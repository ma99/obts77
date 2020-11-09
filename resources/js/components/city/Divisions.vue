<template>
    <div class="form-group">
      <label :for="id">Division</label>      
      <select 
        class="form-control custom-select" :id="id"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
      >
          <option value="" :disabled="disable">Please select one</option>         
          <option v-for="division in divisionListByName" v-bind:value="division.id">
            {{ division.name }}
          </option>                             
      </select>
    </div>
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    
    export default {
        props: ['modelValue', 'id'],                
        data() {
            return {
                disable: false 
            }
        },
        async mounted() {
          await this.getDivisions();           
          this.disable = true;
        },        
        computed: {                   
            ...mapState('city', [
              'divisionList',              
            ]),
            ...mapGetters('city', [
              'divisionListByName'
            ]),
        },

        methods: { 
            ...mapActions('city', [
                'getDivisions',
            ]),
        },
    }
</script>
