<template>
  <div class="content-wrapper">    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bus</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">
                  <i class="fa fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">Bus</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">      
      <div class="container-fluid">
        <add-section :show.sync="show">
          <template v-slot:heading>
            <header-icon 
              icon-inner="fa-bus-alt" 
              icon-outer="fa-circle" 
              icon-color="hsla(202, 52%, 49%, .8)"
              text-color="hsla(202, 52%, 52%, 1)"
              :shadow="true"
              :visible="!editMode"
            >  
              Add Bus
            </header-icon>
            <header-icon 
              icon-inner="fa-edit" 
              icon-outer="fa-circle" 
              icon-color="hsla(36, 100%, 50%, .8)"
              text-color="hsla(36, 100%, 53%, 1)"
              :shadow="true"
              :visible="editMode"
            > 
            Edit Bus
            </header-icon> 
          </template>
          <form>               
                <box                   
                  background-color="hsla(22, 75%, 73%, 1)" 
                  border-radius=".5"
                  :margin='{top: 1.5, bottom: 3}'
                  heading-background="hsla(22, 81%, 78%, 1)" 
                  heading-border-radius="5"
                  heading-width="11.25" 
                  heading-show="true"
                  :shadow="true"
                >
                  <template v-slot:heading>Route Info</template>
                  <div class="row justify-content-center">
                    <div class="col-sm-5">
                        <route-list id="route" v-model="bus.routeId" />
                    </div>
                  </div>
                </box>

                <box 
                  background-color="hsla(188, 54%, 73%, 1)"
                  border-radius=".5" 
                  :margin='{top: 0, bottom: 3}'
                  heading-background="hsla(188, 61%, 78%, 1)" 
                  heading-border-radius="5"
                  heading-width="11.25" 
                  heading-show="true"
                  :shadow="true"
                >
                  <template v-slot:heading>Seat Plan Info</template>

                  <div class="row justify-content-center">

                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="seatPlan">Seat Plan#</label>
                          <select v-model="bus.seatPlanId" class="form-control custom-select" id="seatPlan" :disabled="editMode">
                              <option disabled value="">Please select one</option>
                              <option v-for="seat in availableSeatPlanList" v-bind:value="seat.id">
                                  {{ seat.id }}
                              </option>                                              
                          </select>                      
                      </div>
                    </div>

                    <div class="col-sm-2">
                      <div class="form-group">
                        <label for="numberOfSeat">Total Seat #</label>
                        <input v-model="numberOfSeat" type="number" min="1" max="50" class="form-control" id="numberOfSeat" placeholder="Number of Seat" disabled>
                      </div>
                    </div>

                    <div class="col-sm-2">
                        <button type="button" class="btn btn-primary btn-center" @click.prevent="showTheModal('busSeatPlan')" :disabled="bus.seatPlanId == ''">    
                          <i class="far fa-eye mr-2"></i>View
                        </button>
                    </div>
                  </div>  
                </box>
                
                <box 
                  background-color="hsla(261, 63%, 80%, 1)" 
                  border-radius=".5"
                  :margin='{top: 3.125, bottom: 1}'
                  heading-background="hsla(261, 70%, 85%, 1)" 
                  heading-border-radius="5"
                  heading-width="11.25" 
                  heading-show="true"
                  :shadow="true"
                >
                  <template v-slot:heading>Registraion Info</template>
                  <div class="row justify-content-center">  
                    <div class="col-sm-4">
                      <div class="form-group">
                        <label for="regNumber">Registration #</label>
                        <input v-model.lazy="bus.regNumber" type="text" class="form-control" id="regNumber" placeholder="Registration Number" v-bind:style="formControl">
                      </div>
                    </div>

                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="numberPlate">Number Plate #</label>
                        <input v-model="bus.numberPlate" v-bind:style="formControl" type="text" class="form-control" id="numberPlate" placeholder="Number Plate" :disabled="isDisabled">
                      </div>
                    </div>
                    
                    <div class="col-sm-3">
                      <div class="form-group">
                        <label for="busType">Bus Type #</label>
                          <select v-model="bus.typeId" v-bind:style="formControl" class="form-control custom-select" id="busType">
                              <option disabled value="">Please select one</option>
                              <option v-for="type in types" v-bind:value="type.id">
                                  {{ type.name }}
                              </option>                                             
                          </select>                      
                      </div>
                    </div>

                    <div class="col-sm-10">
                      <div class="form-group">
                        <label for="busDescription">Description</label>
                        <textarea v-model="bus.description" v-bind:style="formControl" min="1" max="50" class="form-control" id="busDescription" placeholder="Description" :disabled="isDisabled"></textarea>
                      </div>
                    </div>                    
                  </div>
                </box>
                <div class="col-12 text-center mt-4 mb-2">
                  <div class="button-group">
                    <button v-on:click.prevent="save()"  type="button" class="btn btn-primary mr-2 px-5" :disabled="!isValid" v-show="!editMode">
                      <i class="far fa-save mr-2"></i>
                    Save
                    </button>
                    <button v-on:click.prevent="update()"  type="button" class="btn btn-info mr-2 px-5" :disabled="!isValid" v-show="editMode">
                      <i class="fas fa-save mr-2"></i>
                      Update
                    </button>
                    <button v-on:click.prevent="reset()"  type="button" class="btn btn-warning">
                      <i class="far fa-window-close"></i>
                      Cancel
                    </button>
                  </div>
                </div>
          </form>                      
        </add-section>
        
        <app-modal modal-id="busSeatPlan"> 
          <seat-layout ref="sl" :seatList="selectedSeatPlan.seat_list" />
        </app-modal>

        <error-modal btn-color="btn-warning" modal-id="error" :error-list="errorList" />

        <show-alert :show.sync="showAlert" :type="alertType"> 
          <strong> Bus </strong> has been <strong>{{ actionStatus }} </strong>
        </show-alert>

        <loader :show="loading"></loader>
      
        <div class="row justify-content-center py-3">
          <div class="card w-100">
            <!-- <div class="card-header">Bus Info 
              <span class="float-right">
                <high-light 
                  color="hsla(210, 9%, 30%, 1)" 
                  value="5"
                  :shadow="true"
                > {{ availableBusList.length }} 
                </high-light>
              </span>
            </div> -->
            <div class="card-body p-0">
                <div class="scrollbar">
                  <table class="table table-striped table-hover">
                      <thead class="bg-secondary">
                        <tr>
                          <th>Sl. No.</th>
                          <th>Bus ID
                              <span type="button" @click.prevent="sortByIdOf('bus')" :disabled="disableSorting">
                                  <i class="fas fa-sort-amount-down-alt"></i>
                              </span>
                          </th>
                          <th>
                              Route
                          </th>                           
                          <th>Number
                              <span type="button" @click.prevent="sortByIdOf('registration')" :disabled="!disableSorting">
                                  <i class="fas fa-sort-amount-down-alt"></i>
                              </span>
                          </th>
                          <!-- <th>Number Plate</th> -->
                          <th>Type</th>                                
                          <th>Total Seats</th>     
                          <th>Seat Plan ID</th>     
                          <th>Descriptin</th> 
                          <th>Action</th>    
                          <!-- <th>&nbsp;</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr  v-for="(bus, index) in availableBusList">                              
                          <td>{{ index+1 }}</td>                              
                          <td>{{ bus.bus.id }}</td>
                          <td> {{ getRouteBy(bus.bus.route_id).first_city}} <br />
                            <i class="fas fa-exchange-alt"></i> <br />
                            {{ getRouteBy(bus.bus.route_id).second_city}} 
                          </td>
                          
                          <td>
                            <div class="border-bottom border-info pb-1 mb-1">Registration #:  <br />
                            {{ bus.bus.reg_no }}
                            </div>
                            <!-- <hr /> -->
                            Number Plate: <br />
                            {{ bus.bus.number_plate }}
                          </td>
                          
                          <td>{{ typeBy(bus.bus.type_id) }}</td>                         
                          <td><strong>{{ bus.total_seats }}</strong></td>
                          <td><strong>{{ bus.bus.seat_plan_id }}</strong></td>
                          <td>{{ bus.bus.description }}</td>
                          <td> 
                            <div class="mb-2">                                
                              <button v-on:click.prevent="edit(bus)" class="btn btn-outline-info">
                                <i class="far fa-edit mr-2"></i>Edit
                              </button>  
                            </div>
                            <div>                                
                              <button v-on:click.prevent="remove(bus.bus)" class="btn btn-outline-danger">
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
              <h5 class="px-1"> 
                {{ availableBusList.length }} 
                <small class="text-muted"> buses available.</small>
              </h5>                                   
            </div>
          </div>
        </div>           
      </div>
    </section>        
  </div>      
</template>
<script>
    import Modal from '../../components/AppModal'; 
    import ErrorModal from '../../components/ErrorModal'; 
    import Route from '../../components/route/Route'; 
    import Box from '../../components/Box';  
    import SeatLayout from '../../components/SeatLayout';

    import { mapState, mapGetters, mapActions } from 'vuex';

    export default {        
        props: {
            token: String,
        },
        components: {
            Box,
            'route-list': Route,
            'app-modal': Modal,
            'error-modal': ErrorModal,
            'seat-layout': SeatLayout,
        },
        data() {
                return {                    
                    actionStatus: '',
                    alertType: '',
                    busToEdit: {
                      id: '',
                      index: '',
                    },
                    divHeight: 0,
                    disableShowButton: false,
                    disableSorting: true,
                    editMode: false,
                    error: '',
                    errorList: [],        
                    formControl: {
                      backgroundColor: '#fff',
                    },                                    
                    response: '',                         
                    isDisabled: false,                    
                    loading: false,
                    //bus
                    bus: {
                      routeId: '',  
                      regNumber: '',
                      numberPlate: '',
                      description: '',
                      seatPlanId: '',
                      typeId: '',
                    },
                    numberOfSeat: '',
                    selectedSeatPlan: '',                    
                    showAlert: false,
                    show: false,                    
                    modal: false,
                }
              },
                
                async mounted() {
                    this.loading = true;
                    
                    await this.getBusTypes();
                    await this.getBuses({token: this.token});
                    // await this.getBuses();
                    await this.getSeatPlans({token: this.token});

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
                    'bus.regNumber'(val, oldVal) {
                        var aa = this.isRegNumberAvailable(this.bus.regNumber);
                        if (aa) {
                            if(this.editMode) {
                              this.swAlert('Edit Mode Started..', 'warning');                              
                              return;
                            }
                            this.swAlert('Registration Number is already exist!', 'info');
                        }
                    },
                    'bus.seatPlanId'(val, oldVal) {
                      if(this.bus.seatPlanId) {
                        this.selectedSeatPlan = this.getSeatPlanBy(this.bus.seatPlanId);
                        
                        this.numberOfSeat = this.selectedSeatPlan.total_seats;
                        return;
                      }
                      this.numberOfSeat= '';
                    },
                    success() {
                      if (this.success) {
                          this.loading = false;
                          let actionStatus = this.setActionStatus();
                          let icon = this.setIconBasedOn(actionStatus)
                          this.actionAlert('Bus', actionStatus, icon);
                          this.reset();
                          // this.resetErrors();
                          this.setSuccess({ status: false });
                          this.alertType = 'success';
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
                      'any'
                    ]),                    
                    ...mapState('bus', [
                      'availableBusList'
                      // 'types'
                    ]),
                    ...mapState('type', [
                      'types'
                    ]),

                    ...mapState('seatplan', [
                      'availableSeatPlanList',
                    ]),
                    ...mapGetters('seatplan', [
                        'getSeatPlanBy'
                    ]),

                    ...mapGetters('bus', [
                      // 'typeBy',
                      'busBy',
                      'getIndexOf',
                      'isRegNumberAvailable'
                    ]),
                    ...mapGetters('type', [
                      'typeBy'
                    ]),
                    
                    ...mapGetters('route', [
                        'getRouteBy'
                    ]),
                   
                    isValid() {
                        return this.bus.regNumber != '' && 
                                this.bus.numberPlate != '' &&
                                this.bus.typeId != '' &&
                                this.bus.description != '' && 
                                this.bus.routeId != '' 
                     }
                }, 
                methods: {
                  ...mapActions([
                    'resetErrors',
                    'setSuccess'
                  ]),
                  ...mapActions('bus', [
                    'addBus',
                    'updateBus',
                    'deleteBus',                    
                    'getBuses',
                    'sortByBusId',
                    'sortByRegNumber',   
                  ]),
                  ...mapActions('type', [
                    'getBusTypes'
                  ]),
                  ...mapActions('seatplan', [
                    'getSeatPlans'
                  ]),  
                  
                  setActionStatus() {
                    if (this.editMode == true) {
                      this.actionStatus = 'Updated';
                      return 'Updated';
                    }
                    this.actionStatus = 'Added';
                    return 'Added';
                    // return (this.editMode == true) ?
                           // 'Updated' : 'Added';
                  },
                  setIconBasedOn(status) {
                    return (status == 'Added') ?
                           'success' : 'info';
                  },                  
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
                  actionAlert(name, status, icon) {
                      swal({           
                        title: name,
                        text: `${status} successfully!`,
                        icon: icon,
                        timer: 2000,
                        closeOnClickOutside: false,
                      });
                  },
                  
                  ucwords (str) {
                      return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                          return $1.toUpperCase();
                      });
                  },                    
                  save() {
                      //var vm = this;
                      this.loading = true;
                      this.addBus({
                        bus: this.bus,                         
                        numberOfSeat: this.numberOfSeat
                      });
                      // this.loading = false;
                      // this.actionAlert('Bus');
                      // this.actionStatus = 'Added';
                      // this.reset();
                      // this.alertType = 'success';
                      // this.showAlert = true;
                  },
                  edit(bus) {
                    this.busToEdit.id = bus.bus.id;

                    let busToEdit = this.busBy(bus.bus.id);
                     this.busToEdit.index = this.getIndexOf(busToEdit);
                    this.bus.routeId = busToEdit.bus.route_id;
                    this.bus.seatPlanId = busToEdit.bus.seat_plan_id;
                    this.bus.regNumber = busToEdit.bus.reg_no;
                    this.bus.numberPlate = busToEdit.bus.number_plate;
                    this.bus.typeId = busToEdit.bus.type_id;
                    this.bus.description = busToEdit.bus.description;
                    //this.bus = busToEdit.bus;
                    this.editMode = true;
                    this.show = true;
                    this.formControl.backgroundColor = 'lightyellow';
                    //console.log(busToEdit);
                    //this.type.name = this.typeBy(this.bus.typeId);
                  },
                  update() {
                    this.loading = true;
                    this.updateBus({
                      bus: this.bus,
                      busToEdit: this.busToEdit
                    });
                      // this.loading = false;
                      // this.actionStatus = 'Updated';
                      // this.reset();
                      // this.alertType = 'success';
                      // this.showAlert = true;
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

                  // fetchAvailableBuses() {
                  //     this.loading = true;
                  //     this.getBuses();
                  //     this.loading = false;
                  // },

                  // fetchAvailableSeatPlans() {
                  //   this.loading = true;
                  //   this.getSeatPlans();
                  //   this.loading = false;
                  // },
                  // fetchBusTypes() {
                  //   this.loading = true;
                  //   this.getBusTypes(); 
                  //   this.loading = false;
                  // },
                  
                  sortByIdOf(val) {
                      if (val== 'bus') { 
                          //this.sortByBusId(this.availableBusList);
                          this.sortByBusId();
                          this.disableSorting = true;
                          return ;
                      }
                      //this.sortByRegNumber(this.availableBusList);
                      this.sortByRegNumber();
                      this.disableSorting = false;
                  },
                  
                  remove(bus) { 
                      var vm = this;
                      swal({
                        title: "Are you sure?",
                        text: "This BUS will be Removed!",
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
                          await vm.deleteBus(bus.id);

                          vm.actionStatus = 'Removed';
                          vm.alertType = 'danger';
                          vm.loading = false;
                          vm.showAlert= true;                    
                        }                   
                      }); 
                  },
                  // removeBusFromAvailableBusList(busId) {
                  //     var indx = this.availableBusList.findIndex(function(bus){                 
                  //          return bus.bus.id == busId;
                  //     });        
                  //     this.availableBusList.splice(indx, 1);
                  //     //return;
                  // },
                  reset() {                       
                      this.isDisabled = false;
                      this.editMode = false;                                              
                      this.bus = {
                        routeId:  '' , 
                        regNumber:  '' , 
                        numberPlate:  '',
                        seatPlanId: '',
                        typeId:  '',
                        description:  '',
                      }
                      this.formControl.backgroundColor = '#fff';
                      this.resetErrors();
                  },
                  swAlert(text, icon) {
                    swal({
                      text: text, 
                      icon: icon,
                    });
                  },
        }
    }
</script>
<style lang="scss" scoped>
  .btn-center {
    margin-top: 2rem;
  }  
</style>