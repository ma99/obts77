<template>
  <app-modal :modal-id="modalId">
    <template v-slot:title>
      <i class="fas fa-bell bg-warning rounded-circle p-2"></i>
      <span class="pl-2 pr-1 text-danger"> {{ errorList.length }} </span> 
      <span v-show="errorList.length == 0 || errorList.length == 1"> Error! </span> 
      <span v-show="errorList.length > 1"> Errors! </span> 
    </template>

    <div class="d-sm-flex align-items-center mb-3 shadow">
      <div class="p-2 align-self-stretch bg-warning">              
        <div class="text-center mt-3">
          <span class="fa-stack">
            <i class="fas fa-circle fa-stack-2x text-danger"></i>
            <i class="fas fa-exclamation-triangle fa-stack-1x text-warning"></i>
          </span>         
        </div>  
      </div>

      <div class="p-2 align-self-stretch flex-grow-1 bg-lightyellow">
        <ul class="list">
          <li class="list-item"   
            v-for="(error, index) in errorList"
          >
            {{ index+1 }}. {{ error.key }} {{ error.value }}
          </li>
        </ul>
      </div>      
    </div>
  </app-modal>    
</template>

<script>
    import Modal from '../components/AppModal'; 
    export default {
        props: ['modal-id', 'error-list'],
        components: {
            'app-modal': Modal
        },        
    }
</script>
<style lang="scss" scoped>  
  .list {
    .list-item:first-child {
      border-top: none;
    }
    .list-item {
      border-top: 1px solid green;
      display: block;
      list-style: none;
      padding-top: 1rem;
      padding-bottom: 0.25rem;
    }
    .list-item:last-child {
      border-bottom: 1px solid green;
    }    
  }
  .fa-stack { 
    font-size: 2.5em; 
    height: 2.5em;
  }
  // i { vertical-align: middle; } 
</style>

