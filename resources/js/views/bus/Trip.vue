<template>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Trip</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item">
                  <router-link to="/dashboard">
                    <i class="fas fa-dashboard nav-icon"></i>Dashboard
                  </router-link>
                </li>
                <li class="breadcrumb-item active">Trip</li>
              </ol>
            </div><!-- /.col -->
          </div><!-- /.row -->
        </div><!-- /.container-fluid -->
      </div>
      <!-- /.content-header -->

      <!-- Main content -->
      <section class="content">
        <!-- <div class="container-fluid"> -->
        <div class="container">
          <div class="row">
            <!-- Here goes page content -->
            <div class="col-12 my-2 text-center">
              <div class="bg-lightcyan rounded-pill py-2 text-primary" v-text="dateToday"></div>
            </div>
            <div class="col-md-6" v-if="isTripAvailable">
                <div class="card">
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
                              <input type="radio" id="tripStatusRadioCancel" name="tripStatusRadio" class="custom-control-input" value="Cancelled" v-model="statusToBe">
                              <label class="custom-control-label" for="tripStatusRadioCancel">Cancelled</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="tripStatusRadioComplete" name="tripStatusRadio" class="custom-control-input" value="Completed" v-model="statusToBe">
                              <label class="custom-control-label" for="tripStatusRadioComplete">Completed</label>
                            </div>
                          </div>                          
                          <div class="card-footer py-2">                          
                            Selected: <span v-if="statusToBe=='Cancelled'" class="text-danger font-weight-bold"> {{statusToBe}} </span> 
                            <span v-else class="text-success font-weight-bold"> {{statusToBe}} </span>
                          </div>
                        </div>
                      </div>
                      <!-- status end -->
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

            <div class="col-12 my-2 text-center" v-else>
              <div class="card"> 
                  <div class="card-body bg-peach rounded">
                    <i class="fas fa-exclamation-triangle fa-2x mr-2"></i>
                    <span class="h5">                        
                      Trip Not Found
                    </span>
                  </div>
              </div>
            </div>
            
            <loader :show="loading"></loader>

            <div class="col-md-6 mb-3" v-if="isTripAvailable">
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
                        <table class="table table-striped table-hover" style="font-size: 0.85rem;">
                            <thead class="bg-info">
                              <tr>
                                <!-- <th>Sl.</th> -->
                                <th>Trip</th>
                                <th>Coach</th>         
                                <th>Departure</th>
                                <th>Arrival</th>
                                <!-- <th>&nbsp;</th> -->
                              </tr>
                            </thead>
                            <tbody>
                              <tr  v-for="(trip, index) in tripsDetails">
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
                        <h5 class="px-1" v-if="tripsDetails.length > 1"> 
                            {{ tripsDetails.length }} 
                            <small class="text-muted"> trips available.</small>
                        </h5>            
                        <h5 class="px-1" v-else> 
                            {{ tripsDetails.length }} 
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
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
</template>

<script>
    import { mapState, mapGetters, mapActions } from 'vuex';

    export default {
        props: {
          role: String,
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
                tripsDetails: [],
                loading: false,
                statusToBe: '',
                tripToBeUpdatedId: null,
                expand: false,
                instanceOfScrollbar: undefined
                // updateInitiated: false
            }
        },
        async mounted() {            
            console.log('Component mounted.')
            this.loading = true;
            await this.getTripsBy(this.user.id);

            if (Array.isArray(this.trips)) {
                this.trips.forEach(trip => {
                    console.log(trip.id)
                    console.log('1')
                   this.getBusScheduleInfoBy(trip);
                    console.log('2')                    
                });
            }
            // console.log('333')                    
            // console.log('TDS', this.tripsDetails)                    
            // this.sortTripDetailsByDate();
            this.enableScroll();
            this.loading = false;
        },
        beforeUnmount() {
          if(this.instanceOfScrollbar) {            
            this.instanceOfScrollbar.destroy();
          }
        },
        watch: {
          'tripsDetails.length'(value) {
              if (value) {
                  if (value === this.trips.length) {
                      this.sortTripDetailsByDate();
                      // console.log('vvvvvv', value)
                      this.tripStatusToBeUpdated(this.tripsDetails[0]);
                  }
              }
          },
          success() {
              if (this.success) {
                  this.statusToBe = '';
                  this.loading = false;                    
                  this.actionAlert('info', 'Updated');
                  this.removeCompletedTripFromTripDetails(this.tripToBeUpdatedId);
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
          ]),
          ...mapGetters('bus', [
            'isTripAvailable'
          ]),
          isValid() {
            return this.statusToBe !=='';
          },
          dateToday() {
            let date = new Date(); 
            // return nowDate.getFullYear()+'/'+(nowDate.getMonth()+1)+'/'+nowDate.getDate(); 
            let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };

            console.log(date.toLocaleString('en-GB', options));
            return date.toLocaleString('en-GB', options);
          }
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
          sortTripDetailsByDate() {
              // console.log('sssssssort')
              this.tripsDetails.sort((a, b) => {
                  // return parseInt(this.convertTime12to24(a.schedule.departure_time)) - parseInt(this.convertTime12to24(b.schedule.departure_time));
                  return parseInt(this.convertTime12to24(a.arrival_time)) - parseInt(this.convertTime12to24(b.arrival_time));

                  // let timeA = parseInt(this.convertTime12to24(a.schedule.departure_time));
                  // console.log('a', timeA)
                  // let timeB = parseInt(this.convertTime12to24(b.schedule.departure_time))
                  // console.log('b', timeB)
                  
                  // return timeA - timeB;
              });                
          },

          convertTime12to24(time12h) {
            const [time, modifier] = time12h.split(' ');

            let [hours, minutes] = time.split(':');

            if (hours === '12') {
              hours = '00';
            }

            if ( modifier === 'PM' || modifier === 'pm') {
              hours = parseInt(hours, 10) + 12;
            }

           // return `${hours}:${minutes}`;
            return `${hours}${minutes}`;
          },

            removeCompletedTripFromTripDetails(id) {
                let index = this.tripsDetails.findIndex(trip => trip.id === trip.id);
                this.tripsDetails.splice(index, 1);
                this.tripToBeUpdatedId = null;

            },
            tripStatusToBeUpdated(trip) {
                console.log('4')
                console.log(this.tripsDetails)
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
                // this.trip = DATA;
            },                        
            update() {
                this.loading = true;
                this.tripToBeUpdatedId = this.trip.id;

                this.updateTrip({
                    id: this.trip.id,
                    status: this.statusToBe,
                    entryBy: this.user.name
                });

            },
            getBusScheduleInfoBy(trip) {
                // this.loading = true;          
                // this.supervisorInfo = ''; 
                var vm = this;          
                // let data = null;      
                axios.get(`/api/tripsdetails/${trip.bus_schedule_id}/${trip.city_route_id}`)
                    .then(function (response) {
                    // vm.setBusScheduleInfoToTrip(response.data);
                    // vm.loading = false;                    
                    // let data = response.data;
                    vm.setTripDetails(trip, response.data);
                })
                .catch(error => {
                    console.log(error.response.data);
                });
                // console.log('ddddd', data);
                // return data;
            },
            setTripDetails(trip, data) {
                const DATA = {
                    id: trip.id,
                    bus_schedule_id: trip.bus_schedule_id,
                    date: trip.date,
                    status: trip.status,
                    bus: data.bus,
                    schedule: data.schedule,
                    departure_city: data.departure_city,
                    arrival_city: data.arrival_city,
                    arrival_time: data.arrival_time,
                    distance: data.distance
                }
                // this.tripsDetails.push({
                //     id: trip.id,
                //     bus_schedule_id: trip.bus_schedule_id,
                //     date: trip.date,
                //     status: trip.status,
                //     bus: data.bus,
                //     schedule: data.schedule,
                //     departure_city: data.departure_city
                // });
                this.tripsDetails = [...this.tripsDetails, DATA];
                // console.log('m', this.tripsDetails)

            },
            // setTripInfo(trip) {
            //         this.trip.id = trip.id;
            //         this.trip.bus_schedule_id = trip.bus_schedule_id;
            //         this.trip.date = trip.date;
            //         this.trip.status = trip.status;
               
            // },
            // setBusScheduleInfoToTrip(data) {
            //     this.trip.bus = data.bus;
            //     this.trip.schedule = data.schedule;
            //     this.trip.departure_city = data.departure_city;
            // },
            // isEmpty(obj) {
            //     return Object.values(obj).length <= 1;
            // },
        }
    }
</script>
