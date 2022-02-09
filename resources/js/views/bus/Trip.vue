<template>
  <section class="content">
    <!-- <div class="container-fluid"> -->
    <div class="container">
      <div class="row">
        <!-- Here goes page content -->
        <div class="col-12 my-2 text-center">
          <div class="bg-lightcyan rounded-pill py-2 text-primary" v-text="dateToday"></div>
          
          <div class="mt-3 mb-2 px-3 pt-3 bg-oceanblue rounded" v-if="isAdmin">
            <form>                  
              <div class="form-row">
                <div class="form-group col-12 col-md-6 mx-auto">
                  <!-- <label for="supervisor" class="float-left">Select Supervisor</label> -->
                  <select 
                      id="supervisor" 
                      v-model="selectedSupervisor" 
                      class="form-control custom-select"
                  > 
                      <option value="" disabled>Please select a supervisor</option>
                      <option 
                        v-for="supervisor in availableSupervisorList"
                        :value="supervisor"      
                      >
                          {{ supervisor.name }}
                      </option>                 
                  </select>
                </div>
              </div>
            </form>
          </div>
        </div>
        <div class="col-md-6" v-if="isTripAvailable">
            <div class="card bg-oceanblue">
              <div class="card-body">
               <form>
                <div class="form-row">
                  <div class="form-group col-7">
                    <label for="inputCoahNumber">Coach</label>
                    <input type="text" class="form-control" id="inputCoahNumber" v-model="trip.bus.coach_no" disabled>
                  </div>  
                  <div class="form-group col-5">
                    <label for="inputTripId">Trip No.</label>
                    <input type="number" class="form-control bg-lightyellow" id="inputTripId" v-model="trip.id" disabled>
                  </div>                      
                  <div class="form-group col-7">
                    <label for="inputTripDepCity">Departure City</label>
                    <input type="text" class="form-control" id="inputTripDepCity" v-model="trip.departure_city" disabled>
                  </div>
                  <div class="form-group col-5">
                    <label for="inputTripDepTime">Depart. Time</label>
                    <input type="text" class="form-control" id="inputTripDepTime" v-model="trip.schedule.departure_time" disabled>
                  </div>
                  <div class="form-group col-7">
                    <label for="inputTripArrivalCity">Arrival City</label>
                    <input type="text" class="form-control" id="inputTripArrivalCity" v-model="trip.arrival_city" disabled>
                  </div>
                  <div class="form-group col-5">
                    <label for="inputTripArrivalTime">Arrival Time</label>
                    <input type="text" class="form-control" id="inputTripArrivalTime" v-model="trip.arrival_time" disabled>
                  </div>
                  <div class="form-group col-12">
                    <label for="inputTripPresentStatus">Present Status</label>
                    <input type="text" class="form-control text-danger" id="inputTripPresentStatus" v-model="trip.status" disabled>
                  </div>
                  <!-- status -->
                  <div class="form-group col-12 mb-1">
                    <div class="card">
                      <div class="card-header pt-1 pb-0 pl-3 bg-info">
                        <h6>Change Status To </h6>
                      </div>
                      <div class="card-body p-3 bg-lightcyan">
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="tripStatusRadioCancel" name="tripStatusRadio" class="custom-control-input" :value="2" v-model="statusToBe">
                          <label class="custom-control-label" for="tripStatusRadioCancel">Cancelled</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                          <input type="radio" id="tripStatusRadioComplete" name="tripStatusRadio" class="custom-control-input" :value="3" v-model="statusToBe">
                          <label class="custom-control-label" for="tripStatusRadioComplete">Completed</label>
                        </div>
                      </div>                          
                      <div class="card-footer py-2">                          
                        Selected: 
                        <span :class="statusToBe===2 ? 'text-danger' : 'text-success'" class="font-weight-bold"> {{statusToBeInReadable}} </span>
                      </div>
                    </div>
                  </div>
                  <!-- status end -->

                  <!-- staff selection -->
                  <div class="form-group col-12 mb-1">
                    <div class="card bg-lightgreen">
                      <div class="card-header pt-1 pb-0 pl-3 bg-success">
                        <h6>Staff</h6>
                      </div>
                      <div class="card-body p-3">
                        <form>                  
                          <div class="form-row">
                            <div class="form-group col-12 col-md-6">
                              <label for="driver">Driver</label>
                              <select 
                                  id="driver" 
                                  v-model="selectedDriver" 
                                  class="form-control custom-select"
                              > 
                                  <option value="" disabled>Please select a driver</option>
                                  <option 
                                    v-for="driver in drivers"
                                    :value="driver.id"      
                                  >
                                      {{ driver.name }}
                                  </option>                 
                              </select>
                            </div>
                            <div class="form-group col-12 col-md-6">
                              <label for="helper">Helper</label>
                              <select 
                                  id="helper" 
                                  v-model="selectedHelper" 
                                  class="form-control custom-select"
                              > 
                                  <option value="" disabled>Please select a helper</option>
                                  <option 
                                    v-for="helper in helpers"
                                    :value="helper.id"      
                                  >
                                      {{ helper.name }}
                                  </option>                 
                              </select>
                            </div>
                          </div>
                        </form>                        
                      </div>                          
                    </div>
                  </div>
                  <!-- staff selection end -->
                  <div class="form-group mb-0 col-md-12 text-center">
                    <button @click.prevent="update()" type="button" class="btn btn-primary btn-block mr-2 px-5 rounded-pill" :disabled="!isValid">
                          <i class="far fa-save mr-2"></i>
                        Update
                    </button>                           
                  </div>
                </div> 
               </form> 
              </div>
            </div>                  
        </div>

        <div class="col-12 text-center" v-else>              
          <div v-if="isAdmin && !searchMadeByAdmin"></div>
          <div class="card" v-else> 
              <div class="card-body bg-peach rounded">
                <i class="fas fa-exclamation-triangle fa-2x mr-2"></i>
                <span class="h5">                        
                  Trip Not Found
                </span>
              </div>
          </div>
        </div>
        
        <loader :show="loading"></loader>

        <div class="col-md-6 mb-3" v-show="isTripAvailable">
          <div class="p-2 rounded bg-lightcyan">
            <div class="p-1" @click="expand=!expand" style="cursor: pointer;">
                  <span class="fa-stack fa-2x text-shadow" v-show="!expand">
                    <i class="fas fa-circle fa-stack-2x text-primary"></i>
                    <i class="fas fa-clipboard-list fa-stack-1x fa-inverse" style="color: #74C0FC;"></i>
                  </span>
                  <span class="text-secondary h6" v-show="!expand">Pending Trips
                  </span>
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
                <div class="card-body p-0">
                  <div class="scrollbar">
                    <table class="table table-striped table-hover" style="font-size: 0.9rem;">
                        <thead class="bg-info">
                          <tr>
                            <!-- <th>Sl.</th> -->
                            <th>Trip</th>
                            <th>Coach</th>         
                            <th>Departure</th>
                            <th>Arrival</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr  v-for="(trip, index) in trips">
                            <!-- <td>{{ index+1 }}</td>       -->
                            <td>{{ trip.id }}</td>  
                            <td>{{ trip.bus.number_plate }}</td>
                            <td>
                              <div class="border-bottom pb-1 mb-1">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ trip.departure_city }}
                              </div>
                              <i class="far fa-clock mr-1"></i>
                              {{ trip.schedule.departure_time }}
                            </td>                        
                            <td>
                              <div class="border-bottom pb-1 mb-1">
                                <i class="fas fa-map-marker mr-1"></i>
                                {{ trip.arrival_city }}
                              </div>
                              <i class="fas fa-clock mr-1"></i>
                              {{ trip.arrival_time }}
                            </td>                                                       
                          </tr>                            
                        </tbody>
                    </table>      
                  </div>
                </div>        
                <div class="card-footer">              
                    <h5 class="px-1" v-if="trips.length > 1"> 
                        {{ trips.length }} 
                        <small class="text-muted"> trips available.</small>
                    </h5>            
                    <h5 class="px-1" v-else> 
                        {{ trips.length }} 
                        <small class="text-muted"> trip available.</small>
                    </h5>
                </div>          
              </div>                  
            </div>    
          </div>  
        </div>         
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>    
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';

    export default {
        props: {
          role: String,
          token: String,
          user: {
              type: Object
            },
        },
        data() {
            return {                
                trip: {
                    id: null,
                    bus_schedule_id: null,
                    date: null,
                    status: '',
                    bus: {
                        coach_no: '',
                    },
                    schedule: {
                        departure_time: ''
                    },
                    departure_city: '',
                    arrival_city: '',
                    arrival_time: '',
                    distance: ''
                },
                // tripsDetails: [],
                loading: false,
                statusToBe: '',
                tripToBeUpdatedId: null,
                expand: false,
                instanceOfScrollbar: {},
                searchMadeByAdmin: false,
                selectedSupervisor: '', 
                selectedDriver: '', 
                selectedHelper: '', 
                // updateInitiated: false
            }
        },
        async mounted() {            
            console.log('Component mounted.')
            if (this.isAdmin) {
              this.getSupervisors({token: this.token});
              return;
            }              
            this.loading = true;
            await this.getTripsBy(this.user.id);
            // this.setTrips(this.trips);            

            // this.enableScroll();
            this.loading = false;
        },
        beforeUnmount() {
          if(!this.isEmpty(this.instanceOfScrollbar)) {          
            this.instanceOfScrollbar.destroy();
          }
        },
        watch: {
          async selectedSupervisor(value) {
            if(value) {
              this.loading = true;
              // this.tripsDetails = [];
              await this.getTripsBy(value.user_id);
              this.searchMadeByAdmin = true;
              // this.setTrips(this.tripsInfo.trips);   
              this.loading = false;
            }
          },
          isTripAvailable(value) {
            if (value === true && this.isEmpty(this.instanceOfScrollbar)
              ) {
                this.enableScroll();
            }
          },
          // 'tripsDetails.length'(value) {
          //     if (value) {
          //         if (value === this.trips.length) {
          //             this.sortTripDetailsByDate();
          //             // console.log('vvvvvv', value)
          //             this.tripStatusToBeUpdated(this.tripsDetails[0]);
          //         }
          //     }
          // },
          'trips.length'(value) {
            console.log("TV", value)
              if (value > 0) {
                  // if (value === this.trips.length) {
                      // this.sortTripDetailsByDate();
                      // console.log('vvvvvv', value)
                      this.tripStatusToBeUpdated(this.trips[0]);
                  // }
              }
          },
          'drivers.length'(value) {
            if (value === 1) {
              this.selectedDriver = this.drivers[0].id;
            }
          },
          'helpers.length'(value) {
            if (value === 1) {
              this.selectedHelper = this.helpers[0].id;
            }
          },
          success() {
              if (this.success) {
                  this.statusToBe = '';
                  this.loading = false;                    
                  this.actionAlert('info', 'Updated');
                  // this.removeCompletedTripFromTripDetails(this.tripToBeUpdatedId);
                  this.setSuccess({ status: false });
              }
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
          ...mapState('bus', [
            'trips',
            'drivers',
            'helpers',
            'supervisorId'
          ]),
          ...mapGetters('bus', [
            'isTripAvailable',
          ]),
          ...mapState('supervisor', [
            'availableSupervisorList',
          ]),
          isAdmin() {
            return (this.role === 'super_admin' || this.role === 'admin') ? true : false;
          },
          isValid() {
            return this.statusToBe !== '' &&
              this.supervisorId !== '' &&
              this.selectedDriver !== '' &&
              this.selectedHelper !== '';
          },
          dateToday() {
            let date = new Date(); 
            let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

            return date.toLocaleString('en-GB', options);
          },
          statusToBeInReadable() {
             if (this.statusToBe === 2 ) {
                return 'Cancelled'; 
             }
             return  this.statusToBe === 3 ? 'Completed' : '';
          },
        },
        methods: {
          ...mapActions([
              'resetErrors',
              'setSuccess'
          ]),
          ...mapActions('bus', [
              'getBuses',
              'getTripsBy',
              'updateTrip'
          ]),
          ...mapActions('supervisor', [
          'getSupervisors',
        ]),
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
          actionAlert(icon, message) {
              swal({           
                title: 'TRIP',
                text: `${message} successfully!`,
                icon: icon,
                timer: 2000,
                closeOnClickOutside: false,
              });
          },          
          // setTrips(trips) {
          //   if (Array.isArray(trips)) {
          //       trips.forEach(trip => {                   
          //          this.getBusScheduleInfoBy(trip);
          //       });
          //   }
          // },
          // sortTripDetailsByDate() {
          //     this.tripsDetails.sort((a, b) => {
          //         return parseInt(this.convertTime12to24(a.arrival_time)) - parseInt(this.convertTime12to24(b.arrival_time));
          //     });                
          // },

          // convertTime12to24(time12h) {
          //   const [time, modifier] = time12h.split(' ');

          //   let [hours, minutes] = time.split(':');

          //   if (hours === '12') {
          //     hours = '00';
          //   }

          //   if ( modifier === 'PM' || modifier === 'pm') {
          //     hours = parseInt(hours, 10) + 12;
          //   }

          //   return `${hours}${minutes}`;
          // },

          //   removeCompletedTripFromTripDetails(id) {
          //       let index = this.tripsDetails.findIndex(trip => trip.id === trip.id);
          //       this.tripsDetails.splice(index, 1);
          //       this.tripToBeUpdatedId = null;

          //   },
            tripStatusToBeUpdated(trip) {            
                this.trip = {
                    id: trip.id,
                    bus_schedule_id: trip.bus_schedule_id,
                    date: trip.date,
                    status: trip.status,
                    bus: {
                        coach_no: trip.bus.number_plate
                    },
                    schedule:{
                        departure_time: trip.schedule.departure_time
                    },
                    departure_city: trip.departure_city,
                    arrival_city: trip.arrival_city,
                    arrival_time: trip.arrival_time,
                    distance: trip.distance
                }
            },                        
            update() {
                this.loading = true;
                this.tripToBeUpdatedId = this.trip.id;

                this.updateTrip({
                    id: this.trip.id,
                    status: this.statusToBe,
                    driverId: this.selectedDriver,
                    supervisorId: this.supervisorId,
                    helperId: this.selectedHelper,
                    // entryBy: this.user.name
                });

            },
            // getBusScheduleInfoBy(trip) {
            //     var vm = this;          
            //     axios.get(`/api/tripsdetails/${trip.bus_schedule_id}/${trip.city_route_id}`)
            //         .then(function (response) {
            //         vm.setTripDetails(trip, response.data);
            //     })
            //     .catch(error => {
            //         console.log(error.response.data);
            //     });
            // },
            // setTripDetails(trip, data) {
            //     const DATA = {
            //         id: trip.id,
            //         bus_schedule_id: trip.bus_schedule_id,
            //         date: trip.date,
            //         status: trip.status,
            //         bus: data.bus,
            //         schedule: data.schedule,
            //         departure_city: data.departure_city,
            //         arrival_city: data.arrival_city,
            //         arrival_time: data.arrival_time,
            //         distance: data.distance
            //     }
            //     // this.tripsDetails.push({
            //     //     id: trip.id,
            //     //     bus_schedule_id: trip.bus_schedule_id,
            //     //     date: trip.date,
            //     //     status: trip.status,
            //     //     bus: data.bus,
            //     //     schedule: data.schedule,
            //     //     departure_city: data.departure_city
            //     // });
            //     this.tripsDetails = [...this.tripsDetails, DATA];
            //     // console.log('m', this.tripsDetails)

            // },            
            isEmpty(obj) {
                return Object.values(obj).length <= 1;
            },
        }
    }
</script>