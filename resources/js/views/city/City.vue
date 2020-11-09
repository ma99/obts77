<template>
  <div class="content-wrapper">         
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">City</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item">
                <router-link :to="{ name: 'dashboard' }">
                  <i class="fa fa-tachometer nav-icon"></i> Dashboard
                </router-link>
              </li>
              <li class="breadcrumb-item active">City</li>
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
              icon-inner="fa-city" 
              icon-outer="fa-circle" 
              icon-color="hsla(202, 52%, 49%, .8)"
              text-color="hsla(202, 52%, 52%, 1)"
              :shadow="true"
            >
              Add City
            </header-icon>
          </template>

          <div class="row no-gutters">
            <div class="col-sm-8 rounded-left bg-lightyellow">
              <form> 
                <div class="form-row p-3 justify-content-center">
                  <div class="col-sm-7">               
                    <divisions v-model="selectedDivision" /> 
                    
                  </div>
                  <div class="col-sm-7">
                      <districts v-model="selectedDistrict" :division="selectedDivision" />
                  </div>
                  <div class="col-sm-7">
                    <upazilas v-model="selectedUpazila" :district="selectedDistrict" />
                  </div>              

                  <div class="col-sm-7">
                    <div class="form-group">
                      <label for="cityName">City Name</label>
                      <input v-model="selectedCity.name" type="text" class="form-control" name="city_name" id="cityName" placeholder="City Name" disabled>
                    </div>
                  </div>
                  <div class="col-sm-7 text-center my-2">
                    <div class="button-group">
                      <button @click.prevent="save()" class="btn btn-primary mr-2" :disabled="!isValid"> <i class="far fa-save mr-2"></i>
                      Save
                    </button>
                      <button @click.prevent="reset()" class="btn btn-warning" :disabled="!isValid"><i class="far fa-window-close mr-2"></i>

                      Cancel</button>
                    </div>
                  </div>
                </div>
              </form>      
            </div>
            <div class="col-sm-4 rounded-right bg-aliceblue">
              <div class="text-center mt-5">
                <span class="fa-stack">
                  <i class="fas fa-circle fa-stack-2x" style="color: #228be6"></i>
                  <i class="fas fa-city fa-stack-1x" style="color: #74C0FC"></i>
                </span>         
              </div>                              
            </div>
          </div>                
        </add-section>
        <error-modal modal-id="error" :error-list="errorList" />
        <loader :show="loading"></loader>

        <show-alert :show.sync="showAlert" :type="alertType">
          <strong>{{ cityName }} </strong> has been 
          <strong> {{ actionStatus }} </strong> successfully!
        </show-alert>
      
        <div class="row justify-content-center py-3">
          <div class="card card-secondary w-100">
            <div class="card-header">Service Available City Info                       
            </div>
            <div class="card-body p-0">
                <div class="scrollbar">
                  <table class="table table-striped table-hover">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>District ID
                          <span type="button" @click="isSortingAvailableBy('district')" :disabled="!disableSorting">
                            <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                          </span>
                        </th>
                        <th>City ID</th>
                        <th>City
                             <span type="button" @click="isSortingAvailableBy('name')" :disabled="disableSorting">
                                <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                            </span>
                        </th>                        
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(city, index) in cityList">
                        <td>{{ index+1 }}</td>                              
                        <td>
                          <span data-toggle="tooltip" data-placement="top" :title="district.name" @mouseover="getNameOf(city)">
                            <high-light color="#4eb3f3" value="5"> {{ city.district_id }} </high-light>
                          </span>
                        </td>                              
                        <td>{{ city.id }}</td>                              
                        <td>{{ city.name }}</td>                              
                        <td> 
                            <button @click.prevent="remove(city)" class="btn btn-outline-danger">
                              <i class="fas fa-trash mr-2"></i>Remove
                            </button>  
                        </td>                  
                      </tr>                            
                    </tbody>
                </table>                        
                </div>
            </div>      
            <div class="card-footer">
              <h5 class="px-1"> 
                {{ cityList.length }} 
                <small class="text-muted"> cities available.</small>
              </h5>          
            </div>          
          </div>
        </div>           
      </div> <!-- container fluid -->     
    </section>        
  </div>      
</template>
<script>
    import Divisions from '../../components/city/Divisions'; 
    import Districts from '../../components/city/Districts'; 
    import Upazilas from '../../components/city/Upazilas'; 
    import ErrorModal from '../../components/ErrorModal'; 

    import { mapState, mapGetters, mapActions } from 'vuex';

    export default {
        components: {
            Divisions,
            Districts,
            Upazilas,
            'error-modal': ErrorModal,
        },
        data() {
          return {
            actionStatus: '',
            alertType: '',            
            cityName: '',
            district: '',            
            disableSorting: true,
            // error: '',
            errorList: [],
            instanceOfScrollbar: undefined,
            loading: false,
            // response: '',
            selectedCity: {
              division_id: '',
              district_id: '',
              name: ''
            },            
            selectedDivision: '',
            selectedDistrict: '',
            selectedUpazila: '',
            show: false,
            showAlert: false,  
          }
        },
        async mounted() {                      
           this.loading = true;
           await this.getBusAvailableToCities();
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
            selectedDivision() {
                this.selectedDistrict = '';
                this.selectedCity.name ='';
            },
            selectedDistrict() {               
                this.selectedUpazila = '';
                this.cityToBeAdded();
            },
            selectedUpazila() {
              this.cityToBeAdded();
            },
            success() {
              if (this.success) {
                  this.loading = false;
                  this.actionAlert(this.cityName);
                  this.reset();
                  // this.resetErrors();
                  this.setSuccess({ status: false });
                  this.actionStatus = 'Added';
                  this.alertType = 'success';
                  // this.showAlert = true; 
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
          ...mapState('city', [
              'cityList'
          ]),

          ...mapGetters('city', [
              'cityBy',
          ]),

          citiyAvailable() {
          if (this.cityList.length > 0) {
            return true;
          }
          return false;          
        },
          isValid() {
            return this.selectedCity != '' &&
              this.selectedDistrict != '' &&
              this.selectedDivision != ''
          },
        },
        methods: {
            ...mapActions([
              'resetErrors',
              'setSuccess'
            ]),
            ...mapActions('city', [
                'addCity',
                'deleteCity',
                'getBusAvailableToCities',
                'sortCitiesByName',
                'sortCitiesByDistrict'
            ]),

          cityToBeAdded() {
            this.selectedCity.division_id = this.selectedDivision;
            this.selectedCity.district_id = this.selectedDistrict;
            if (this.selectedUpazila != '') {
              this.selectedCity.name = this.selectedUpazila;
              return;
            }

            if (this.selectedDistrict != '') {

            let district = this.cityBy(this.selectedDistrict);            
            this.selectedCity.name = district.name; 
            }
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
          getNameOf(city) {
            this.district = this.cityBy(city.district_id);            
          },
          isSortingAvailableBy(val) {
            if (val== 'name') {
                this.sortCitiesByName();
                this.disableSorting = true;
                return;
            }
            this.sortCitiesByDistrict();
            this.disableSorting = false;
          },
          remove(city) {  
            var vm = this;
            this.cityName = city.name; 
            swal({
              title: "Are you sure?",
              text: "This CITY will be Removed!",
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
                // vm.response = '';
                vm.showAlert = false;

                await vm.deleteCity(city.id);                
                vm.actionStatus = 'Removed';
                vm.alertType = 'danger';
                vm.loading = false;
                vm.showAlert= true;
              }               
            }); 
          },                   
          save() {            
            this.loading = true;
            this.cityName = this.selectedCity.name;
            this.addCity(this.selectedCity);
            // this.addCity(city);
            // this.loading = false;                
            // this.actionAlert(this.selectedCity.name);
            // this.reset();
          },
          reset() {
            this.selectedCity = {
              division_id: '',
              district_id: '',
              name:  ''
            };
            this.selectedDistrict = '';
            this.selectedUpazila = '';
            this.selectedDivision = '';

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
          sortByCityNamecityList(arr) {
            // sort by name            
                arr.sort(function(a, b) {
                  var nameA = a.name.toUpperCase(); // ignore upper and lowercase
                  var nameB = b.name.toUpperCase(); // ignore upper and lowercase
                  if (nameA < nameB) {
                    return -1;
                  }
                  if (nameA > nameB) {
                    return 1;
                  }

                  // names must be equal
                  return 0;
                });
          },
          sortByDistrictcityList(arr) {
            arr.sort((a, b) => {
              return a.district_id - b.district_id;
            });                            
          },
          actionAlert(cityName) {
              swal({           
                title: cityName,
                text: 'Added successfully!',
                icon: "success",
                timer: 2000,
                closeOnClickOutside: false,
              });
          }
        }
    }
</script>
<style lang="scss" scoped>  
  .fa-stack { font-size: 4.5em; }
</style>