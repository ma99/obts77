<template>
     <div class="form-group">
      <label :for="id">Route</label>              
        <select
            :id="id" 
            class="form-control custom-select" 
            :value="modelValue"
            @input="$emit('update:modelValue', $event.target.value)"
        >
            <option value="" :disabled="disable">Please select one</option>         
            <option v-for="route in availableRouteList" v-bind:value="
                route.id"             
            >
              {{ route.id }}  {{ route.first_city }} 
              - {{ route.second_city }} 
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
            await this.getRoutes();
            this.disable = true;
        },        
        computed: {                   
            ...mapState('route', [
              'availableRouteList',              
            ]),
        },

        methods: { 
            ...mapActions('route', [
                'getRoutes',
            ]),            
        },
    }
</script>
