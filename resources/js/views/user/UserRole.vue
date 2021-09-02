<template>
  <div class="content-wrapper">    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">User Role</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">
                  <i class="fa fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">User Role</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">      
      <error-modal modal-id="error" :error-list="errorList" />
      
      <loader :show="loading"></loader>

      <div class="d-flex mb-3">
        <div class="p-2 bg-lightpurple">
          <form>
            <div class="form-group">
              <label for="phone" class="control-label">Mobile No.</label>
              <div class="input-group">
                <span class="input-group-prepend">
                  <div class="input-group-text bg-white">
                    <i class="fas fa-mobile-alt"></i>
                  </div>
                </span>
                <input id="phone" type="text" class="form-control border-left-0" name="phone" v-model.lazy="userInfo.phone"
                  placeholder="Enter mobile number here" 
                >
              </div>              
              <span class="text-mute text-danger" v-if="userInfo.hasOwnProperty('error')" v-text="userInfo.error"></span>
              </div>
          </form>
        </div>
        <div class="p-2 bg-app-purple flex-fill">
          <div v-if="userExist">            
            <h4>User Information</h4>
            <ul>
              <li> Name: {{userInfo.name}}</li>
              <li> Email: {{userInfo.email}}</li>
              <li> Role: {{userInfo.role}}</li>
            </ul>
          </div>

          <div v-else>            
            <h4>User Doesn't Exist</h4>
          </div>

        </div>        
      </div>
    </section>
  </div>      
</template>
<script>

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
          bus: {}, 
          loading: false,                   
          showAlert: false,
          show: false,                    
          departureCity: '',
          disableSorting: true,
          errorList: [],
          instanceOfScrollbar: undefined,
          schedules: [],
          phone: '',
          userExist: '',
          userInfo: {
            id: '',
            name: '',
            phone: '',
            email:'',
            error: '',
            role: '',
          },
      }
    },
    async mounted() {
        this.loading = true;
        // await this.getRoutes();
        // await this.getBuses();
        // await this.getSchedules();
        // await this.getAvailableCities();
        this.loading = false;

        // if (this.any(this.errors)) {
        //   this.setListOf(this.errors, this.errorList)
        // }
        // this.enableScroll();
        // this.objectToEmptyString();
    },      
    watch: {        
      'userInfo.phone'(value, oldValue) {
        console.log('phn', value)
        if (value) {          
          this.getUserInfoIfExist(value);
        }
       },                  
    },            
    computed: {
        ...mapState([
            'errors',
            'success'
        ]),
        ...mapGetters([
            'get',
            'has',  
            'any'                      
        ]),
    },
    methods: {  
      ...mapActions([
          'setSuccess',
          'resetErrors'
      ]),
      actionAlert() {
        swal({           
          title: 'Schedules for the BUS',
          text: 'Added successfully!',
          icon: "success",
          timer: 2000,
          closeOnClickOutside: false,
        })
      },          
      getUserInfoIfExist(phone) {
        if (phone.length < 11) {
          this.userInfo.error = 'Phone number not given or Invalid number';
          this.resetUserInfo();
          return;
        }
        this.loading = true;          
        this.userInfo.error = ''; 
        this.resetUserInfo();
        var vm = this;                
        axios.get(`/users/${phone}`)
            .then(function (response) {                  
              response.data.error ? vm.error = response.data.error : vm.userInfo = response.data;
              if( !vm.isEmpty(vm.userInfo) ){                  
                vm.userExist = true;
                vm.userInfo.error = '';
                // vm.fillupUserForm(vm.userInfo);
                //console.log('not empty');                 
              }       
              vm.loading = false;
        });
      },
      isEmpty(obj) {
        //console.log('lenn='+ Object.values(obj).length);
        //return Object.keys(obj).length === 0;
        return Object.values(obj).length <= 1;
      },
      resetUserInfo() {
        this.userExist = false;
        this.userInfo.name = '';
        this.userInfo.email = '';
        this.userInfo.id = '';
        this.userInfo.role = '';
      },  
    },
}
</script>
<style lang="scss" scoped>    
  .fa-stack { font-size: 4.5em; }
  .table thead th {
    border-bottom: 1px solid hsl(188, 78%, 41%);
  }
</style>