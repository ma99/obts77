<template>
    <div v-show="show" class="alert-style"
      v-bind:class="{                        
          'alert alert-dark': (alertType == 'dark') ? true : false,          
          'alert alert-danger': (alertType == 'danger') ? true : false,          
          'alert alert-info': (alertType == 'info') ? true : false,          
          'alert alert-success': (alertType == 'success') ? true : false,          
          'alert alert-warning': (alertType == 'warning') ? true : false,          
       }" 
       id="status-alert"
       role="alert"
    >
      <button  v-on:click="close()" type="button" class="close"  aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>

      <div class="mx-1 my-1 my-sm-2 text-center">
       <slot></slot>        
      </div>
    </div>
</template>

<script>
    export default {      
      props: ['show', 'type'],      
      data() {
        return {
          alertType: '',
        }
      },

      methods: {
        showAlert() {
          $("#status-alert").alert();
          $("#status-alert").fadeTo(7000, 500)
          .slideUp(500, function(){
              $("#status-alert").slideUp(500);
          }); 
        },        
        close() {
          // this.$emit('update:show', false);          
          this.$emit('close', false);          
        },
      },
      mounted() {
          console.log('show alert Component mounted.');
          //this.alertTypeSelection;
          this.alertType = this.type;
      },
      watch: {
        show() {            
            this.showAlert();
            setTimeout(this.close, 7000); // 5s                               
        },
        type() {
          this.alertType = this.type;          
        }
      }        
    }
</script>
<style lang="scss" scoped>
  .alert-style {
    font-size: 1rem;
    padding: 0.625rem;  
  }
</style>