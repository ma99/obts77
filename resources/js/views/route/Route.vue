<template>
    <section class="content">
      <div class="container-fluid">
        <add-section :show.sync="show">
          <template v-slot:heading>
            <header-icon 
              icon-inner="fa-route" 
              icon-outer="fa-circle" 
              icon-color="hsla(263, 90%, 58%, .8)"
              text-color="hsla(263, 89%, 74%, 1)"
              :shadow="true"
            >
              Add Route
            </header-icon>
          </template>
          <form>     
            <!-- <div class="row justify-content-center"> -->
              <!-- <div class="col-sm-7"> -->
                <box 
                  background-color="hsla(261, 63%, 80%, 1)" 
                  border-radius=".5"
                  heading-background="hsla(261, 70%, 85%, 1)" 
                  heading-border-radius="5"
                  heading-width="11.25" 
                  heading-show="true"
                  :shadow="true"
                >
                  <template v-slot:heading>First City Info</template>
                  <div class="row justify-content-center">
                    <div class="col-sm-5">
                      <divisions id="firstCityDiv" v-model="selectedDivisionForFirstCity" />
                    </div>
                    <div class="col-sm-5">
                      <cities id="firstCityDistrict" v-model="selectedDistrictForFirstCity" :division="selectedDivisionForFirstCity" />
                    </div>
                  </div>
                </box>
              <!-- </div>  -->

              <!-- <div class="col-sm-7"> -->
                <box 
                  background-color="hsla(22, 75%, 73%, 1)"
                  border-radius=".5"
                  :margin='{top: 3, bottom: 2.1875}'
                  heading-background="hsla(22, 81%, 78%, 1)" 
                  heading-border-radius="5"
                  heading-width="11.25" 
                  heading-show="true"
                  :shadow="true"
                >
                  <template v-slot:heading>Second City Info</template> 
                  <div class="row justify-content-center">
                    <div class="col-sm-5">
                      <divisions id="secondCityDiv" v-model="selectedDivisionForSecondCity" />
                    </div>
                    <!-- City-->
                    <div class="col-sm-5">
                      <cities id="secondCityDistrict" v-model="selectedDistrictForSecondCity" :division="selectedDivisionForSecondCity" />
                    </div>
                  </div>
                </box>
              <!-- </div> -->

              <!-- <div class="col-12 px-4 py-3 bg-skyblue rounded-xlg shadow"> -->
              <box 
                  background-color="hsla(199, 70%, 80%, 1)"
                  border-radius=".5"
                  :margin='{top: 3, bottom: 2.1875}'
                  heading-background="hsla(199, 79%, 85%, 1)" 
                  heading-border-radius="5"
                  heading-width="11.25" 
                  heading-show="true"
                  :shadow="true"
                >
                  <template v-slot:heading>Route Info</template>
                  <div class="row justify-content-center">
                    <div class="col-sm-6">
                      <div class="form-group">
                        <label for="routeDistance">Distance</label>

                        <div class="input-group">
                          <input v-model="routeDistance" type="number" class="form-control" v-bind:class="{ 'is-invalid': has('distance') }" name="route_distance" id="routeDistance" placeholder="Enter distance in km here">
                          <div class="input-group-append">
                            <span class="input-group-text">km</span>
                          </div>
                          <span class="invalid-feedback" v-if="has('distance')" v-text="get('distance')"></span>
                        </div>
                      </div>
                    </div>
                  </div>
              </box>
              <!-- </div>                     -->
              <div v-if="has('first_city')" class="col-12 mb-2">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <h4 class="alert-heading">
                    <i class="fas fa-bell bg-danger rounded-lg p-2 mr-2"></i>
                  Oops!
                  <!-- <button type="button" class="close float-right" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button> -->
                  </h4>
                  <!-- <p class="ml-5" v-text="get('first_city')"></p> -->
                  <p class="ml-5">
                    <strong> {{ routeName}} </strong> already exists or invalid!
                  </p>
                </div>
                
              </div>  
              <div class="col-12 text-center my-4">
                <div class="button-group">
                  <button @click.prevent="save()" class="btn btn-primary mr-2 px-5" :disabled="!isValid"> <i class="far fa-save mr-2"></i>
                  Save
                </button>
                  <button @click.prevent="reset()" class="btn btn-warning" :disabled="!isValid"><i class="far fa-window-close mr-2"></i>

                  Cancel</button>
                </div>
              </div>
            <!-- </div> -->
          </form>  
        </add-section>

        <error-modal modal-id="error" :error-list="errorList" />

        <loader :show="loading"></loader>

        <show-alert :show.sync="showAlert" :type="alertType">               
          <strong>{{ routeName }} </strong> has been 
          <strong> {{ actionStatus }} </strong> successfully!
        </show-alert>

        <div class="row justify-content-center py-3">
          <div class="card w-100">
            <!-- <div class="card-header">Route Info 
              <span class="float-right">
                <high-light 
                  color="hsla(210, 9%, 30%, 1)" 
                  value="5"
                  :shadow="true"
                >
                  {{ availableRouteList.length }}
                </high-light>
              </span>
            </div> -->
            <div class="card-body p-0">
                <div class="scrollbar">
                  <table class="table table-striped table-hover">
                      <thead class="bg-secondary">
                        <tr>
                          <th>Sl. No.</th>
                          <th>From
                                <span type="button" @click="isSortingAvailableBy('name')" :disabled="disableSorting">
                                  <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                                </span>
                          </th>
                          <th>To</th>
                          <th>Distance
                            <span type="button" @click="isSortingAvailableBy('distance')" :disabled="!disableSorting">
                                  <i class="fas fa-sort-amount-asc" aria-hidden="true"></i>
                                </span>
                          </th>
                          <th>
                            Route ID
                          </th>
                          <th>
                            Action
                          </th>
                          <!-- <th>&nbsp;</th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr  v-for="(route, index) in availableRouteList">                              
                          <td>{{ index+1 }}</td>                              
                          <td>{{ route.first_city }}</td>
                          <td>{{ route.second_city }}</td>                              
                          <td>{{ route.distance }}</td>                          
                          <td><strong>{{ route.id }}</strong></td>
                          <td>
                              <button @click.prevent="remove(route)" class="btn btn-outline-danger">
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
                {{ availableRouteList.length }} 
                <small class="text-muted"> routes available.</small>
              </h5>          
            </div>                      
          </div>
        </div>
      </div>            
    </section>        
</template>
<script>    
    import Divisions from '../../components/city/Divisions'; 
    // import Districts from '../../components/city/Districts'; 
    import Cities from '../../components/city/Cities';
    import ErrorModal from '../../components/ErrorModal';  
    import Box from '../../components/Box';  

   import { mapState, mapGetters, mapActions } from 'vuex';

    export default {
        components: {
            Divisions,
            Cities,
            Box,
            'error-modal': ErrorModal,
        },
        data() {
          return {
            actionStatus: '',
            alertType: '',
            disableSorting: true,
            errorList: [],
            instanceOfScrollbar: undefined,
            loading: false,
            routeDistance: '',
            routeId: '',
            routeName: '',
            selectedDistrictForSecondCity: '',
            selectedDistrictForFirstCity: '',
            selectedDivisionForSecondCity: '',
            selectedDivisionForFirstCity: '',
            show: false,
            showAlert: false,  
          }
        },
        async mounted() {           
           //this.fetchAvailableRoutes();
           this.loading = true;
           await this.getRoutes();
           this.loading = false; 

           if (this.any(this.errors)) {
            this.setListOf(this.errors, this.errorList)
            }

           this.enableScroll();           
        },
        beforeUnmount() {
            this.instanceOfScrollbar.destroy();
            $().alert('dispose');  
            this.resetErrors();
        },
        watch: {
            success() {
                if (this.success) {
                    this.loading = false;
                    this.actionAlert(this.routeName);
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
                'get',
                'has',
                'any'
            ]),
            ...mapGetters('city', [
                'getCityById'
            ]),
          ...mapState('route', [
                      'availableRouteList',
            ]),

          isValid() {
            return this.selectedDistrictForFirstCity != '' &&
              this.selectedDistrictForSecondCity != '' 
              // &&
              // this.routeDistance != ''
          }
        },
        methods: {
            ...mapActions([
                'setSuccess',
                'resetErrors'
            ]),
            ...mapActions('route', [
                    'addRoute',
                    'deleteRoute',
                    'getRoutes',
                    'sortRoutesByCityName',
                    'sortRoutesByDistance'  
            ]),

          actionAlert(routeName) {
              swal({           
                title: routeName,
                text: 'Added successfully!',
                icon: "success",
                timer: 2000,
                closeOnClickOutside: false,
              });
          },

          setCity() {
            let firstCity = this.getCityById(this.selectedDistrictForFirstCity);
            let secondCity = this.getCityById(this.selectedDistrictForSecondCity);
             
            return {
                firstCity: firstCity.name,
                secondCity: secondCity.name,
                routeName: `${firstCity.name} - ${secondCity.name}` 
            }            
          },          
          save() {
            this.loading = true;
            let city = this.setCity();
            this.routeName = city.routeName;
            
            let data = {
                first_city: city.firstCity,
                second_city: city.secondCity,
                distance: this.routeDistance,
            }

          this.addRoute(data);
             
          // this.loading = false;
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
          
          // fetchAvailableRoutes() {
          //   this.loading = true;
          //   this.getRoutes();
          //   this.loading = false;          
          // },          
          isSortingAvailableBy(val) {
            if (val== 'name') {
                this.sortRoutesByCityName();
                this.disableSorting = true;
                return;
            }
            this.sortRoutesByDistance();
            this.disableSorting = false;
          },
          remove(route) {  // role id of user/staff in roles table
            var vm = this;            
            this.routeName = `${route.first_city}  to  ${route.second_city}`;

            swal({
              title: "Are you sure?",
              text: `This ${this.routeName} ROUTE will be Removed!`,
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
            .then(async (value) => {
              if (value) {
                vm.loading = true;
                vm.showAlert = false;
                
                await this.deleteRoute(route.id);

                vm.actionStatus = 'Removed';
                vm.alertType = 'danger';
                vm.loading = false;
                vm.showAlert= true;
              } 
            }); 
          },         
          reset() {
            this.selectedDistrictForSecondCity = '',
            this.selectedDistrictForFirstCity = '',
            this.selectedDivisionForSecondCity = '';
            this.selectedDivisionForFirstCity = '';
            this.routeDistance = '';

            // $('.alert').alert('close');

            this.resetErrors();
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
        }
    }
</script>
<style lang="scss" scoped>
</style>