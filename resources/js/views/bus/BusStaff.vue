<template>
    <section class="content">      
      <error-modal modal-id="error" :error-list="errorList" />
      
      <div class="d-md-flex">
        <div class="p-3 bg-aliceblue flex-fill">
          <form>
            <div class="form-group">
              <label for="bus">Bus</label>
              <select
              id="bus" 
              class="form-control custom-select"
              v-model="bus"
             >
              <option value="" disabled>Please select one</option>         
              <option v-for="bus in availableBusList" :value="
                  bus"             
              >
                {{ bus.bus.id }} 
              </option>                 
              </select>                      
            </div>
            <!-- v-show="bus" -->
            <div class="shadow p-3 mb-3 bg-white rounded text-muted">
              <div>
                Bus No.: <span class="text-secondary">{{ numberPlate }}</span>
              </div>
              <div class="mt-2">
                Route: <span class="text-secondary" v-html="routeName"></span>
              </div>

              <div class="mt-2">
                Seats: <span class="text-secondary">{{ totalSeats }}</span>
              </div>
            </div>            
          </form>          
        </div>
        <div class="p-3 bg-mayablue-medium flex-fill">            
          <div v-if="!staffAvailable" class="text-center mt-2">
            <span class="fa-stack text-shadow" style="font-size: 4.5em;">
              <i class="fas fa-circle fa-stack-2x" style="color: #228be6"></i>
              <i class="fas fa-users fa-stack-1x" style="color: #74C0FC"></i>
            </span>         
          </div>                
      
          <div v-show="staffAvailable" class="mt-1">
            <!-- <div class="p-0"> -->
              <div class="scrollbar">
                <div class="row justify-content-center">
                  <div class="col-10">
                    <p class="h4">DRIVER</p>
                    <div class="card">
                      <div class="card-body p-3"> 
                         <table class="table table-striped table-hover table-sm">
                          <thead class="bg-primary">
                            <tr>
                              <th class="rounded-top-left">SL.# </th>
                              <th>Id </th>
                              <th>Name</th>
                              <th>Phone</th>
                              <th class="rounded-top-right">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(driver, index) in staffByBus.drivers" >                              
                              <td>{{ index+1 }}</td>
                              <td>{{ driver.id }}</td>
                              <td>{{ driver.name }}</td>
                              <td>{{ driver.phone }}</td>
                              <td>                          
                                  <button v-on:click.prevent="remove(driver, 'driver')" class="btn btn-outline-danger">
                                    <i class="button-icon fas fa-trash"></i>Remove
                                  </button> 
                              </td>                        
                            </tr>                            
                          </tbody>
                        </table>      
                      </div>
                    </div>
                  </div>
                  <div class="col-10 mt-md-2">
                    <p class="h4">HELPER</p>
                    <div class="card">
                      <div class="card-body p-3"> 
                        <table class="table table-striped table-hover table-sm">
                          <thead class="bg-info">
                            <tr>
                              <th class="rounded-top-left">SL.# </th>
                              <th>Id </th>
                              <th>Name</th>
                              <th>Phone</th>
                              <th class="rounded-top-right">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(helper, index) in staffByBus.helpers" >                              
                              <td>{{ index+1 }}</td>
                              <td>{{ helper.id }}</td>
                              <td>{{ helper.name }}</td>
                              <td>{{ helper.phone }}</td>
                              <td>                          
                                  <button v-on:click.prevent="remove(helper, 'helper')" class="btn btn-outline-danger">
                                    <i class="button-icon fas fa-trash"></i>Remove
                                  </button> 
                              </td>                        
                            </tr>                            
                          </tbody>
                        </table>   
                      </div>
                    </div>    
                  </div>
                  <div class="col-10 mt-md-2">
                    <p class="h4">SUPERVISOR</p>
                    <div class="card">
                      <div class="card-body p-3"> 
                        <table class="table table-striped table-hover table-sm">
                          <thead class="bg-success">
                            <tr>
                              <th class="rounded-top-left">SL.# </th>
                              <th>Id </th>
                              <th>Name</th>
                              <th>Phone</th>
                              <th class="rounded-top-right">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="(supervisor, index) in staffByBus.supervisors" >                              
                              <td>{{ index+1 }}</td>
                              <td>{{ supervisor.id }}</td>
                              <td>{{ supervisor.name }}</td>
                              <td>{{ supervisor.phone }}</td>
                              <td>                          
                                  <button v-on:click.prevent="remove(supervisor, 'supervisor')" class="btn btn-outline-danger">
                                    <i class="button-icon fas fa-trash"></i>Remove
                                  </button> 
                              </td>                        
                            </tr>                            
                          </tbody>
                        </table>
                      </div>
                    </div>      
                  </div>
                </div>                        
              </div>
            <!-- </div>                                   -->
          </div>
        </div>        
      </div>

      <div class="my-3">        
        <alert :show="showAlert" :type="alertType" @close="showAlert=$event">
          <i class="fas fa-info-circle fa-2x text-warning mr-2"></i>
          <span class="h4">{{responseMessage}}</span>
        </alert>                        
      </div>

      <loader :show="loading"></loader>

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
                <div class="form-group col-sm-4">
                  <label for="driver">Driver</label>
                  <select 
                    id="driver"
                    v-model="selectedDriver" 
                    class="form-control custom-select"
                    :class="{ 'is-invalid': has('route-cities') }"
                  > 
                      <option value="" disabled>Please select one</option>
                      <option 
                        v-for="driver in availableDriverList"                            :value="driver.id"
                        :disabled="isAlreadyAddedThis(driver, staffByBus.drivers)"
                      >
                          {{ driver.name }}
                      </option>                                  
                  </select>                      
                </div>

                <div class="form-group col-sm-4">
                  <label for="helper">Helper</label>
                  <select 
                    id="helper" 
                    v-model="selectedHelper" 
                    class="form-control custom-select"
                    :class="{ 'is-invalid': has('route-cities') }"
                  > 
                      <option value="" disabled>Please select one</option>
                      <option 
                        v-for="helper in availableHelperList"                           :value="helper.id"
                        :disabled="isAlreadyAddedThis(helper, staffByBus.helpers)"
                      >
                          {{ helper.name }}
                      </option>
                  </select>
                </div>

                <div class="form-group col-sm-4">
                  <label for="supervisor">Supervisor</label>
                  <select 
                      id="supervisor" 
                      v-model="selectedSupervisor" 
                      class="form-control custom-select"
                      :class="{ 'is-invalid': has('route-cities') }"
                  > 
                      <option value="" disabled>Please select one</option>
                      <option 
                        v-for="supervisor in availableSupervisorList"
                        :value="supervisor.id"
                        :disabled="isAlreadyAddedThis(supervisor, staffByBus.supervisors)"
                      >
                          {{ supervisor.name }}
                      </option>                 
                  </select>
                </div>

                <div class="form-group col-12">
                  <div v-show="show" class="alert alert-warning" role="alert">
                      <h4 class="alert-heading">
                        <i class="fas fa-exclamation-triangle text-red"></i>
                        <button type="button" class="close" aria-label="Close">
                          <span aria-hidden="true" v-on:click.prevent="show = false">&times;</span>
                        </button>
                      </h4>                
                      <span v-show="false"> {{ showError }}</span>
                    {{ get('bus_id') }}
                  </div>
                </div>

                <div class="form-group col-12">
                  <div class="text-center mt-2">
                    <div class="button-group">
                      <button @click.prevent="save()"  type="button" class="btn btn-primary mr-2 px-5" :disabled="!isValid">
                        <i class="far fa-save mr-2"></i>
                      Save
                      </button>                     
                      <button @click.prevent="reset('all')"  type="button" class="btn btn-warning">
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
    </section>
</template>
<script>

import ErrorModal from '../../components/ErrorModal'; 

import { mapState, mapGetters, mapActions } from 'vuex';

import Alert2 from '../../components/Alert2';  

export default {  
    props: {
        token: String,
    },
    components: {
      'error-modal': ErrorModal,
       alert: Alert2
    },      
    data() {
      return {                    
          actionStatus: '',
          alertType: '',
          bus: {}, 
          loading: false,                   
          showAlert: false,
          show: false,                    
          selectedDriver: '',
          selectedHelper: '',
          selectedSupervisor: '',
          disableSorting: true,
          errorList: [],
          expand: false,
          instanceOfScrollbar: undefined,
          responseMessage: '',
          // schedules: [],
      }
    },
    mounted() {
        this.loading = true;
        this.getRoutes();
        this.getBuses({token: this.token});
        this.getDrivers({token: this.token});
        this.getHelpers({token: this.token});
        this.getSupervisors({token: this.token});
        this.loading = false;

        if (this.any(this.errors)) {
          this.setListOf(this.errors, this.errorList)
        }
        // this.enableScroll();
        this.objectToEmptyString();
    },  
    beforeUnmount() {
        // this.instanceOfScrollbar.destroy();
        $().alert('dispose'); 
        this.resetErrors();        
        this.emptyStaffByBus();
        // this.emptyCitiesByRoute();                    
    },
    watch: {                    
      async 'bus.bus.id'(val, oldVal) {

          if (this.isEmpty(this.bus)) return;
          this.loading = true;
          this.resetErrors();
          this.emptyStaffByBus();
          // this.emptyCitiesByRoute();
          // this.departureCity = '';

          // await this.getCitiesFromRoutesBy(
          //   this.bus.bus.route_id);

          // this.getRouteCityList();          
          
          this.disableSorting = true;
          // await this.getStaffByBus(val);
          await this.getStaffByBus({ 
            id: val,
            token: this.token
          });
          this.loading = false;

        },
        success() {
            if (this.success) {
                this.loading = false;
                this.actionAlert();
                this.reset();
                // this.resetErrors();
                this.setSuccess({ status: false });
                // this.actionStatus = 'Added';
                // this.alertType = 'success';
                // this.showAlert = true; 
            }
        },
        errors: {
           handler(value){
            this.loading = false
           },
           deep: true
        }
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
      
        ...mapState('bus', [
            'availableBusList',
            'staffByBus',
            // 'staffByBus'
        ]),
        ...mapState('schedule', [
          'availableScheduleList',
        ]),
        ...mapState('driver', [
          'availableDriverList',
        ]),
        ...mapState('helper', [
          'availableHelperList',
        ]),
        ...mapState('supervisor', [
          'availableSupervisorList',
        ]),

        // ...mapState('route', [
        //   'routeCityList'
        // ]),
        ...mapGetters('route', [
            'getRouteBy',
            //'routeCityList'
        ]),

      ...mapGetters('city', [
          'getCityById',
      ]),

      showError() {
        if (this.has('bus_id')) return this.show = true;
        return this.show = false;
      },
      staffAvailable() {
          // if (this.staffByBus.length > 0) {
          //  return true;
          // }
          // return false;
          return this.isEmpty(this.staffByBus) ? false : true;         
      },

      numberPlate() {
        if (this.isEmpty(this.bus)) return;
        return this.bus.bus.number_plate;                    
      },

      routeName() {                    
        if (this.isEmpty(this.bus)) return;

        let route = this.getRouteBy(this.bus.bus.route_id);

        return `${route.first_city}  <i class="fas fa-exchange-alt"></i> ${route.second_city}`;
      },

      totalSeats() {
        if (this.isEmpty(this.bus)) return;
        
         return this.bus.total_seats;
      },

      isValid() {
            return this.bus.id != '' && 
                    this.selectedDriver != '' ||
                    this.selectedHelper != '' ||
                    this.selectedSupervisor != ''
                    // &&
                    // this.schedules.length > 0
         }
    },
    methods: {  
        ...mapActions([
            'setSuccess',
            'resetErrors'
        ]),
        ...mapActions('bus', [
          'getBuses',
          'getStaffByBus',
          'addStaffByBus',
          'removeStaffByBus',
          'removeScheduleByBus',
          'emptyStaffByBus',
          'sortBusSchedulesByCity',
          'sortBusSchedulesByTime'
        ]),
        ...mapActions('driver', [
          'getDrivers',
        ]),
        ...mapActions('helper', [
          'getHelpers',
        ]),
        ...mapActions('supervisor', [
          'getSupervisors',
        ]),
        ...mapActions('schedule', [
          'getSchedules',
        ]),
      ...mapActions('route', [
        'getRoutes',
        'getCitiesFromRoutesBy',
        'getRouteCityList',
        'emptyCitiesByRoute',
        'emptyRouteCityList'
      ]),

      ...mapActions('city', {
        getAvailableCities: 'getBusAvailableToCities',
      }),

      actionAlert() {
          swal({           
            title: 'Staff for the BUS',
            text: 'Added successfully!',
            icon: "success",
            timer: 2000,
            closeOnClickOutside: false,
          });
      },
      isAlreadyAddedThis(staff, availableStaff) {
        if (!Array.isArray(availableStaff)) return;
        let found = false;
        availableStaff.forEach(element => {
          if (element.id === staff.id) {
            found = true;
            return;
          }
        })
        return found;
      },
      isEmpty(obj) {
        return Object.keys(obj).length === 0;
      },
      objectToEmptyString() {
        // To display ('Please select one') first disabled option in SELECT box
        this.bus = '';
        this.selectedDriver = '';
      },                                    
      save() {
        this.loading = true;
        let data = {
          // bus_id: this.bus.bus.id,
          driver: this.selectedDriver,
          helper: this.selectedHelper,
          supervisor: this.selectedSupervisor,
        };
        this.addStaffByBus({
            data: data,              
            id: this.bus.bus.id,
        });
        this.loading = false;
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
      setListOf(errors, list) {
        Object.keys(errors).forEach(key => {
          list.push({
            key: key.toUpperCase(),
            value: errors[key][0]
          })
        });
        this.showTheModal('error');
      },
      // showTheModal(modalId) {                  
      //   $(`#${modalId}`).modal({
      //     backdrop: 'static'
      //   })
      // },
      remove(staff, type) { 
          var vm = this;
          swal({
            title: "Are you sure?",
            // text: "This Schedule will be Removed!",
            text: `This ${staff.name}(${type}) will be Removed!`,
            icon: "error",                 
            dangerMode: true,
            buttons: {
                cancel: "Cancel",
                confirm: {
                  text: "Remove him!",
                  value: true,
                },                                
            },
          })
          .then((value) => {
            if (value) {

              vm.loading = true;
              vm.showAlert = false;

              vm.removeStaffByBus({
                staffId: staff.id, 
                type: type, 
                busId: vm.bus.bus.id
              });

              vm.loading = false;
              vm.actionStatus = 'Removed';
              vm.alertType = 'info';
              vm.responseMessage = `${staff.name}(${type}) has been REMOVED successfully.`;
              vm.showAlert= true;
            }                   
          }); 
      },
      
      reset(all) { 
        if(all) {
          this.bus = '';
          // this.departureCity = '';
          // this.schedules = [];
          this.show = false;
          this.emptyStaffByBus();
          // this.emptyCitiesByRoute();
          // this.emptyRouteCityList();
          // $('.alert').alert('close');
          this.resetErrors();
          return; 
        }
        this.resetErrors();
        this.selectedDriver = '';
        this.selectedHelper = '';
        this.selectedSupervisor = '';
        this.responseMessage = '';
        this.show = false;
      },
      swAlert(text, icon) {
        swal({
          text: text, 
          icon: icon,
        });
      },
      sortBusSchedulesBy(value) {
        if (value == 'city' ) {
          this.sortBusSchedulesByCity();
          this.disableSorting = false;
          return;
        }

        this.sortBusSchedulesByTime();
        this.disableSorting = true;
      },
    }
}
</script>
<style lang="scss" scoped>    
  .table thead th {
    border-bottom: 1px solid hsl(188, 78%, 41%);
  }
</style>