<template>
  <div class="content-wrapper">    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Fare</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">
                  <i class="fa fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">Fare</li>
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
              icon-inner="fa-file-invoice" 
              icon-outer="fa-circle" 
              icon-color="hsla(123, 38%, 64%, .8)"
              text-color="hsla(123, 38%, 67%, 1)"
              :shadow="true"
              :visible="!editMode"
            >
            Add Fare
            </header-icon>
            <header-icon 
              icon-inner="fa-edit" 
              icon-outer="fa-circle" 
              icon-color="hsla(36, 100%, 50%, .8)"
              text-color="hsla(36, 100%, 53%, 1)"
              :shadow="true"
              :visible="editMode"
            > 
            Edit Fare
            </header-icon> 
          </template>
          <form> 
                <!-- <border color="eastern-blue" pattern="dashed" width="1"                
                > -->
                  <!-- <template v-slot:heading>Set Fare</template>  -->
                  <!-- <div class="row"> -->
                    <!-- <div class="col-sm-12">       -->
                    <box                   
                      background-color="hsla(134, 50%, 73%, 1)" 
                      border-radius=".5"
                      :margin='{top: 1.5, bottom: 3}'
                      heading-background="hsla(134, 56%, 78%, 1)" 
                      heading-border-radius="5"
                      heading-width="11.25" 
                      heading-show="true"
                      :shadow="true"
                    >
                      <template v-slot:heading>Route Info</template>
                        <div class="form-row justify-content-center">
                        
                          <div class="col-sm-4">
                              <div class="form-group">
                                  <label for="route">Route</label>
                                    <select v-model="routeId" class="form-control custom-select" id="route" :disabled="editMode">
                                        <option disabled value="">Please select one</option>
                                        <option v-for="route in cityRouteList" v-bind:value="route.id">
                                            {{ route.id }}: {{ route.name }}
                                        </option>                                             
                                    </select>                      
                              </div>                              
                          </div>
                    
                          <div class="col-sm-5" v-if="!editMode">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select v-model="city" class="form-control custom-select" v-bind:class="{ 'is-invalid': has('city_route_id') }" id="city" :disabled="editMode">
                                    <option disabled value="">Please select one</option>
                                    <option v-for="city in citiesByRoute" v-bind:value="{
                                        id:city.id,
                                        name:getNameOfRoute(city),
                                        distance: `${city.distance} km`
                                    }"
                                    >
                                    {{ getNameOfRoute(city) }} : {{city.distance}} km
                                    </option>                                             
                                </select>
                                <span class="invalid-feedback" v-if="has('city_route_id')" v-text="get('city_route_id')">
                                </span>                      
                            </div>
                          </div>

                          <div class="col-sm-5" v-if="editMode">
                            <div class="form-group">
                                <label for="city">City</label>
                                <select class="form-control custom-select" id="city1" :disabled="editMode">
                                    <option>{{ cityName }} : {{cityDistance}} km</option>
                                                                
                                </select>
                                <span class="invalid-feedback" v-if="has('city_route_id')" v-text="get('city_route_id')">
                                </span>                      
                            </div>
                          </div>

                        </div>
                    </box>
                    <!-- </div> -->

                    <box 
                      background-color="hsla(188, 54%, 73%, 1)"
                      border-radius=".5" 
                      :margin='{top: 2, bottom: 2}'
                      :padding='{top: 1.5, bottom: 0.1}'
                      heading-background="hsla(188, 61%, 78%, 1)" 
                      heading-border-radius="5"
                      heading-width="11.25" 
                      heading-show="true"
                      :shadow="true"
                    >
                      <template v-slot:heading>Set Fare</template>

                      <div class="col-12 table-fare">
                        <!-- <h5>
                            Fare
                            <small class="text-muted">For Route Cities</small>
                        </h5> -->
                        <table class="table table-striped table-hover">
                          <thead><tr></tr></thead>
                          <tbody>
                                <tr>         
                                  <td v-for="(type, index) in types">
                                    <div class="form-group" v-show="isCombined(type)">
                                        <label>{{ type.name }}</label>
                                        <input v-model="fare[type.key]" type="text" v-bind:style="formControl" class="form-control" :placeholder="type.name" data-toggle="tooltip" data-placement="top" title="Use '|' i.e 800|900" required="required">
                                    </div>

                                    <div class="form-group" v-show="!isCombined(type)">
                                        <label>{{ type.name }}</label>
                                        <input v-model="fare[type.key]" type="number" v-bind:style="formControl" class="form-control" :placeholder="type.name" required="required">
                                    </div>
                                  </td>
                                </tr>                           
                          </tbody>
                        </table>      
                      </div>
                    </box>

                   <!--  <div class="col-sm-4 mt-3">
                      <div class="button-group">
                        <button v-on:click.prevent="save()"  type="button" class="btn btn-primary" v-show="!editMode" :disabled="!isValid">Save</button>
                        <button v-on:click.prevent="update()"  type="button" class="btn btn-success" v-show="editMode">Update</button>
                        <button v-on:click.prevent="reset()"  type="button" class="btn btn-warning" :disabled="!isValid">Cancel</button>
                      </div>
                    </div> -->
                  <!-- </div>   -->
                  <div class="col-12 text-center mt-2 mb-2">
                  <div class="button-group">
                    <button v-on:click.prevent="save()"  type="button" class="btn btn-primary mr-2" :disabled="!isValid" v-show="!editMode">
                      <i class="far fa-save mr-2"></i>
                    Save
                    </button>
                    <button v-on:click.prevent="update()"  type="button" class="btn btn-info mr-2" :disabled="!isValid" v-show="editMode">
                      <i class="fas fa-save mr-2"></i>
                      Update
                    </button>
                    <button v-on:click.prevent="reset()"  type="button" class="btn btn-warning">
                      <i class="far fa-window-close"></i>
                      Cancel
                    </button>
                  </div>
                </div>
                <!-- </border>             -->
          </form>            

          <!-- <template v-slot:footer>            
          </template> -->
        </add-section>

        <error-modal modal-id="error" :error-list="errorList" />

        <show-alert :show.sync="showAlert" :type="alertType"> 
              <!-- altert type can be success/info/warning/danger/dark -->
              <strong> Fare </strong> has been <strong>{{ actionStatus }} </strong>
        </show-alert>
        <loader :show="loading"></loader>
        <div class="row justify-content-center py-3">
          <div class="card w-100">
            <div class="card-body p-0">
                <div class="scrollbar rounded-top">
                  <table class="table table-striped table-hover">
                      <thead class="bg-secondary">
                        <tr>
                          <th>SL.# </th>                  
                          <th>ROUTE</th>            
                          <th>CITY</th>
                          <th>DISTANCE</th>
                          <th>FARE</th>
                          <th>Action</th>                                                         
                          <!-- <th>&nbsp;</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="(availableFare, index) in availableFareListByRoute" >                              
                          <td>{{ index+1 }}</td>    

                          <td>{{ availableFare.route }}</td>

                          <td>{{ availableFare.city }}</td>

                          <td>{{ availableFare.distance }}</td>

                          <td>                            
                            <ol class="fare"> 
                              <li v-for="(type, index) in types"> 
                                {{type.name}}: {{availableFare.details[type.key]}} 
                              </li>
                            </ol>
                          </td>
                          <td>
                            <div class="mb-2">           
                              <button type="button" class="btn btn-outline-info" v-on:click.prevent="edit(availableFare)">    
                                <i class="button-icon fas fa-pen"></i>Edit
                              </button>
                            </div>
                            <div>                                 
                              <button v-on:click.prevent="remove(availableFare)" class="btn btn-outline-danger">
                                <i class="button-icon fas fa-trash"></i>Remove
                              </button> 
                            </div>
                          </td>                        
                        </tr>                            
                      </tbody>
                  </table>      
                </div>
            </div>
            <div class="card-footer">
              <h5 class="px-1"> 
                {{ availableFareListByRoute.length }} 
                <small class="text-muted"> fares available.</small>
              </h5>                                   
            </div>            
          </div>
        </div>               
      </div>
    </section>        
  </div>      
</template>
<script>
  import Box from '../../components/Box';  
  import Route from '../../components/route/Route'; 
  import ErrorModal from '../../components/ErrorModal'; 

  import { mapState, mapGetters, mapActions } from 'vuex';

    export default {        
        components: {
            Box,
            'route-list': Route,
            'error-modal': ErrorModal,

        },

        data() {
                return {                    
                    actionStatus: '',
                    alertType: '',                    
                    editMode: false,
                    error: '',      
                    errorList: [],    
                    formControl: {
                      backgroundColor: '#fff',
                    },                                    
                    isDisabled: false,                    
                    instanceOfScrollbar: undefined,
                    loading: false,                                       
                    showAlert: false,
                    show: false,                    
                    // modal: false,               
                    fare: {},
                    fareToEdit: {
                      id: '',
                      index: '',
                      route: '',
                    },
                    city: {
                      id: '',
                      name: '',
                      distance: ''
                    },
                    routeId: '',                          
                }
            },
                watch: {
                    success() {
                        if (this.success) {
                          // this.actionAlert('Fare For', `${this.city.name} Added successfully!`, 'success');
                          this.loading = false;
                          let actionStatus = this.setActionStatus();
                          let icon = this.setIconBasedOn(actionStatus)
                          this.actionAlert('Fare', actionStatus, icon);
                          this.reset();
                          // this.resetErrors();
                          this.setSuccess({ status: false });
                        }
                    },
                    'routeId'(value, oldValue) {
                      if (this.editMode) return;
                      if (value) {
                        this.city = '';
                        this.getCitiesByRoute(value);
                      }
                    },
                },                
               async mounted() {          
                    this.loading = true;

                    await this.getRoutes();

                    await this.getBusAvailableToCities();
                    
                    await this.getRoutesCities();

                    await this.getBusTypes();

                    await this.getFares();
                    this.city = '';
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
                ...mapState('type', [
                  'types'
                ]),
                ...mapState('fare', [
                    'availableFareListByRoute'
                ]),
                ...mapGetters('fare', [
                    'getFareBy',
                    'getIndexOf'
                ]),
                ...mapGetters('route', [
                    // 'getRouteBy',
                    'cityRouteBy',                    
                ]),
                ...mapGetters('city', [
                    'getCityById'
                ]),
                ...mapState('route', [
                    'citiesByRoute',
                    'cityRouteList'
                ]),
                isValid() {
                  return this.city.id != '' &&
                    Object.keys(this.fare).length != 0  
                },
                cityName() {
                    return this.city.name;
                },
                cityDistance() {
                    return this.city.distance;
                },
              },
                methods: {
                    ...mapActions([
                    'setSuccess',
                    'resetErrors'
                    ]),
                    ...mapActions('type', [
                        'getBusTypes',
                    ]),
                    ...mapActions('fare', [
                        'getFares',
                        'addFare',
                        'deleteFare',
                        'updateFare'
                    ]),
                    ...mapActions('route', [
                        'getCitiesByRoute',
                        'getRoutes',
                        'getRoutesCities',
                        'emptyCitiesByRoute'
                    ]),                  
                    ...mapActions('city', [
                        'getBusAvailableToCities'
                    ]),
                  setActionStatus() {
                    if (this.editMode == true) {
                      this.actionStatus = 'Updated';
                      return 'Updated';
                    }
                    this.actionStatus = 'Added';
                    return 'Added';
                  },  
                  setIconBasedOn(status) {
                    return (status == 'Added') ?
                           'success' : 'info';
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
                  isCombined(type) {
                  
                    return type.key.includes('|') ? true : false;
                  },                  
                  getNameOfRoute(city) {
                    return `${this.getCityById(city.first_city_id).name}  - ${this.getCityById(city.second_city_id).name}`
                  },
                  typeBy(id) {
                    let type = this.types.find(type => type.id == id);
                    if(type) {                      
                      return type.name;
                    }
                  },
                  ucwords (str) {
                      return (str + '').replace(/^([a-z])|\s+([a-z])/g, function ($1) {
                          return $1.toUpperCase();
                      });                  
                  },                                      
                  save() {
                        this.loading = true;
                        this.addFare({
                          city_route_id: this.city.id,
                          details: this.fare
                        });                 
                  },
                  edit(fare) {
                    let fareToEdit = this.getFareBy(fare.id);
                  
                    this.fareToEdit = {
                        id: fare.id,
                        index: this.getIndexOf(fareToEdit),
                        route: fareToEdit.route,
                    }
                  
                    this.fare = fareToEdit.details;
                    
                    this.city = {
                        id: fareToEdit.city_route_id,
                        name: fareToEdit.city,
                        distance: fareToEdit.distance
                    };

                        // this.city.id = fareToEdit.city_route_id;
                        // this.city.name = fareToEdit.4;
                        // this.city.distance = fareToEdit.distance;
                    this.routeId =  fareToEdit.route_id;
                    this.editMode = true;
                    this.show = true;                    
                    this.formControl.backgroundColor = 'lightyellow';
                  },
                  update() {

                    this.loading = true;
                    this.updateFare({
                        id: this.fareToEdit.id,
                        index: this.fareToEdit.index,
                        city: this.city,
                        details: this.fare,
                        route: this.fareToEdit.route,
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
                  
                  // fetchCitiesBy(routeId) {
                  //   this.loading = true;
                  //   this.getCitiesFromRoutesBy(routeId);
                  // },                                    
                  async remove(fare) { 
                      var vm = this;
                       swal({
                        title: "Are you sure?",
                        text: "This fare will be Removed!",
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
                          //vm.loading = true;
                          vm.showAlert = false;
                          vm.removeFareBy(fare.id);
                        }                   
                      }); 
                  },
                  async removeFareBy(id) {
                    this.loading = true
                    await this.deleteFare(id);
                    this.loading = false;
                    this.actionStatus = 'Removed';
                    this.alertType = 'danger';
                    this.showAlert= true;

                  },                  
                  reset() {                       
                      this.emptyCitiesByRoute();
                      this.routeId = '';
                      this.city = '';
                      this.fare = {};
                      this.formControl.backgroundColor = '#fff';
                      this.editMode = false;

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
    
    .table-fare .table-striped tbody tr:nth-of-type(odd) {
        background-color: hsla(188, 54%, 73%, 1);
    }
    .table td {
      border-top: none;
    }
  ol.fare {
    margin-left: -1.7rem;  
  }
  // div.info-table .card .card-body {
  //   padding: 0;
  // }    
</style>