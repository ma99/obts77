<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Slide</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link to="/dashboard">
                    <i class="fas fa-dashboard nav-icon"></i>Dashboard
                  </router-link>
                </li>
                <li class="breadcrumb-item active">Slide</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <error-modal modal-id="error" :error-list="errorList" />        
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
                      <div class="h4 mb-2 col-12 text-primary">Upload Image For Slider</div>

                      <image-upload 
                        directory="slider/images" 
                        :saved="isImagesSaved"
                        :maxNumberOfImages= "1"
                        @uploaded="handleUploaded"
                        @removed="handleRemoved" 
                      />                                   

                      <div class="form-group col-12">
                        <div class="custom-control custom-checkbox">
                          <input type="checkbox" class="custom-control-input" id="customCheck1" v-model="slide.activate">
                          <label class="custom-control-label" for="customCheck1">Activate the Slide</label>
                        </div>
                      </div>

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

            <div class="row justify-content-center my-3 p-2" v-if="availableSlideList.length > 0">
              <div class="card w-100">            
                <div class="card-body p-0">
                  <div class="scrollbar">
                  <table class="table table-striped table-hover">
                      <thead class="bg-secondary">
                        <tr>
                          <th>Sl. No.</th>
                          <th>ID</th>
                          <th>Title</th>
                          <th>Image</th>                        
                          <th>Active</th>
                          <th>Action</th>    
                        </tr>
                      </thead>
                      <tbody>
                        <tr  v-for="(slide, index) in availableSlideList">      
                          <td>{{ index+1 }}</td>       
                          <td>{{ slide.id }}</td>
                          <td>{{slide.image.title}}</td>
                          <td>                            
                              <a :href="url(slide.image.path)" target="_blank" rel="noopener noreferrer">
                                <img :src="url(slide.image.path)" width="60" height="60">
                              </a>
                          </td>
                          <td>
                              <div class="mb-2" :class="[slide.active == true ? 'text-primary': 'text-danger']">{{convertBooleanStatus(slide.active)}}</div>                              
                              <custom-checkbox 
                                :slide="slide" 
                                :index="index" 
                                @selected="handleSlideSelected" 
                              />
                          </td>                                                  
                          <td>                           
                            <div class="input-group">    
                              <button 
                                @click.prevent="update()" class="btn" 
                                :class="[isUpdateBtnDisabled(slide) ? 'btn-outline-primary' : 'btn-primary']"
                                :disabled="isUpdateBtnDisabled(slide)">
                                <i class="far fa-save mr-2"></i>Update
                              </button> 
                            </div>
                            <div>           
                              <button @click.prevent="remove(slide)" class="btn btn-outline-danger mt-2">
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
                  <h5 class="px-1" v-if="availableSlideList.length > 1"> 
                    {{ availableSlideList.length }} 
                    <small class="text-muted"> slides available.</small>
                  </h5>                                   
                  <h5 class="px-1" v-else> 
                    {{ availableSlideList.length }} 
                    <small class="text-muted"> slide available.</small>
                  </h5>                                   
                </div>
              </div>
            </div>
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';
    import Alert2 from '../../components/Alert2';  
    import ImageUpload from '../../components/ImageUpload';  
    import ErrorModal from '../../components/ErrorModal'; 
    import CustomCheckbox from '../../components/CustomCheckbox'; 

    export default {
        props: {
          token: String,
        },
        components: {
           alert: Alert2,
           'error-modal': ErrorModal,
           'custom-checkbox': CustomCheckbox,
        },
        data() {
            return {
              actionStatus: '',
              alertType: '',
              loading: false,                   
              slide: {
                activate: false,                
              },
              slideToUpdate: {
                id:'',
                active: '',
                image: '',
                index: ''
              },
              updateInitiated: false,
              images:[],
              isImagesSaved: false,
              showAlert: false,
              show: false,  
              errorList: [], 
              expand: false,  
              responseMessage: '',
              instanceOfScrollbar: undefined,
            }
        },        
        async mounted() {
            this.loading = true;
            await this.getSlides({token: this.token});
            console.log('Slide Component mounted.')
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
          success() {
            if (this.success) {
                this.loading = false;
                if(this.updateInitiated === true) {                  
                  this.actionAlert('info', 'Updated');
                  this.updateInitiated = false;
                } else {
                  this.actionAlert('success', 'Added');
                }
                this.reset();
                this.isImagesSaved = true;
                this.setSuccess({ status: false });
            }
          },
          deleted(value) {
            if( value === true ) {
              this.actionStatus = 'Removed';
              this.responseMessage = 'Slide Deleted Successfully.';
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
          ...mapState('slide', [
            'availableSlideList',
            'deleted'
          ]),
          isValid() {
            return this.images.length > 0;
          },          
        },

        methods: {
            ...mapActions([
                'resetErrors',
                'setSuccess'
            ]),                  
            ...mapActions('slide', [                
                'getSlides',                   
                'addSlide',
                'updateSlide',
                'deleteSlide',
                'setDeletedStatus'
            ]),
            actionAlert(icon, message) {
                swal({           
                  title: 'Slide',
                  text: `${message} successfully!`,
                  icon: icon,
                  timer: 2000,
                  closeOnClickOutside: false,
                });
            },
            isUpdateBtnDisabled(slide) {            
              return (this.slideToUpdate.id !== slide.id)  
                    ? true : false;
            },
            customCheck(index) {
                return `customCheckSlide_${index}`;
            },
            convertBooleanStatus(value) {
                return (value === true) ? 'YES' : 'NO';
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
            update() {
              if(this.slideToUpdate.id === '') {
                return
              };
              this.loading = true;
              this.updateInitiated = true;
              this.updateSlide({                
                slide: this.slideToUpdate, 
              });
            },
            isUserAvailableInSlideList(user) {
              const found = this.availableSlideList.find(element => element.user_id === user.id);

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
            handleSlideSelected(event) {
              if (event === null) {
                this.resetSlideToUpdate();                
                return;
              }              
              this.updateSlideToUpdateObjectWith(event);
            },
            updateSlideToUpdateObjectWith(data) {
              this.slideToUpdate = {
                id: data.id,
                active: data.active,
                image: data.image,
                index: data.index
              }
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
              this.addSlide({
                slide: this.slide,
                image: this.images
              });
            },            
            remove(slide) { 
              var vm = this;
              swal({
                title: "Are you sure?",
                text: `${slide.id} will be Removed!`,
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
                  await vm.deleteSlide(slide.id);
                }                   
              }); 
            },
            reset() { 
              this.slide = {
                activate: false
              }
              this.resetSlideToUpdate();
              this.images = [];
              this.resetErrors();                
            },
            resetSlideToUpdate() {
              this.slideToUpdate = {
                  id: '',
                  active: '',
                  image: '',
                  index: ''
                }
            },           
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