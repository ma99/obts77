<template>
    <section class="content">      
      <show-alert :show.sync="showAlert" :type="alertType">               
       <strong> City </strong> has been <strong>{{ actionStatus }} </strong>
      </show-alert>        
      <loader :show="loading"></loader>
      
      <div class="d-md-flex">
        <div class="p-3 bg-lightyellow flex-fill">
          <form>
            <divisions v-model="selectedDivision" /> 

            <div class="form-group">
                <label for="city">City</label>
                  <select v-model="selectedCity" class="form-control custom-select"> 
                      <option value="" disabled>Please select one</option>
                      <option v-for="city in citiesByDivisionList" v-bind:value="{ 
                        id: city.id, 
                        name: city.name, 
                        // latitude: city.latitude,
                        // longitude: city.longitude
                      }">
                              {{ city.name }}
                       </option>                       
                  </select>
            </div>
            <div class="bg-lightgreen rounded">              
            
              <div class="form-group px-3 pt-3">
                <label for="stopName">Name</label>
                <input v-model="stop.name" type="text" class="form-control" id="stopName" placeholder="Stop Name" :disabled="!selectedCity.id">
              </div>

              <div class="form-group px-3">
                <label for="stopAddress">Address</label>
                <input v-model="stop.address" type="text" class="form-control" id="stopAddress" placeholder="Address" :disabled="!selectedCity.id">
              </div>

              <div class="form-group px-3">
                <label for="stopPhone">Phone</label>
                <input v-model="stop.phone" type="text" class="form-control" id="stopPhone" placeholder="Phone" :disabled="!selectedCity.id">
              </div>

              <div class="form-group px-3">
                <label for="stopLat">Latitude</label>
                <input v-model="stop.latitude" type="text" class="form-control" id="stopLat" placeholder="Latitude" :disabled="!selectedCity.id">
              </div>

              <div class="form-group px-3 pb-3">
                <label for="stopLng">Longitude</label>
                <input v-model="stop.longitude" type="text" class="form-control" id="stopLng" placeholder="Longitude" :disabled="!selectedCity.id">
              </div>

            </div>

            <div class="mt-3 mb-2" v-show="stopList.length > 0">
            <!-- stops list -->            
              <div class="card shadow bg-white">
              <!-- <div class="card-header">Stops to be added</div> -->
              <div class="card-body p-0">
                <div class="scrollbar-small">
                  <table class="table table-striped table-hover table-sm">
                    <thead>
                      <tr>
                        <th>Sl. No.</th>
                        <th>Name                             
                        </th>
                        <th>City Name
                          <span type="button" @click="isSortingAvailableBy('cityName')" >
                                <i class="fas fa-sort-alpha-down" aria-hidden="true"></i>
                            </span>
                        </th>                        
                        <th>Action</th>                                                         
                        <!-- <th>&nbsp;</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      <tr  v-for="(stop, index) in stopList" >                              
                        <td>{{ index+1 }}</td>                              
                        <td>{{ stop.name }}</td>                              
                        <td>{{ getCityById(stop.city_id).name }}</td>                              
                        <!-- <td>{{ city.division }}</td> -->
                        <td> 
                            <button v-on:click.prevent="removeStopFromStopListAndMap(stop)" type="button" class="btn btn-danger">
                              <i class="far fa-times-circle"></i>
                            </button>  
                        </td>                        
                      </tr>                            
                    </tbody>
                  </table>      
                </div>
              </div>                     
              </div>
            </div>   <!-- stops list end -->

            <!-- errors  -->
            <div v-show="show" class="alert alert-warning" role="alert">
                <h4 class="alert-heading">
                  <i class="fas fa-exclamation-triangle text-red"></i>
                  <button type="button" class="close" aria-label="Close">
                    <span aria-hidden="true" v-on:click.prevent="show = false">&times;</span>
                  </button>
                </h4>                
                <span v-show="false"> {{ showError }}</span>
                <ul>
                  <li v-for="(error, index) in errors">
                    {{ getIndex(index) }} - {{ error[0] }}
                  </li>
                </ul>
              <!-- {{ get('bus_id') }} -->
            </div>
            <!-- errors end  -->

            <div class="text-center mt-4">
              <div class="button-group">
                <button v-on:click.prevent="addToStopList()" class="btn btn-info mr-2" :disabled="!stop.name">
                  <i class="far fa-plus-square mr-2" aria-hidden="true"></i>Add
                </button>                   
              
                <button @click.prevent="save()" class="btn btn-primary mr-2 px-5" :disabled="!isValid"> <i class="far fa-save mr-2"></i>
                    Save
                </button>
                <button @click.prevent="reset('all')" class="btn btn-warning" :disabled="!isValid"><i class="far fa-window-close mr-2"></i>
                Cancel</button>
              
            </div>
            </div>
          </form>
        </div>
        <div class="p-3 bg-warning flex-fill">

          <div class="d-flex flex-column bd-highlight">
            
            <add-section :show="true" :p-zero="true"> 
              <template v-slot:heading> Stops:
                <strong v-show="isStopsAvailable">
                  For {{ selectedCity.name }} is <span style="color: #FFC107"> {{ stopsByCity.length }} </span>
                </strong> 
              </template>
              <div class="p-2 bg-mediumyellow flex-fill">
            
                <div v-if="!isStopsAvailable" class="text-center mt-2">
                  <span class="fa-stack">
                    <i class="fas fa-circle fa-stack-2x" style="color: #FFC107"></i>
                    <i class="fas fa-bezier-curve fa-stack-1x" style="color: #FFE066"></i>
                  </span>         
                  <div v-show="selectedCity.id">
                    
                    <h3 class="text-muted mt-3"> <i class="fas fa-info-circle mr-2"></i>Stop not available!</h3>
                  </div>
                </div>                            

                <div v-show="isStopsAvailable" class="card w-100">
                <!-- <div class="card mt-1 w-100"> -->
                    <!-- <div class="card-header">
                      Available Stops for {{ selectedCity.name }} is <span> {{ stopsByCity.length }} </span>
                    </div> -->
                    <div class="card-body p-0">
                      <div class="scrollbar">
                        <table class="table table-striped table-hover table-sm">
                          <thead>
                            <tr>
                              <th>Sl. No.</th>
                              <th>Name </th>
                              <th>Address</th>
                              <th>Phone</th>
                              <th>Action</th>                 
                            </tr>
                          </thead>
                          <tbody>
                            <tr  v-for="(stop, index) in stopsByCity" >                              
                              <td>{{ index+1 }}</td>                              
                              <td>{{ stop.name }}</td>                              
                              <td>{{ stop.address }}</td>                              
                              <td>{{ stop.phone }}</td>                              
                              <!-- <td>{{ city.division }}</td> -->
                              <td> 
                                  <button v-on:click.prevent="removeStop(stop, index)" class="btn btn-danger">
                                    <i class="far fa-trash-alt mr-2"></i>Remove
                                  </button>  
                              </td>                        
                            </tr>                            
                          </tbody>
                      </table>          
                      </div>
                    </div>            
                </div>
              </div> 
            </add-section>  

            <add-section :p-zero="true">
              <template v-slot:heading>Map</template>
              <div class="p-2 flex-fill">
                <my-map 
                  :mcenter="setMapCenter"
                  :mreset="mapReset"
                  :marker-color-reset="newStopAdded"
                  :stops="mapStops" 
                  :remove-marker="stopRemoved"
                  @add-stop="addToStops"
                  @stop-added="resetMarkerColor"
                  @map-reseted="assignStops" 
                />                           
              </div>
            </add-section> 
          </div>
        </div>
      </div>      
    </section>
</template>
<script>
// import MyMap from '../../components/stops/Map'; 
import MyMap from "../../components/gmap/StopsMapLoader";
import Divisions from '../../components/city/Divisions'; 
import { mapState, mapGetters, mapActions } from 'vuex';
export default {
    components: {
            Divisions,
            MyMap
    },
    data() {
      return {
        actionStatus: '',
        alertType: '',
        //availableStopList: [],
        //cityList: [],
        cityName: '',            
        deletedStopName: '',
        //divisionList: [],
        disableSorting: true,
        // error: '',
        errorList: [],
        instanceOfScrollbar: undefined,
        instanceOfScrollbarTwo: undefined,
        loading: false,
        response: '',            
        selectedCity: {
          id: '',
          name: ''
        },            
        selectedDivision: '',
        show: false,
        showAlert: false,
        citiesByDivisionList: [],
        mapStops: [],
        mapReset: false,
        newStopAdded: false,
        stopList: [],
        stopListSize: null,
        stopsByCity: [],
        stops: [],
        multiStops: false,
        //stopName: '',
        stop: {
          name: '',
          address: '',
          phone: '',
          latitude: '',
          longitude: ''
        },
        stopRemoved: null,
        scrollbarInstanceOne: '',
        scrollbarInstanceTwo: ''
      }
    },    
    async mounted() {           
       //this.fetchDivisions();   
      this.loading = true;
      this.selectedCity = '';
      await this.getDistrictList();
      await this.getAvailableCities();              
      await this.getStops();
      this.loading = false;  

      // if (this.any(this.errors)) {
      //   this.setListOf(this.errors, this.errorList)
      // }

      this.enableScroll();
    },
    beforeUnmount() {
        this.instanceOfScrollbar.destroy();
        this.instanceOfScrollbarTwo.destroy();
        this.resetErrors();
    },    
    watch: {
      selectedDivision(value, oldValue) {
        if (value == '' || value == null) return;
        this.stopsByCity = [];
        this.selectedCity = '';
        this.citiesByDivisionList = this.citiesByDivision(value);
      },
      'selectedCity.id'(value, oldValue) {
          this.mapStops = [];
          this.stop = {};
          this.mapReset = true;
          
          if (value == '' || value == null) return;

          let stops = this.availableStopsBy(value);
          
          this.stopsByCity = stops; 

          // // this.mapStops = _.clone(stops);
      },
      success() {
          if (this.success) {
              this.actionAlert();
              this.stopsByCity = this.availableStopsBy(this.selectedCity.id);
              this.reset();
              // this.resetErrors();
              this.setSuccess({ status: false });
              this.actionStatus = 'Added';
              this.alertType = 'success';
              this.showAlert = true; 

              // this.multiStops = false;
              this.setMultiStops(false);
              // this.newStopAdded = true;
              this.setNewStopAdded(true);

          }
      },
      'stopList.length'(value) {
        console.log('stpL', value);
        if (value == 0) this.setMultiStops(false);
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
      ...mapGetters('stop', [
        'availableStopsBy',
        // 'stopsByCityCount'
      ]),
      ...mapGetters('city', [
        'cityBy',
        'citiesByDivision',
        'getCityById'
      ]),
      setMapCenter() {

        if (this.selectedCity.id == '' || this.selectedCity.id == null) {
          
          //console.log('City NA')
          return {
            latitude: 24.183969,
            longitude: 89.945963
          }

         } 

         const city = this.cityBy(this.selectedCity.id)
            return {
              latitude: city.lat,
              longitude: city.lon
            }
      },
      
      showError() {
        if (Object.keys(this.errors).length > 0)
          return this.show = true;
        return this.show = false;
      },
      isValid() {
        return ( 
          this.stop.name != '' &&
          this.stop.address != '' &&
          this.stop.phone != '' &&
          this.stop.latitude != '' &&
          this.stop.longitude != '' &&
          Object.keys(this.stopList).length != 0
        )
        // return  Object.keys(this.stopList).length != 0;  
      },
      isStopsAvailable() {
         if (this.stopsByCity.length > 0) {
           return true;
         }
         return false;
      },      
    },
    methods: {
      ...mapActions([
          'setSuccess',
          'resetErrors'
      ]),
      ...mapActions('stop', [
        'getStops',
        'addStop',
        'deleteStop'
      ]),
      ...mapActions('city', {
            getAvailableCities: 'getBusAvailableToCities',
            getDistrictList: 'getDistricts'
      }),
      actionAlert() {
          swal({           
            title: 'Stops By City',
            text: 'Added successfully!',
            icon: "success",
            timer: 2000,
            closeOnClickOutside: false,
          });
      },
      assignStops() {
        const c = this.stopsByCity;
        console.log('city=', c)
        this.mapStops = _.clone(c);
        
        this.mapReset = false;
      },
      getIndex(index) {
        console.log('Indx=',index)
        let str = `${index}`;
        return parseInt(str.replace(/\D/g, ""), 10) + 1;
        parseInt("010", 10)
      },
      addToStops(payload) {

        const lat = parseFloat(payload.event.latLng.lat());
        const lng = parseFloat(payload.event.latLng.lng());
        
        this.stop.latitude = lat;
        this.stop.longitude = lng;

        let availableStopsByCity = this.stopsByCity.length;
        console.log('AvStps=', availableStopsByCity)
        let stop = {
          name: 'Name',
          address: 'Address',
          phone: 88888,
          latitude: lat,
          longitude: lng
        };

        if (payload.markers.length > availableStopsByCity) {
          
          const index = payload.markers.length;
          console.log('mrkrL=', index)

          if ( this.multiStops === false) { 

            // const index = payload.markers.length-1;       
            this.updateMapStopsPositionAt(index-1, lat, lng);

            // payload.markers[payload.markers.length-1].setPosition({
            //   lat: lat,
            //   lng: lng
            // });
            this.updateMapMarkerPosition(payload.markers, index-1, lat, lng);
            return;
          }
          // this.mapStops[payload.markers.length] = item;
          // this.multiStops = false;
          this.addNewStopToMapStopsAt(index, stop);
          this.setMultiStops(false);
          return;
        }

        this.mapStops[availableStopsByCity] = stop;
      },      
      updateMapStopsPositionAt(index, lat, lng) {
        this.mapStops[index].latitude= lat;           
        this.mapStops[index].longitude= lng;    
      },
      updateMapMarkerPosition(markers, index, lat, lng) {
        markers[index].setPosition({
          lat: lat,
          lng: lng
        });
      },
      addNewStopToMapStopsAt(index, stop) {
        this.mapStops[index] = stop;
      },
      setMultiStops(status) {
        this.multiStops = status;
      },
      setNewStopAdded(status) {
        this.newStopAdded = status;
      },
      resetMarkerColor(payload) {

        if (this.stopListSize > 0) {
          let x = (this.stopsByCity.length); //11
          let y = (x - this.stopListSize); // 9

          for (let index = y; index < x; index++ ) {
            console.log('x=', x)
            console.log('y=', y)
            console.log('index=', index)
            payload.markers[index].setIcon(payload.iconSettings)
          }

          this.stopListSize = null;
          // this.newStopAdded = false;
          this.setNewStopAdded(false)
          return;
        }

        let index = (payload.markers.length - 1);
        // console.log(payload.iconSettings)
        payload.markers[index].setIcon(payload.iconSettings);
        // this.newStopAdded = false;
        this.setNewStopAdded(false);
      },
      addToStopList() {
        //var vm = this;
        // this.multiStops = true;
        this.setMultiStops(true);
        this.stopList.push({
          city_id: this.selectedCity.id,
          name: this.stop.name,
          address:this.stop.address,
          phone: this.stop.phone,
          latitude: this.stop.latitude,
          longitude: this.stop.longitude,
        });
        this.updateMapStopsInfoByThe(this.stop);
        this.emptyTheStop();                  
      },
      updateMapStopsInfoByThe(stop) {
        let index = this.getIndexOfStopFrom(this.mapStops, stop);
        if (index) {
          this.mapStops[index] = stop;
        }
      },
      emptyTheStop() {
        this.stop= {};        
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
          });

        this.instanceOfScrollbarTwo = OverlayScrollbars(document.getElementsByClassName("scrollbar-small"),
          { 
            className: "os-theme-dark",
            sizeAutoCapable: true,
            scrollbars: {
              autoHide: "never",
              clickScrolling: true
            } 
          });

      // this.scrollbarInstanceTwo = $('.scrollbar-small').overlayScrollbars({ /* your options */ 
      //   sizeAutoCapable: true,
      //   overflowBehavior : {
      //     x : "scroll",
      //     y : "scroll"
      //   },
      //   scrollbars: {
      //     autoHide: "never",
      //     clickScrolling: true
      //   }
      // }).overlayScrollbars(); 

      //console.log(instances);

      //var instances = $("div").overlayScrollbars({ }).overlayScrollbars(); 
      //instances.destroy();

    },      
      
      isSortingAvailableBy(val) {
        if (val== 'cityName') {
            this.sortByCityName(this.stopList);
            this.disableSorting = true;
            return;
        }
        this.SortByCityCodeAvailableStopList(this.availableStopList);
        this.disableSorting = false;
      },
     
     removeStop(stop, index) {  // role id of user/staff in roles table
        var vm = this;
        this.deletedStopName = stop.name; 
        swal({
          title: "Are you sure?",
          text: "This STOP will be Removed!",
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
            vm.response = '';
            vm.showAlert = false;
            
            // vm.remove(stop, index);
            await vm.deleteStop(stop.id);
            vm.removeStopFrom(vm.stopsByCity, index);
            vm.removeStopFromMap(stop);

            vm.actionStatus = 'Removed';
            vm.alertType = 'danger';
            vm.loading = false;
            vm.showAlert= true;
          } 
        }); 
      }, 
     // async remove(stop, index) {
     //    this.loading = true;
     //    await this.deleteStop({
     //        id: stop.id,
     //        index: index
     //    });
     //    this.removeFrom(index);
     //    this.loading = false;
     // },
      // removeFrom(index) {      
      //   this.stopsByCity.splice(index, 1);            
      //   //return;
      // },
      
      removeStopFromStopListAndMap(stop) {        
        this.removeStopFromMap(stop);
        this.removeStopFromStopList(stop, this.stopList);
      },

      removeStopFromMap(stop) {
        const i = this.getIndexOfStopFrom(this.mapStops, stop);
        this.removeStopFrom(this.mapStops, i);
        this.setStopToBeRemoved(i);
      },
      getIndexOfStopFrom(mapStops, stop) {
        return mapStops.findIndex(element => {
          return (element.latitude == stop.latitude) &&
          (element.longitude == stop.longitude)
        })
      },

      removeStopFrom(arr, index) {
        arr.splice(index, 1);
      },

      setStopToBeRemoved(value) {
        this.stopRemoved = value;
      },

      removeStopFromStopList(stop, stopList) {
        this.stopList = stopList.filter(element => element !== stop)
      },

      async save() {

        this.loading = true;
        this.stopListSize = this.stopList.length;
        // this.newStopAdded = false;
        this.setNewStopAdded(false);
        //const stops = {stop_list: this.stopList};

        //console.log('sD=', stops)
        //this.stops =  stops.stop_list;
        await this.addStop({stop_list: this.stopList});        
        this.loading = false;       
      },
      // addStopsTo(stopsByCity, stops) {
      //   stops.forEach(stop => {
      //     stopsByCity.push(stop)
      //   });
      // },
      reset(all) {
        if(all){          
          this.selectedCity = '';
          this.selectedDivision = '';
          this.stop= {};        
          this.stopList = [];
          this.resetErrors();
          return;
        }
        this.stopList = [];
        this.stop = {};
      },
      // setListOf(errors, list) {
      //   Object.keys(errors).forEach(key => {
      //     list.push({
      //       key: key.toUpperCase(),
      //       value: errors[key][0]
      //     })
      //   });
      //   this.showTheModal('error');
      // },
      // showTheModal(modalId) {                  
      //   $(`#${modalId}`).modal({
      //     backdrop: 'static'
      //   })
      // },
      sortByCityName(arr) {
        arr.sort((a, b) => {
              return a.city_id - b.city_id;
        });
      },
      SortByCityCodeAvailableStopList(arr) {
        arr.sort(function(a, b) {
              return a.city_id - b.city_id;
            });
      },
      cityAddedAlert(cityName) {
          swal({
            //title: "Sorry! Not Available",
            title: 'Bus Stops for '+cityName+' ',
            text: "Added successfully!",
            //text: '<span style="color:#F8BB86"> <strong>'+val+'</strong></span> Not Available.',
            //html: true,
            //type: "info",
            icon: "success",
            timer: 2000,
            closeOnClickOutside: true,
          });
      }
    }
}
</script>
<style lang="scss" scoped>  
  .heading {
    font-size: 1rem;
    margin-bottom: 0.75rem;
    color: white;
  }
  .fa-stack { font-size: 4.5em; }
  i { vertical-align: middle; }
  .scrollbar-small {
    height: 13rem;
  }
</style>