<template>
      <section class="content">
        <error-modal modal-id="error" :error-list="errorList" />
        <!-- <div class="container-fluid"> -->
          <!-- <div class="row"> -->
            <!-- Here goes page content -->
            <div class="p-2 bg-skyblue">
              <div class="p-1" @click="expand=!expand" style="cursor: pointer;">
                <span class="fa-stack fa-2x text-shadow" v-show="!expand">
                  <i class="fas fa-circle fa-stack-2x text-primary"></i>
                  <i class="far fa-edit fa-stack-1x fa-inverse" style="color: #74C0FC;"></i>
                </span>
                <span class="text-secondary h5" v-show="!expand">Add New Entry</span>
                <span class="float-right">
                  <transition name="fade" mode="out-in">
                    <span> 
                      <i v-show="!expand" class="far fa-plus-square"></i>
                      <i v-show="expand" class="far fa-minus-square"></i>
                    </span>
                  </transition>
                </span>
              </div>                

              <div class="mx-2 mt-4" v-show="expand">
                <div class="card">
                  <div class="card-body">
                  <form>
                    <div class="form-row">                          
                      <div class="form-group col-6">
                        <label for="user">User</label>
                        <select 
                          id="user"
                          v-model="driver.selectedUserId" 
                          class="form-control custom-select"
                        > 
                            <option value="" disabled>Please select one</option>
                            <option 
                              v-for="user in users"      
                              :value="user.id"        
                              v-text="user.name"
                              :disabled="isUserAvailableInDriverList(user)"
                              v-if="!optionByPhone"
                            >
                            </option>
                            <option 
                              v-for="user in users"      
                              :value="user.id"        
                              v-text="user.phone"
                              :disabled="isUserAvailableInDriverList(user)"
                              v-if="optionByPhone"
                            >
                            </option>                                  
                        </select>
                        <div class="custom-control custom-switch mt-2">
                          <input type="checkbox" class="custom-control-input" id="optionByPhoneSwitch" v-model="optionByPhone">
                          <label class="custom-control-label font-weight-normal" for="optionByPhoneSwitch">options by phone</label>
                        </div>                      
                      </div>    
                      <div class="form-group col-sm-6">
                        <label for="inputNid">NID</label>
                        <input id="inputNid" v-model="driver.nid" type="number" class="form-control" :class="{ 'is-invalid': has('nid') }">
                        <span class="invalid-feedback" v-if="has('nid')" v-text="get('nid')">
                        </span>
                      </div> 

                      <div class="form-group col-12">
                        <label for="inputAddress">Address</label>
                        <input type="text" class="form-control" id="inputAddress" placeholder="Write address here" v-model="driver.address">
                      </div>
                      <div class="col-12">
                        <label >NID Image</label> <br />
                        <small class="my-1 text-muted"> *Upload NID's front & back side images.</small>
                      </div>
                      <image-upload 
                        directory="nids" 
                        :saved="isImagesSaved"
                        @uploaded="handleUploaded"
                        @removed="handleRemoved" 
                      />                                   

                      <div class="form-group col-12">
                        <div class="text-center mt-2">
                          <div class="button-group">
                            <button @click.prevent="save()"  type="button" class="btn btn-primary mr-2 px-5" :disabled="!isValid">
                              <i class="far fa-save mr-2"></i>
                            Save
                            </button>                     
                            <button @click.prevent="reset()"  type="button" class="btn btn-warning">
                              <i class="far fa-window-close"></i>
                              Cancel
                            </button>
                          </div>
                        </div>
                      </div>  
                    </div>
                  </form>
                  </div>
                </div>
              </div>
            </div>

            <loader :show="loading"></loader>

            <error-modal btn-color="btn-warning" modal-id="error" :error-list="errorList" />

            <!-- Alert -->  
            <div class="my-2">        
              <alert :show="showAlert" :type="alertType" @close="showAlert=$event">
                <i class="fas fa-info-circle fa-2x text-warning mr-2"></i>
                <span class="h5">{{responseMessage}}</span>
              </alert>                        
            </div>         

            <div class="row justify-content-center my-3 p-2" v-if="availableDriverList.length > 0">
              <div class="card w-100">            
                <div class="card-body p-0">
                  <div class="scrollbar">
                  <table class="table table-striped table-hover">
                      <thead class="bg-secondary">
                        <tr>
                          <th>Sl. No.</th>
                          <th>Name</th>
                          <th>Contact</th>                           
                          <th>Address</th>                        
                          <th>NID #</th>
                          <th>Images</th>                        
                          <th>Action</th>    
                          <!-- <th>&nbsp;</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr  v-for="(driver, index) in availableDriverList">                              
                          <td>{{ index+1 }}</td>                              
                          <td>{{ driver.name }}</td>                        
                          <td>
                            <div class="border-bottom pb-1 mb-1"><!-- Phone:  <br /> -->
                              <i class="fas fa-phone-alt mr-1"></i>
                              {{ driver.phone }}
                            </div>
                            <!-- Email: <br /> -->
                            <i class="fas fa-at mr-1"></i>
                            {{ driver.email }}
                          </td>                        
                          <td>{{ driver.address }}</td>
                          <td> {{ driver.nid }} </td>                         
                          <td>
                            <div v-for="(image, index) in driver.images">
                              <span>{{image.title}}</span><br />
                              <a :href="url(image.path)" target="_blank" rel="noopener noreferrer">
                                <img :src="url(image.path)" width="60" height="60">
                              </a>
                            </div>                            
                          </td>
                          <td>                           
                            <div>                                
                              <button @click.prevent="remove(driver)" class="btn btn-outline-danger">
                                <i class="far fa-trash-alt mr-2"></i>Remove
                              </button> 
                            </div>
                          </td>                        
                        </tr>                            
                      </tbody>
                  </table>      
                  </div>
                </div>
            <!-- {{-- card-footer --}} -->
                <div class="card-footer">
                  <h5 class="px-1" v-if="availableDriverList.length > 1"> 
                    {{ availableDriverList.length }} 
                    <small class="text-muted"> drivers available.</small>
                  </h5>                                   
                  <h5 class="px-1" v-else> 
                    {{ availableDriverList.length }} 
                    <small class="text-muted"> driver available.</small>
                  </h5>                                   
                </div>
              </div>
            </div>
          <!-- </div> -->
          <!-- /.row -->
        <!-- </div>/.container-fluid -->
      </section>    
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    import Alert2 from '../../components/Alert2';  
    import ImageUpload from '../../components/ImageUpload';  
    import ErrorModal from '../../components/ErrorModal'; 

    export default {
        props: {
          token: String,
        },
        components: {
           alert: Alert2,
           'error-modal': ErrorModal,
        },
        data() {
            return {
              actionStatus: '',
              alertType: '',
              loading: false,                   
              driver: {
                selectedUserId: '',
                nid: '',
                address: ''
              },
              images:[],
              isImagesSaved: false,
              showAlert: false,
              show: false,  
              errorList: [], 
              expand: false,  
              responseMessage: '',
              instanceOfScrollbar: undefined,
              optionByPhone: false,
            }
        },        
        async mounted() {
            this.loading = true;
            await this.getUsers({token: this.token});
            await this.getDrivers({token: this.token});

            console.log('Driver Component mounted.')
            this.loading = false;
            if (this.any(this.errors)) {
              this.setListOf(this.errors, this.errorList)
            }
            this.enableScroll();
        },
        beforeUnmount() {
          if(this.instanceOfScrollbar) {            
            this.instanceOfScrollbar.destroy();
          }
          this.resetErrors();
        },
        watch: {
          optionByPhone(value) {
            if (value === true) {
              this.sortUsersByPhone();
              return;
            }
            this.sortUsersByName();
          },         
          success() {
            if (this.success) {
                this.loading = false;
                this.actionAlert();
                this.reset();
                this.isImagesSaved = true;
                this.setSuccess({ status: false });               
            }
          },
          deleted(value) {
            if( value === true ) {
              this.actionStatus = 'Removed';
              this.responseMessage = 'Driver Deleted Successfully.';
              this.alertType = 'danger';
              this.loading = false;
              this.showAlert= true;            
              this.setDeletedStatus({ status: false });  
            }
          },
          errors: {
             handler(value){
              this.loading = false
             },
             deep: true
          },
          'driver.nid'(value) {
            if(value === '') {
              this.resetErrors();
            }
          }
        },
        computed: {
          ...mapState([
              'errors',
              'success'
          ]),
          ...mapGetters([
            'any',
            'has',
            'get'
          ]),                    
          ...mapState('bus', [
            'users'
          ]),
          ...mapState('driver', [
            'availableDriverList',
            'deleted'
          ]),
          isValid() {
            return this.driver.selectedUserId != '' &&          
                   this.driver.nid != '' &&
                   this.driver.address != '';
          },          
        },

        methods: {
            ...mapActions([
                'resetErrors',
                'setSuccess'
            ]),
            ...mapActions('bus', [                
                'getUsers',   
                'sortUsersByName',
                'sortUsersByPhone'
            ]),          
            ...mapActions('driver', [                
                'getDrivers',                   
                'addDriver',
                'deleteDriver',
                'setDeletedStatus'
            ]),          

            actionAlert() {
                swal({           
                  title: 'Driver',
                  text: 'Added successfully!',
                  icon: "success",
                  timer: 2000,
                  closeOnClickOutside: false,
                });
            },
            enableScroll() {
              this.instanceOfScrollbar = OverlayScrollbars(document.getElementsByClassName("scrollbar"),
              { 
                className: "os-theme-dark",
                sizeAutoCapable: true,
                scrollbars: {
                  autoHide: "never",
                  clickScrolling: true
                } 
              })
            },
            isUserAvailableInDriverList(user) {
              const found = this.availableDriverList.find(element => element.user_id === user.id);

              if(found) {
                return true;
              }
              return false;
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
            url(path) {              
              return `/storage/${path}`;
            },

            handleUploaded(image) {             
              this.images.push(image);
            },
            handleRemoved(image) {
              let index = this.images.indexOf(image);
              this.images.splice(index, 1);
            },                      
            save() {
              this.loading = true;   
              this.isImagesSaved = false;           
              this.addDriver({
                driver: this.driver,
                images: this.images
              });
            },            
            remove(driver) { 
              var vm = this;
              swal({
                title: "Are you sure?",
                text: `${driver.name} will be Removed!`,
                icon: "error",                 
                dangerMode: true,
                buttons: {
                    cancel: "cancel",
                    confirm: {
                      text: "Remove",
                      value: true,
                    },                                
                },
              })
              .then(async (value) => {
                if (value) {

                  vm.loading = true;
                  vm.showAlert = false;
                  await vm.deleteDriver({driver: driver});
                }                   
              }); 
            },
            reset() { 
              this.driver = {
                selectedUserId: '',
                nid: '',
                address: ''
              }
              this.images = [];
              this.resetErrors();                
            }           
        },
    }
</script>
<style lang="scss" scoped>
  img {
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 5px;
  }
  img:hover {
    box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
  }
</style>