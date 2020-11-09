<template>
  <div class="content-wrapper">    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Bus Type</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link to="/dashboard">
                  <i class="fas fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">Bus Type</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">      
      <div class="container-fluid">       
          <div class="d-md-flex align-items-center mb-3 shadow">
              <div class="p-2 flex-fill bg-warning">
                <form>
                  <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
                    <div class="col-sm-10">
                      <input type="text" readonly class="form-control-plaintext" id="staticEmail" value="email@example.com">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" id="inputPassword">
                    </div>
                  </div>
                </form>                
              </div>

              <div class="p-3 bg-mayablue flex-fill">
            
                <div v-if="!typesAvailable" class="text-center mt-2">
              <span class="fa-stack">
                <i class="fas fa-circle fa-stack-2x" style="color: #228be6"></i>
                <i class="fas fa-clock fa-stack-1x" style="color: #74C0FC"></i>
              </span>         
                </div>                

                <!-- <div class="text-muted text-center h4 mt-3" v-if="has('type')">
                  <i class="fas fa-info-circle"></i>
                  {{ get('type') }}
                </div>               -->

                <div v-show="typesAvailable" class="card mt-1 w-100">
                  <div class="card-header">
                    Bus Types
                  </div>
                  <div class="card-body p-0">
                    <div id="scrollbar">
                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>SL.# </th>
                            <th>TYPE NAME</th>
                            <th>TYPE KEY</th>
                            <th>ACTION</th>
                          </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(type, index) in types" >                              
                              <td>{{ index+1 }} </td>                      
                              <td> {{ type.name }} </td>
                              
                              <td>{{ type.key }}</td>
                              <td>                          
                                  <button v-on:click.prevent="remove(type)" class="btn btn-outline-danger">
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
        
        <error-modal modal-id="error" :error-list="errorList" />
        <loader :show="loading"></loader>

      </div>
    </section>        
  </div>      
</template>
<script>
    // import Modal from '../../components/AppModal'; 
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
                    // busToEdit: {
                    //   id: '',
                    //   index: '',
                    // },
                    // disableShowButton: false,
                    // disableSorting: true,
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
                    // numberOfSeat: '',
                    // selectedSeatPlan: '',                    
                    showAlert: false,
                    show: false,                    
                    // modal: false,
                }
                },
                watch: {                
                  async mounted() {
                      this.loading = true;
                      console.log('a1')
                      await this.getBusTypes();
                      this.loading = false;
                      console.log('a2')

                      if (this.any(this.errors)) {
                        this.setListOf(this.errors, this.errorList)
                      }
                  }
                },
                computed: {     
                    ...mapState([
                        'errors',
                        'success'
                    ]),
                    ...mapGetters([
                      'has',
                      'get',
                      'any'
                    ]),                    
                    ...mapState('type', [
                      'types'
                    ]),
                    typesAvailable() {
                      console.table(this.types)

                      // return 
                      if (this.types.length > 0) {
                        return true;
                      }
                      return false;
                    },      
                    isValid() {
                        return this.bus.regNumber != '' && 
                                this.bus.numberPlate != '' &&
                                this.bus.typeId != '' &&
                                this.bus.description != '' && 
                                this.bus.routeId != '' 
                    }
                }, 
                methods: {
                  // ...mapActions('bus', [
                  //   'addBus',
                  //   'updateBus',
                  //   'deleteBus',
                  //   'getBusTypes', 
                  //   'getBuses',
                  //   'sortByBusId',
                  //   'sortByRegNumber',                    
                  // ]),
                  ...mapActions('type', [
                    'getBusTypes'
                  ]),
                  // typesAvailable() {
                  //     console.table(this.types)

                  //     // return 
                  //     if (this.types.length > 0) {
                  //       return true;
                  //     }
                  //     return false;
                  //   },      
                  showTheModal(modalId) {                    
                    $(`#${modalId}`).modal({
                      backdrop: 'static'
                    })
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
                  actionAlert(name) {
                      swal({           
                        title: name,
                        text: 'Added successfully!',
                        icon: "success",
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
                      this.addBus({
                        bus: this.bus, 
                        numberOfSeat: this.numberOfSeat
                      });
                      this.loading = false;
                      this.actionAlert('Bus');
                      this.actionStatus = 'Added';
                      this.reset();
                      this.alertType = 'success';
                      this.showAlert = true;
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
                    this.updateBus({
                      bus: this.bus,
                      busToEdit: this.busToEdit
                    });
                      this.loading = false;
                      this.actionStatus = 'Updated';
                      this.reset();
                      this.alertType = 'success';
                      this.showAlert = true;
                  },

                  enableScroll() {
                    //initializes the plugin with empty options
                    $('#scrollbar').overlayScrollbars({ /* your options */ 
                      sizeAutoCapable: true,
                      scrollbars: {
                        autoHide: "never",
                        clickScrolling: true
                      }
                    }); 
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
                      .then((value) => {
                        if (value) {

                          vm.loading = true;
                          vm.response = '';
                          vm.showAlert = false;
                          vm.deleteBus(bus.id);

                          // axios.delete('/buses/'+bus.id)
                          // .then(function (response) {               
                          //     response.data.error ? vm.error = response.data.error : vm.response = response.data;
                          //     if (vm.response) {               
                          //         vm.removeBusFromAvailableBusList(bus.id); // update the array after removing
                          //         vm.loading = false;
                          //         vm.actionStatus = 'Removed';
                          //         vm.alertType = 'danger';
                          //         vm.showAlert= true;
                          //         return;                      
                          //     }                            
                          //     vm.loading = false;
                          // }); 
                          vm.loading = false;
                          vm.actionStatus = 'Removed';
                          vm.alertType = 'danger';
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
</style>