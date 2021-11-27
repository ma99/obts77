<template>
  <div class="content-wrapper">    
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Route Cities</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">
                  <i class="fa fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">Route Cities</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <section class="content">      
      <error-modal modal-id="error" :error-list="errorList" />

      <show-alert :show.sync="showAlert" :type="alertType">               
       <strong> City </strong> has been <strong>{{ actionStatus }} </strong>
      </show-alert>        
      <loader :show="loading"></loader>
      
      <div class="d-md-flex">
        <div class="p-3 bg-lightpurple flex-fill">
          <form>

            <route-list id="route" v-model="routeId" />

            <!-- expand -->
            <div class="mt-4 mb-2 p-2 rounded" style="background-color: hsla(261, 100%, 86%, 1);">
              <div class="p-1" @click="expand=!expand" style="cursor: pointer;">
                <span class="fa-stack fa-2x" v-show="!expand">
                  <i class="fas fa-circle fa-stack-2x" style="color: hsla(263, 94%, 62%, 1);"></i>
                  <i class="far fa-edit fa-stack-1x fa-inverse" style="color: hsla(261, 79%, 71%, 1);"></i>
                </span>
                <span class="h5 text-secondary" v-show="!expand">Add New Entry</span>
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
            
                <div class="form-group">
                <label for="city">First City</label>
                  <select v-model="firstCity" class="form-control custom-select"> 
                      <option value="" disabled>Please select one</option>
                      <option v-for="city in availableCityList"
                           v-bind:value="{
                                id: city.id,
                                name: city.name
                            }"
                        >
                          {{ city.name }}
                      </option>                                             
                  </select>
                </div>

                <div class="form-group">
                <label for="city">Second City</label>
                  <select v-model="secondCity" class="form-control custom-select"> 
                      <option value="" disabled>Please select one</option>
                      <option v-for="city in availableCityList"
                           v-bind:value="{
                                id: city.id,
                                name: city.name
                            }"
                        >
                          {{ city.name }}
                      </option>                                             
                  </select>
                </div>  

                <div class="form-group">
              <label for="cityDistance">Distance: </label>              
              <small v-show="secondCity.name" class="text-muted font-italic ml-2"> {{ firstCity.name }} to {{ secondCity.name }}
              </small> 

              <div class="input-group">
                <input v-model="distance" type="number" class="form-control" v-bind:class="{ 'is-invalid': has('distance') }" name="city_distance" id="cityDistance" placeholder="Enter distance in km here">
                <div class="input-group-append">
                  <span class="input-group-text">km</span>
                </div>
                <span class="invalid-feedback" v-if="has('distance')" v-text="get('distance')">
                </span>
              </div>              
                </div>

                <div v-if="has('first_city_id')" class="mb-2">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <h4 class="alert-heading">
                    <i class="fas fa-bell bg-danger rounded-lg p-2 mr-2"></i>
                  Oops!                  
                  </h4>
                  <p class="ml-5"> <strong>{{ firstCity.name }} - {{ secondCity.name }} </strong> already exists or invalid!</p>
                </div>
                
                </div> 
                <div class="text-center mt-4">
              <div class="button-group">
              <!-- <div class="button-group text-center mt-4"> -->
              <button @click.prevent="save()" class="btn btn-primary mr-2 px-5" :disabled="!isValid">
                <i class="far fa-save mr-2"></i>
              Save
              </button>                     
              <button @click.prevent="reset('all')"  class="btn btn-warning">
                <i class="far fa-window-close"></i>
                Cancel
              </button>
              </div>
                </div>
              </div>
            </div> <!-- end expand -->
          </form>          
        </div>
        <div class="p-3 bg-app-purple flex-fill">
            <div v-if="!citiesAvailable" class="text-center mt-2">
              <span class="fa-stack text-shadow" style="font-size: 4.5em;">
                <i class="fas fa-circle fa-stack-2x" style="color: hsl(261, 77%, 75%)"></i>
                <i class="fas fa-route fa-stack-1x" style="color: hsl(263, 94%, 62%)"></i>
              </span>         
            </div>
            <!-- Errors Display -->
            <div class="text-info text-center h4 mt-3" v-if="has('route-cities')">
            <i class="fas fa-info bg-info rounded-lg px-3 py-2 mr-2"></i>
              Citis {{ get('route-cities') }}
            </div>

            <div class="card mt-1" v-show="citiesAvailable">              
              <div class="card-body p-0">
                  <div class="scrollbar">
                    <table class="table table-striped table-hover">
                        <thead class="bg-info">
                          <tr>
                            <th>SL.# </th>
                            <th>CITY</th>
                            <th></th>
                            <th>CITY</th>
                            <th>DISTANCE (km)</th>
                            <th>ACTION</th>                
                            <!-- <th>&nbsp;</th> -->
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="(city, index) in citiesByRoute" >                              
                            <td>{{ index+1 }}</td>                      
                            <td>{{ getCityById(city.pivot.first_city_id).name }}</td>
                            <td> <i class="fas fa-exchange-alt"></i> </td>
                            <td>{{ getCityById(city.pivot.second_city_id).name }}</td>
                            <td>{{ city.pivot.distance }}</td>
                            <td>                              
                                <button @click.prevent="remove(city)" class="btn btn-outline-danger">
                                  <i class="button-icon fas fa-trash mr-2"></i>Remove
                                </button> 
                            </td>                        
                          </tr>                            
                        </tbody>
                    </table>      
                  </div>
              </div>    
              <div class="card-footer">
                <h5 class="px-1" v-show="citiesAvailable">                   
                  {{ citiesByRoute.length }}
                  <small class="text-muted mr-1"> 
                    <span v-if="citiesByRoute.length > 1"> cities </span> 
                    <span v-else> city </span>
                    available for
                  </small>
                  <strong>{{ route.first_city }} <i class="fas fa-exchange-alt"></i> {{ route.second_city }}</strong>
                </h5>
              </div>        
            </div>

        </div>        
      </div>      
    </section>
  </div>      
</template>
<script>
    import Route from '../../components/route/Route'; 
    import ErrorModal from '../../components/ErrorModal'; 

    import { mapState, mapGetters, mapActions } from 'vuex';

    export default {        
        components: {
            'route-list': Route,
            'error-modal': ErrorModal,
        },
        data() {
                return {                    
                    actionStatus: '',
                    alertType: '',                      
                    loading: false,                   
                    showAlert: false,
                    show: false,                    
                    modal: false,               
                    firstCity: {
                      id: '',
                      name: '',
                    },
                    secondCity: {
                      id: '',
                      name: '',
                    },
                    distance: '',
                    routeId: '',
                    route: {
                      // id: '',
                      // first_city: '',
                      // second_city: '',
                    },
                    citiesToBeAdded: {
                        first_city: '',
                        second_city: '',
                    },
                    errorList: [],
                    expand: false,
                    instanceOfScrollbar: undefined,
                }
                },
                async mounted() {                    
                    //this.fetchCities();
                    //this.fetchRoutes();
                    this.loading = true;
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
                    this.emptyCitiesByRoute();
                },
                watch: {
                    'routeId'(val, oldVal) {
                      if (this.routeId) {
                        this.loading = true;
                        this.resetErrors();
                        this.emptyCitiesByRoute();
                        this.firstCity = '';
                        this.secondCity = '';
                        this.route = this.getRouteBy(this.routeId);
                        this.fetchCitiesByDivisionOfFirstAndSecondCity(this.route);
                      }
                    },
                    'firstCity.name'(val, oldVal) {
                      this.distance = '';
                    },
                    success() {
                        if (this.success) {
                            this.actionAlert(this.citiesToBeAdded);
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
                        'success',                        
                    ]),
                    ...mapGetters([
                        'get',
                        'has',
                        'any'
                    ]),
                  
                  ...mapState('route', [
                      'citiesByRoute'
                  ]),
                    ...mapGetters('route', [
                        'getRouteBy',
                    ]),

                  ...mapState('city', [
                      'availableCityList'
                  ]),

                  ...mapGetters('city', [
                      'getCityBy',
                      'getCityById',
                      'availableCitiesCount'  
                  ]),
                  citiesAvailable() {
                      if (this.citiesByRoute.length > 0) {
                       return true;
                      }
                      return false;
                  },
                  isValid() {
                    return this.firstCity.id != '' && 
                            this.firstCity.name != '' &&
                            this.secondCity.id != '' &&
                            this.secondCity.name != '' &&
                            this.distance != '' 
                  }
                },
                methods: {  
                    ...mapActions([
                        'setSuccess',
                        'resetErrors'
                    ]),
                  ...mapActions('route', [
                    //'getRoutes',
                    'getCitiesFromRoutesBy',
                    'addRouteCity',
                    'deleteCityFromRoute',
                    'emptyCitiesByRoute'
                  ]),

                  ...mapActions('city', {
                    getAvailableCities: 'getBusAvailableToCities',
                    getCitiesByDivisionOf: 'getCitiesByDivisionOfFirstAndSecondCity'
                  }),

                  actionAlert(city) {
                      swal({           
                        title: `${city.first_city} <> ${city.second_city}`,
                        text: 'Added successfully!',
                        icon: "success",
                        timer: 2000,
                        closeOnClickOutside: false,
                      });
                  },                  
                  objectToEmptyString() {
                    // To display ('Please select one') first disabled option in SELECT box
                    this.firstCity = '';
                    this.secondCity = '';
                    this.route = '';
                  },                                    
                  async save() {
                    this.loading = true;
                    this.citiesToBeAdded = {
                        first_city: this.firstCity.name, 
                        second_city: this.secondCity.name, 
                    };
                    let data = {
                      first_city_id: this.firstCity.id,
                      second_city_id: this.secondCity.id,
                      distance: this.distance,
                    };
                    await this.addRouteCity({
                        data: data,                        
                        id: this.route.id
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
                  
                  // fetchCities() {
                  //   this.loading = true;
                  //   this.getAvailableCities();
                  //   this.loading = false;
                  // },
                  // fetchRoutes() {
                  //   this.loading = true;
                  //   this.getRoutes();                    
                  //   this.loading = false;
                  // },
                  async fetchCitiesByDivisionOfFirstAndSecondCity(route) {
                    let firstCity = this.getCityBy(route.first_city);
                    let secondCity = this.getCityBy(route.second_city);
                    
                    this.getCitiesByDivisionOf({
                      firstCityDivId: firstCity.division_id ,
                      secondCityDivId: secondCity.division_id 
                    });                    
                    
                    await this.getCitiesFromRoutesBy(route.id);
                    this.loading = false;
                  },
                  remove(city) { 
                      var vm = this;
                      swal({
                        title: "Are you sure?",
                        text: "This city will be Removed!",
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

                          // await vm.deleteCityFromRoute({
                          //   city: city.id, 
                          //   route: vm.route.id
                          // });
                          await vm.deleteCityFromRoute({
                            id: city.pivot.id,
                            route: vm.route.id
                          });

                          vm.actionStatus = 'Removed';
                          vm.alertType = 'danger';
                          vm.loading = false;
                          vm.showAlert= true;
                        }                   
                      }); 
                  },
                  
                  reset(all) { 
                    if(all) {                        
                      this.firstCity = '';
                      this.secondCity = '';
                      this.route = '';
                      this.routeId = '';
                      this.emptyCitiesByRoute();
                      this.resetErrors();
                      // $('.alert').alert('close');
                      return;
                    }                 
                    this.resetErrors();
                    this.firstCity = '';
                    this.secondCity = '';     
                    this.distance = '';
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
  // .fa-stack { font-size: 4.5em; }
  .table thead th {
    border-bottom: 1px solid hsl(188, 78%, 41%);
  } 
</style>