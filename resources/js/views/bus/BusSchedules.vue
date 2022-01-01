<template>
    <section class="content">      
      <error-modal modal-id="error" :error-list="errorList" />
      
      <loader :show="loading"></loader>

      <show-alert :show.sync="showAlert" :type="alertType">               
       <strong> City </strong> has been <strong>{{ actionStatus }} </strong>
      </show-alert>        
      
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
              <option v-for="bus in availableBusList" v-bind:value="
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
            <!-- expand -->
            <div class="mt-4 mb-2 p-2 bg-mayablue-medium rounded">
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

              <div class="mx-2 my-3" v-show="expand">
                <!-- below prev code   -->
                <div class="form-group">
                    <label for="city">Departure City</label>
                      <select 
                        v-model="departureCity" 
                        class="form-control custom-select"
                        v-bind:class="{ 'is-invalid': has('route-cities') }"
                      > 
                          <option value="" disabled>Please select one</option>
                          <option v-for="city in routeCityList"
                               v-bind:value="city.id"
                            >
                              {{ city.name }}
                          </option>                                            
                      </select>
                      <span class="invalid-feedback" v-if="has('route-cities')" v-text="get('route-cities')">
                    </span>
                </div>

                <div class="form-group">
                    <label for="schedule">Schedules: 
                    </label>
                    <!-- <span class="text-muted mx-2"><small>Departure - Arrival</small></span> -->
                    <span class="text-muted mx-2"><small>Departure Time</small></span>
                    <select v-model="schedules" class="form-control" multiple size="7">

                      <option v-for="schedule in availableScheduleList"
                           v-bind:value="
                                schedule.id"
                        >
                           {{ schedule.departure_time }}  
                      </option>                                             
                    </select>
                    <span v-show="availableScheduleList.length > 0" class="text-muted font-italic"><small>*Select multiple by pressing <kbd>Ctrl</kbd> key </small></span>
                </div>    

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

                <div class="text-center mt-4">
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
            </div> <!-- end expand -->
          </form>          
        </div>

        <div class="p-3 bg-mayablue flex-fill">
            
            <div v-if="!schedulesAvailable" class="text-center mt-2">
              <span class="fa-stack text-shadow" style="font-size: 4.5em;">
                <i class="fas fa-circle fa-stack-2x" style="color: #228be6"></i>
                <i class="fas fa-clock fa-stack-1x" style="color: #74C0FC"></i>
              </span>         
            </div>                
        
            <!-- Errors Display -->
            <div class="text-primary text-center h4 mt-3" v-if="has('bus-schedules')">
            <i class="fas fa-info bg-primary rounded-lg px-3 py-2 mr-2"></i>
              Schedules {{ get('bus-schedules') }}
            </div>

            <div v-show="schedulesAvailable" class="card mt-1 w-100">
              <!-- <div class="card-header">
                Available Schedules for the BUS
              </div> -->
              <div class="card-body p-0">
                <div class="scrollbar">
                  <table class="table table-striped table-hover">
                      <thead class="bg-info">
                        <tr>
                          <th>SL.# </th>
                          <th>DEPARTURE CITY
                            <span type="button" @click.prevent="sortBusSchedulesBy('city')" :disabled="!disableSorting">
                                  <i class="fas fa-sort-alpha-down" aria-hidden="true"></i>
                              </span>
                          </th>
                          <th>DEPARTURE TIME
                              <span type="button" @click.prevent="sortBusSchedulesBy('time')" :disabled="disableSorting">
                                  <i class="fas fa-sort-numeric-down" aria-hidden="true"></i>
                              </span>
                          </th>
                          <th>ACTION</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(schedule, index) in schedulesByBus" >                              
                          <td>{{ index+1 }}</td>                      
                          <td>
                            {{ getCityById(schedule.pivot.departure_city_id).name }}
                          </td>
                          
                          <td>{{ schedule.departure_time }}</td>
                          <td>                          
                              <button v-on:click.prevent="remove(schedule)" class="btn btn-outline-danger">
                                <i class="button-icon fas fa-trash"></i>Remove
                              </button> 
                          </td>                        
                        </tr>                            
                      </tbody>
                  </table>      
                </div>
              </div>
              <div class="card-footer">
                <h5 class="px-1" v-show="schedulesAvailable">                   
                  {{ schedulesByBus.length }}
                  <small class="text-muted mr-1"> 
                    <span v-if="schedulesByBus.length > 1"> schedules </span> 
                    <span v-else> schedule </span>
                    available.
                  </small>                  
                </h5>
              </div>                    
            </div>

        </div>        
      </div>      
    </section>
</template>
<script>

import ErrorModal from '../../components/ErrorModal'; 

import { mapState, mapGetters, mapActions } from 'vuex';

export default {  
    props: {
        token: String,
    },
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
          expand: false,
          instanceOfScrollbar: undefined,
          schedules: [],
      }
    },
    async mounted() {
        this.loading = true;
        await this.getRoutes();
        await this.getBuses({token: this.token});
        await this.getSchedules();
        await this.getAvailableCities();
        this.loading = false;

        if (this.any(this.errors)) {
          this.setListOf(this.errors, this.errorList)
        }
        this.enableScroll();
        this.objectToEmptyString();
    },  
    beforeUnmount() {
        this.instanceOfScrollbar.destroy();
        $().alert('dispose'); 
        this.resetErrors();        
        this.emptySchedulesByBus();
        this.emptyCitiesByRoute();                    
    },
    watch: {                    
      async 'bus.bus.id'(val, oldVal) {

          if (this.isEmpty(this.bus)) return;
          this.loading = true;
          this.resetErrors();
          this.emptySchedulesByBus()
          this.emptyCitiesByRoute();
          this.departureCity = '';

          await this.getCitiesFromRoutesBy(
            this.bus.bus.route_id);

          this.getRouteCityList();          
          
          this.disableSorting = true;
          await this.getSchedulesByBus(val);
          this.loading = false;

        },
        success() {
            if (this.success) {
                this.loading = false;
                this.actionAlert();
                this.reset();
                // this.resetErrors();
                this.setSuccess({ status: false });
                this.actionStatus = 'Added';
                this.alertType = 'success';
                this.showAlert = true; 
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
            'schedulesByBus'
        ]),

        ...mapState('schedule', [
          'availableScheduleList',
        ]),

        ...mapState('route', [
          'routeCityList'
        ]),
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
      schedulesAvailable() {
          if (this.schedulesByBus.length > 0) {
           return true;
          }
          return false;
         // return 
         //      (this.schedulesByBus.length > 0) ?
         //      true : false;
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
                    this.departureCity != '' &&
                    this.schedules.length > 0
         }
    },
    methods: {  
        ...mapActions([
            'setSuccess',
            'resetErrors'
        ]),
        ...mapActions('bus', [
          'getBuses',
          'getSchedulesByBus',
          'addSchedulesByBus',
          'removeScheduleByBus',
          'emptySchedulesByBus',
          'sortBusSchedulesByCity',
          'sortBusSchedulesByTime'
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
            title: 'Schedules for the BUS',
            text: 'Added successfully!',
            icon: "success",
            timer: 2000,
            closeOnClickOutside: false,
          });
      },
      isEmpty(obj) {
        return Object.keys(obj).length === 0;
      },
      objectToEmptyString() {
        // To display ('Please select one') first disabled option in SELECT box
        this.bus = '';
        this.departureCity = '';
      },                                    
      save() {
        this.loading = true;

        let data = {
          bus_id: this.bus.bus.id,
          schedules: this.schedules,
          departure_city_id: this.departureCity,
        };
        this.addSchedulesByBus({
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
      showTheModal(modalId) {                  
        $(`#${modalId}`).modal({
          backdrop: 'static'
        })
      },
      remove(schedule) { 
          var vm = this;
          swal({
            title: "Are you sure?",
            text: "This Schedule will be Removed!",
            icon: "error",                 
            dangerMode: true,
            buttons: {
                cancel: "Cancel",
                confirm: {
                  text: "Remove It!",
                  value: true,
                },                                
            },
          })
          .then((value) => {
            if (value) {

              vm.loading = true;
              vm.showAlert = false;

              vm.removeScheduleByBus({
                schedule: schedule.id, 
                bus: vm.bus.bus.id
              });

              vm.loading = false;
              vm.actionStatus = 'Removed';
              vm.alertType = 'danger';
              vm.showAlert= true;
            }                   
          }); 
      },
      
      reset(all) { 
        if(all) {
          this.bus = '';
          this.departureCity = '';
          this.schedules = [];
          this.show = false;
          this.emptySchedulesByBus();
          this.emptyCitiesByRoute();
          this.emptyRouteCityList();
          // $('.alert').alert('close');
          this.resetErrors();
          return; 
        }
        this.resetErrors();
        this.departureCity = '';
        this.schedules = [];
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