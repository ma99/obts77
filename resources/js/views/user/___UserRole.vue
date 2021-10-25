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
      <loader :show="loading"></loader>

      <div class="d-flex mb-3">
        <div class="p-2 bg-lightpurple rounded-left">
          <form @submit.prevent="getUserInfoIfExist(userInfo.phone)">
            <div class="form-group">
              <label for="phone" class="control-label">Mobile No.</label>
              <div class="input-group">
                <span class="input-group-prepend">
                  <div class="input-group-text bg-white">
                    <i class="fas fa-mobile-alt text-info"></i>
                  </div>
                </span>
                <input id="phone" type="text" class="form-control border-left-0" name="phone" 
                  v-model="userInfo.phone"                  
                  placeholder="Enter mobile number here"
                  aria-label="Recipient's username" 
                  aria-describedby="basic-addon2" 
                >
                <!-- <div class="input-group-append">
                  <span class="input-group-text" id="basic-addon2"
                  >
                  <i class="fas fa-search"></i>                    
                  </span>
                </div> -->
              </div>              
              <span class="text-mute text-danger" v-if="userInfo.hasOwnProperty('error')" v-text="userInfo.error"></span>
            </div>
          </form>
        </div>
        <div class="p-2 bg-app-purple flex-fill rounded-right">
          <div v-if="userExist" class="ml-2 mt-2">                         
            <h4><i class="fas fa-user-check fa-2x text-info mr-2"></i>User Information</h4>
            <ul class="list-unstyled">
              <li><i class="far fa-check-square text-info"></i> Name: {{userInfo.name}}</li>
              <li v-if="userInfo.email"> <i class="far fa-check-square text-info"></i> 
              Email: {{userInfo.email}}</li>
              <li v-else> <i class="far fa-square text-info"></i>
              Email: </li>
              <li v-if="userInfo.role"><i class="far fa-check-square text-info"></i> Role: {{userInfo.role}}</li>
              <li v-else> <i class="far fa-square text-info"></i> Role: </li>
            </ul>
          </div>

          <div v-else class="ml-2 mt-2">            
            <h4 v-show="showUserNotExistText">
              <i class="fas fa-user-times fa-2x text-danger mr-2"></i>              
              User Doesn't Exist!
            </h4>
          </div>

        </div>        
      </div>

      <!-- manage -->
       <div class="card">
        <div class="card-header text-info">
          <h5>Manage</h5>
        </div>
        <div class="card-body bg-lightyellow">
          <form>
            <div class="row justify-content-center px-3">
              <div class="col-md bg-lightcyan mb-2 px-0 rounded mr-2">                
                <div class="bg-cyan p-2 rounded-top">
                  <h4>Role Name</h4>
                </div>
                <div class="row p-3">
                  <div class="col-md">
                    <div class="custom-control custom-radio">
                      <input type="radio" id="customRadio1" class="custom-control-input" value="admin" v-model="rolePicked">
                      <label class="custom-control-label" for="customRadio1">Administrator</label>
                    </div>                    
                  </div>
                  <div class="col-md">
                    <div class="custom-control custom-radio">
                      <input type="radio" id="customRadio2" class="custom-control-input" value="operator" v-model="rolePicked">
                      <label class="custom-control-label" for="customRadio2">Operator</label>
                    </div>
                  </div>                                
                </div>            
              </div>

              <div class="col-md bg-lightlemonyellow mb-2 px-0 rounded">
                <div class="bg-mediumlemonyellow p-2 rounded-top">
                  <h4>Action</h4>
                </div>
                <div class="row p-3">
                  <div class="col-md">
                    <div class="custom-control custom-radio">
                      <input type="radio" id="actionRadio1" class="custom-control-input" value="assign" v-model="actionPicked" :disabled="!isValidAssign">
                      <label class="custom-control-label" for="actionRadio1">Assign</label>
                    </div>                    
                  </div>
                  <div class="col-md">
                    <div class="custom-control custom-radio">
                      <input type="radio" id="actionRadio2" class="custom-control-input" value="revoke" v-model="actionPicked" :disabled="!isValidRevoke">
                      <label class="custom-control-label" for="actionRadio2">Revoke</label>
                    </div>                    
                  </div>              
                </div>            
              </div>    

              <div class="col-12 text-center mt-4 mb-2">
                <div class="button-group">
                  <button @click.prevent="submit()" class="btn btn-primary mr-2 px-5" :disabled="!isValid"> <i class="far fa-save mr-2"></i>
                  Submit
                </button>
                  <button @click.prevent="reset()" class="btn btn-warning" :disabled="!isValid"><i class="far fa-window-close mr-2"></i>
                  Cancel</button>
                </div>
              </div>
            </div>            
          </form>
        </div>
      </div>
      <!-- /end -->
    </section>
  </div>      
</template>
<script>

export default {      
    data() {
      return {                              
          loading: false,                   
          showAlert: false,
          show: false,                    
          message: null,
          role: null,
          roles: [],
          rolePicked: null,
          actionPicked: null,
          searchDisabled: true,
          showUserNotExistText: false,
          userExist: '',
          userInfo: {
            id: '',
            name: '',
            phone: '',
            email:'',
            error: '',
            role: null,
          },
      }
    },
    mounted() {
        // this.loading = true;        
        // this.loading = false;
        //this.getUserRoles();
    },      
    watch: {        
      'userInfo.phone'(value, oldValue) {
        if (value) { 
          this.validate(value) ? this.getUserInfoIfExist(value) : '' ;
        }
       },                  
       'userInfo.role'(value) {          
         if(value) {          
          this.rolePicked = value;
         }
       },
    },            
    computed: {     
      isValid() {
        return this.rolePicked != null &&
              this.actionPicked != null &&              
              this.userExist == true 
      },
      isValidAssign() {
        if (this.userInfo.role) {
          if (this.userRoleIs(this.userInfo.role, 'super_admin')) {
             return this.inValidAction();
          }
          if (this.userInfo.role != this.rolePicked ) {
            return true;
          }
        } else {          
          if (this.userExist && this.rolePicked != null) {
            return true; 
          }
        }          
        return this.inValidAction();
      },      
      isValidRevoke() {
        if (this.userInfo.role) {
          if (this.userRoleIs(this.userInfo.role, 'super_admin')) {
               return this.inValidAction();
          }
          if (this.userInfo.role == this.rolePicked) {
            return  true;
          }
        }        
        return this.inValidAction();
      }       
    },
    methods: {        
      actionAlert(icon, message) {
        swal({           
          title: `Role [${this.role}] for the User ${this.userInfo.name}`,
          text: `Successfuly ${message}`,
          icon: icon,
          timer: 3000,
          closeOnClickOutside: false,
        })
      },
      userRoleIs(role, superAdmin) {
        if (role == superAdmin) {
          return true;
        }
        return false;
      },
      inValidAction() {
        this.actionPicked = null;
        return  false;
      },         
      validate(phone) {
        if (phone.length < 11 || phone.length > 11 ) {
          this.userInfo.error = 'Phone number not given or Invalid number';
          this.resetUserInfo();
          this.showUserNotExistText = false;
          return false;
        }
        return true;
      },       
      getUserInfoIfExist(phone) {        
        this.loading = true;          
        this.userInfo.error = ''; 
        this.resetUserInfo();
        var vm = this;                
        axios.get(`/users/${phone}`)
            .then(function (response) {                  
              response.data.error ? vm.error = response.data.error : vm.userInfo = response.data;
              if( !vm.isEmpty(vm.userInfo) ){                  
                vm.userExist = true;
              }
              vm.showUserNotExistText = true;
              vm.resetRoleAndAction();       
              vm.loading = false;
        });
      },
      isEmpty(obj) {
        console.log('lenn='+ Object.values(obj).length);
        return Object.values(obj).length <= 1;
      },
      resetUserInfo() {
        this.userExist = false;
        this.userInfo.name = '';
        this.userInfo.email = '';
        this.userInfo.id = '';
        this.userInfo.role = '';
      },  
      resetRoleAndAction() {
        console.log('reset role & action called')
        this.rolePicked = null;
        this.actionPicked = null;
      },
      async submit() {
        this.loading = true;                  
        var vm = this;
        await axios.post(`/users/role/${this.actionPicked}`, {
          role: this.rolePicked,
          phone: this.userInfo.phone
        })
        .then(function (response) {                  
          response.data.error ? vm.error = response.data.error : vm.message = response.data.message;
          if (vm.message) {
            vm.callToAction(vm.message)
          }          
          vm.loading = false;
        });
        this.callAlert(this.message);
      },
      callToAction(status) {        
        if (status === 'Assigned') {
          this.userInfo.role = this.rolePicked;
          this.setRoleForActionAlert(this.rolePicked);
          this.actionPicked = null;
          return;
        }
        this.setUserRoleToNull();
      },      
      callAlert(message) {
        if (this.error) {
          this.actionAlert('warning', 'Something went wrong!');
          return;
        }        
        let icon = (message =='Assigned') ? 'success' : 'info';
        this.actionAlert(icon, message);

      },
      setUserRoleToNull() {
        this.setRoleForActionAlert(this.rolePicked);
        this.rolePicked = null;
        this.userInfo.role = null;
      },
      setRoleForActionAlert(role) {
        this.role = role;
      },
      reset() {
        this.rolePicked = null;
        this.userInfo.role = null;
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