<template>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <add-section :show.sync="show">
          <template v-slot:heading>
            <header-icon 
              icon-inner="fa-clock" 
              icon-outer="fa-circle" 
              icon-color="hsla(188, 75%, 50%, .9)"
              text-color="hsla(188, 78%, 41%, 1)"
              :shadow="true"
            >
            Add Schedule
            </header-icon>
          </template>
          <!-- <div class="d-md-flex justify-content-center">
            <div class="p-3 bg-lightlemonyellow flex-fill">
              <form>
                <div class="form-row mt-2">
                  <div class="col-sm"> 
                    <div class="form-group">
                       <label for="departure-time">Departure time: </label>
                       <input v-model="departureTime" id="departure-time" type="time" name="departure-time" class="form-control" v-bind:class="{ 'is-invalid': has('departure_time') }" min="00:00" max="23:59" required>
                       <span class="invalid-feedback" v-if="has('departure_time')" v-text="get('departure_time')"></span>
                    </div>
                  </div>

                  <div class="col-sm"> 
                    <div class="form-group">
                      <label for="arrival-time">Arrival time: </label>
                      <input v-model="arrivalTime" id="arrival-time" type="time" name="arrival-time" class="form-control" v-bind:class="{ 'is-invalid': has('arrival_time') }" min="00:00" max="23:59" required>
                      <span class="invalid-feedback" v-if="has('arrival_time')" v-text="get('arrival_time')"></span>
                    </div>
                  </div>
              </div>
              <div class="col-sm-6 mt-2">
                  <div class="button-group">
                    <button v-on:click.prevent="save()" class="btn btn-primary" :disabled="!isValid">Add</button>
                    <button v-on:click.prevent="reset()" class="btn btn-warning">Reset</button>
                  </div>
                </div>
            </form>
            </div>
            <div class="p-3 bg-mediumyellow">
              <div class="d-sm-flex h-100 justify-content-center align-items-center">
                <div>
                  <span class="fa-stack">
                    <i class="fas fa-square fa-stack-2x text-warning"></i>
                    <i class="fas fa-clock fa-stack-1x" style="color: #ffe066"></i>
                  </span>         
                </div>                
              </div>
            </div>            
          </div> -->
          <!-- <div class="col-md-6">          
            <form>
            <div class="form-row">
              <div class="col-sm-2"> 
                  <div class="form-group">
                     <label for="departure-time">Departure time: </label>
                     <input v-model="departureTime"id="departure-time" type="time" name="departure-time" class="form-control" min="00:00" max="23:59" required>
                  </div>
              </div>

              <div class="col-sm-2"> 
              <div class="form-group">
                 <label for="arrival-time">Arrival time: </label>
                 <input v-model="arrivalTime"id="arrival-time" type="time" name="arrival-time" class="form-control" min="00:00" max="23:59" required>
              </div>
              </div>

              <div class="col-sm-4">
              <div class="button-group">
                <button v-on:click.prevent="save()" class="btn btn-primary" :disabled="!isValid">Add</button>
                <button v-on:click.prevent="reset()" class="btn btn-warning">Reset</button>
              </div>
              </div>
            </div>
            </form>
          </div>
          <div class="col-md-6">hello world</div> -->
          <form>
            <box                   
              background-color="hsla(188, 79%, 87%, 1)" 
              border-radius=".5"
              :margin='{top: 1, bottom: 2}'
              heading-background="hsla(188, 90%, 88%, 1)" 
              heading-border-radius="5"
              heading-width="11.25" 
              heading-show="true"
              :shadow="true"
            >
              <template v-slot:heading>Make Schedule</template>
              <div class="row justify-content-center mt-2">
                <div class="col-4 mr-2"> 
                  <div class="form-group">
                     <label for="departure-time">Departure time: </label>
                     <input v-model="departureTime" id="departure-time" type="time" name="departure-time" class="form-control" v-bind:class="{ 'is-invalid': has('departure_time') }" min="00:00" max="23:59" required>
                     <span class="invalid-feedback" v-if="has('departure_time')" v-text="get('departure_time')"></span>
                  </div>
                </div>

                <div class="col-4"> 
                  <div class="form-group">
                    <label for="arrival-time">Arrival time: </label>
                    <input v-model="arrivalTime" id="arrival-time" type="time" name="arrival-time" class="form-control" v-bind:class="{ 'is-invalid': has('arrival_time') }" min="00:00" max="23:59" required>
                    <span class="invalid-feedback" v-if="has('arrival_time')" v-text="get('arrival_time')"></span>
                  </div>
                </div>

                <!-- <div class="col-12 text-center mt-3 mb-2">
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
                </div> -->                  
              </div>
            </box>
            <div class="col-12 text-center mt-4 mb-2">
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
          </form>
        </add-section>
        
        <error-modal modal-id="error" :error-list="errorList" />

        <loader :show="loading"></loader>

        <div class="row justify-content-center">
          <div class="card w-100">            
            <div class="card-body p-0">
              <div class="scrollbar">
                <table class="table table-striped table-hover table">
                  <thead class="bg-secondary">                 
                    <tr>
                      <th>Sl. No.</th>
                      <th>Schedulel #</th>
                      <th>Departure Time</th>      
                      <th>Arrival Time</th>     
                      <th>Action</th>             
                    </tr>
                  </thead>
                  
                  <tbody>
                    <tr  v-for="(schedule, index) in availableScheduleList">

                      <td>{{ index+1 }}</td>                             
                          <td>{{ schedule.id }}</td>
                          <td>{{ schedule.departure_time }}</td>
                          <td>{{ schedule.arrival_time }}</td>
                          <td>
                              <button v-on:click.prevent="remove(schedule)" class="btn btn-outline-danger">
                                <i class="far fa-trash-alt mr-2"></i>Remove
                              </button> 
                          </td>
                    </tr>
                    
                  </tbody>
                </table>
              </div>
            </div>
            <div class="card-footer">
              <h5 class="px-1"> 
                {{ availableScheduleList.length }} 
                <small class="text-muted"> schedules available.</small>
              </h5>
            </div>
          </div>
        </div>

      </div> <!-- container fluid        -->
    </section>
</template>

<script>
    import Box from '../../components/Box';
    import ErrorModal from '../../components/ErrorModal'; 

    import { mapState, mapGetters, mapActions } from 'vuex';

    export default {
        components: {
            Box,          
            'error-modal': ErrorModal,
        },
        data() {
            return {
                arrivalTime: '',
                departureTime: '',
                errorList: [],
                instanceOfScrollbar: undefined,
                loading: false,
                schedule: '',
                //schedule: {},
                show: false,
            }
        },        

        async mounted() {     
            this.loading = true;       
            await this.fetchAvailableSchedules();
            this.loading = false;

            if (this.any(this.errors)) {
              this.setListOf(this.errors, this.errorList)
            }

            this.enableScroll();
        },
        beforeUnmount() {
          this.instanceOfScrollbar.destroy();
          this.resetErrors();
        },
        watch: {
          success() {
              if (this.success) {
                  this.loading = false;
                  this.actionAlert(this.schedule, 'Added successfully!', 'success');
                  this.reset();
                  // this.resetErrors();
                  this.setSuccess({ status: false });
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
                'any',
                'get',
                'has',
            ]),

            ...mapState('schedule', [
                'availableScheduleList'
            ]),

            isValid() {
                return this.departureTime != '' &&
                        this.arrivalTime != '' 
            }
        },

        methods: {
            ...mapActions([
                'setSuccess',
                'resetErrors'
            ]),
            ...mapActions('schedule', {
              fetchAvailableSchedules: 'getSchedules',
              add: 'add',
              delete: 'remove',
            }),
            setListOf(errors, list) {                    
              Object.keys(errors).forEach(key => {
                // console.log(key, errors[key][0]);
                list.push({
                  key: key.toUpperCase(),
                  value: errors[key][0]
                })
              });
              // console.table(list);
              this.showTheModal('error');                   
            },
            showTheModal(modalId) {                    
              $(`#${modalId}`).modal({
                backdrop: 'static'
              })    
            },
            actionAlert(schedule, text, icon) {
              swal({           
                title: schedule,
                //text: 'Added successfully!',
                text: text ,
                //icon: "success",
                icon: icon,
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

            edit(schedule) {

            },

            save() {
              this.loading = true;

              this.setSchedule();

              this.add({
                departure_time: this.departureTime,
                arrival_time: this.arrivalTime
              });

              // this.loading = false;
            },

            setSchedule() {
              this.schedule = `Schedule: 
                ${this.departureTime} - 
                ${this.arrivalTime}`
            },

            update(schedule) {

            },

            updateScheduleAtAvailableScheduleList(scheduleId, schedule) {                
                 var indx = this.availableScheduleList.findIndex(function(schedule){                                        
                        return schedule.id == scheduleId;
                 });                                     
                 this.availableScheduleList[indx] = schedule;                 
            },

            remove(schedule) {
              var vm = this;
              swal({
                title: "Are you sure?",
                text: "This SCHEDULE will be Removed!",
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
                  vm.showAlert = false;
                  await vm.delete(schedule.id);

                  vm.actionStatus = 'Removed';
                  vm.alertType = 'danger';
                  vm.loading = false;
                  vm.actionAlert(vm.schedule, ' Removed successfully!', 'info');
                  vm.showAlert= true;                    
                }                   
              }); 
            },

            reset() {
              this.departureTime = '';
              this.arrivalTime = '';

              this.resetErrors();
            },
        }
    }
</script>
<style lang="scss" scoped>  
.fa-stack { font-size: 2.5em; }
  // i { vertical-align: middle; }
</style>