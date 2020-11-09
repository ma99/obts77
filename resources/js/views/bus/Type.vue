<template>
  <div class="content-wrapper">    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bus Type</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">
                  <i class="fas fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">Bus Type</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content pb-2">      
      <div class="container-fluid">

        <show-alert :show.sync="showAlert" :type="alertType"> 
              <!-- altert type can be success/info/warning/danger/dark -->
          <strong> Bus </strong> has been <strong>{{ actionStatus }} </strong>
        </show-alert>

        <div class="d-md-flex align-items-center mb-3 shadow">
              <div class="p-3 align-self-stretch bg-lightyellow">

                <div class="card card-outline card-info">
                  <div class="card-header">
                    Add New Bus Type
                  </div>
                  <div class="card-body">
                    <form>
                      <div class="form-row ml-3 justify-content-center">
                        <div class="form-group col-md-10">
                          <label for="inputTypeName">Type</label>
                          <input v-model="type.name" type="text" class="form-control" v-bind:class="{ 'is-invalid': has('name') }" id="inputTypeName" placeholder="Bus Type">                          
                          <span class="invalid-feedback" v-if="has('name')" v-text="get('name')"></span>
                          
                          <small v-show="!has('name')" class="form-text text-muted mt-2">For combined bus type, use '|'. i,e. AC|Deluxe</small>
                        </div>                        
                        <div class="form-group col-md-10">
                          <label for="inputTypeKey">Key</label>
                          <input v-model="type.key" type="text" class="form-control" id="inputTypeKey" placeholder="Bus Type Key" readonly>
                        </div>                        
                      </div>
                    </form>
                  </div>
                  <div class="card-footer text-center">
                     <div class="button-group">
                      <button @click.prevent="save()" class="btn btn-primary mr-2" :disabled="!isValid"> <i class="far fa-save mr-2"></i>
                      Save
                    </button>
                      <button @click.prevent="reset()" class="btn btn-warning" :disabled="!isValid"><i class="far fa-window-close mr-2"></i>

                      Cancel</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="p-3 align-self-stretch bg-oceanblue flex-fill">
            
                <div v-if="!typesAvailable" class="text-center mt-2">
                  <span class="fa-stack">
                    <i class="fas fa-circle fa-stack-2x" style="color: #228be6"></i>
                    <i class="fas fa-layer-group fa-stack-1x" style="color: #74C0FC"></i>
                  </span>         
                </div>                

                <div class="text-info text-center h4 mt-3" v-show="has('type')">
                  <i class="fas fa-info-circle text-primary"></i>
                  {{ get('type') }}
                </div>              

                <div v-show="typesAvailable" class="card card-outline card-primary">
                  <div class="card-header">
                    Available Bus Types                    
                    <span class="float-right">
                      <high-light 
                        color="hsla(208, 77%, 43%, 1)" 
                        value="5"
                        :shadow="true"
                      >
                        {{types.length}}
                      </high-light>
                    </span>
                  </div>
                  <div class="card-body p-0">
                    <div class="scrollbar">
                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>SL.# </th>
                            <th>TYPE NAME</th>
                            <th>TYPE KEY</th>
                            <th>ACTION</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(type, index) in types" >                              
                              <td>{{ index+1 }} </td>                      
                              <td> {{ type.name }} </td>
                              
                              <td>{{ type.key }}</td>
                              <td>                          
                                  <button v-on:click.prevent="remove(type)" class="btn btn-outline-danger">
                                    <i class="button-icon far fa-trash-alt"></i>Remove
                                  </button> 
                              </td>                        
                            </tr>                            
                        </tbody>
                      </table>      
                    </div>
                  </div>     
                  <div class="card-footer">
                    <h5 class="px-1"> 
                      {{ types.length }} 
                      <small class="text-muted"> types available.</small>
                    </h5>          
                  </div>                 
                </div>

              </div>
          </div>

        <error-modal modal-id="error" :error-list="errorList" />
        
        <loader :show="loading"></loader>

      </div>
    </section>        
  </div>      
</template>
<script>
    // import Modal from '../../components/AppModal'; 
import ErrorModal from '../../components/ErrorModal'; 
import { mapState, mapGetters, mapActions } from 'vuex';

export default {        
    components: {
        'error-modal': ErrorModal,
    },
    data() {
      return {
        actionStatus: '',
        alertType: '',
        errorList: [],
        loading: false,
        showAlert: false,
        type: {
          name: '',
          key: ''
        },
        instanceOfScrollbar: undefined,
      }
    },
    watch: {
      'type.name'(value) {
        const str = this.removeSpaces(value);
        this.type.key = str.toLowerCase();
        if (value == '') {          
          this.clearError('name');
        }
      },
      success() {
          if (this.success) {
              this.actionAlert();
              this.reset();
              // this.resetErrors();
              this.setSuccess({ status: false });
              this.actionStatus = 'Added';
              this.alertType = 'success';
              // this.showAlert = true; 
          }
      }
    },    
    beforeUnmount() {
        this.instanceOfScrollbar.destroy();
        if (this.any(this.errors)) {
          this.resetErrors();
        }
    },
    async mounted() {
      this.loading = true;
      await this.getBusTypes();
      this.loading = false;

      if (this.any(this.errors)) {
        this.setListOf(this.errors, this.errorList)
      }

      this.enableScrollbar();
    },    
    computed: {
      ...mapState([
          'errors',
          'success'
      ]),
      ...mapGetters([
        'has',
        'get',
        'any'
      ]),                    
      ...mapState('type', [
        'types'
      ]),
      typesAvailable() {
        if (this.types.length > 0) {
          return true;
        }
        return false;
        // return 
        //   (this.types.length > 0) ? true : false
      },

      isValid() {
        return this.type.name != '' &&
              !this.has('name')
      }     
      
    },
    methods: {
      ...mapActions([
        'resetErrors',
        'setSuccess'
      ]),
      ...mapActions('type', [
        'addType',
        'deleteType',
        'getBusTypes'
      ]),

      clearError(field) {
        if (this.has(field)) {
          this.resetErrors(field);
        }      
      },
      enableScrollbar() {
        this.instanceOfScrollbar = OverlayScrollbars(document.getElementsByClassName("scrollbar"),
          { /* your options */ 
            className: "os-theme-dark",
            sizeAutoCapable: true,
            scrollbars: {
              autoHide: "never",
              clickScrolling: true
            } 
          })
      },
      actionAlert(name) {
          swal({           
            title: name,
            text: 'Added successfully!',
            icon: "success",
            timer: 2000,
            closeOnClickOutside: false,
          });
      },
      async save() {
        this.loading = true;
        await this.addType(this.type);
        this.loading = false;      
      },
      remove(type) { 
          var vm = this;
          swal({
            title: "Are you sure?",
            text: "This Bus Type will be Removed!",
            icon: "error",                 
            dangerMode: true,
            buttons: {
                cancel: "cancel",
                confirm: {
                  text: "Remove It!",
                  value: true,
                },                                
            },
          })
          .then(async (value) => {
            if (value) {

              vm.loading = true;
              // vm.response = '';
              vm.showAlert = false;

              await vm.deleteType(type.id);

              vm.actionStatus = 'Removed';
              vm.alertType = 'danger';
              vm.loading = false;
              vm.showAlert= true;                    
            }                   
          }); 
      },
      removeSpaces(str) {
        return str.replace(/\s/g, '');
      },
      reset() {
        this.type = {
          name: '',
          key: ''
        };
        this.resetErrors();
      },      
      setListOf(errors, list) {                    
        Object.keys(errors).forEach(key => {
          list.push({
            key: key.toUpperCase(),
            value: errors[key][0]
          })
        });
        this.showTheModal('error');                   
      },
      showTheModal(modalId) {                    
        $(`#${modalId}`).modal({
          backdrop: 'static'
        })
      },
    },
}
</script>           
<style lang="scss" scoped>    
  .fa-stack { font-size: 4.5em; }
</style>