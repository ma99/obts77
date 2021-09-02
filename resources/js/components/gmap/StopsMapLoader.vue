<template>
  <GoogleMapLoader
    apiKey="AIzaSyAohU2OqkaeuRNtW_9M2DQFJtet15Zt64o"
    :mapConfig="mapConfig"
    :mapStyle="{width:'100%', height:'500px'}"
    @clicked="handleMapClicked"
    @load-event="mapLoaderStatus"
  >
  
    <template v-slot="{ google, map }">
      <GoogleMapAutoComplete
        v-if="loaded"
        :google="google"
        :map="map"
      />

      <GoogleMapMarker
        v-if="loaded"
        v-for="stop in stops"
        :options="markerOptions"
        :position="getPosition(stop)"
        :google="google"
        :map="map"
        :icon="iconSettings"
        @created="handleMarkerCreated"
        @click="handleMarkerClicked(stop)"
      />      

      <GoogleMapInfoWindow        
        v-if="loaded"
        :google="google"
        :map="map"
        :options="infoWindowOptions"
        :position="infoWindowPosition"
        :opened="infoWindowOpened"
        @closed="handleInfoWindowClose"
      >
        <span class="info-window border-bottom border-info pb-2">Stop Information </span>
        <ul class="px-1 mt-3 mb-1">          
          <li class="info">
            <strong>
              {{ clickedMarker.name }}                      
            </strong>  
          </li> 
          <li class="info">
            <i class="fas fa-building mr-1"></i>
            {{ clickedMarker.address }}            
          </li> 
          <li class="info">
            <i class="fas fa-mobile-alt mr-1"></i>
            {{ clickedMarker.phone }}            
          </li> 
        </ul>

        <!-- lat: {{ clickedMarker.latitude }} /
        lng: {{ clickedMarker.longitude }} -->
      </GoogleMapInfoWindow>
      
    </template>
  </GoogleMapLoader>
</template>

<script>
import GoogleMapLoader from "../../components/gmap/components/GoogleMapLoader";
import GoogleMapMarker from "../../components/gmap/components/GoogleMapMarker";
import GoogleMapInfoWindow from "../../components/gmap/components/GoogleMapInfoWindow";
import GoogleMapLine from "../../components/gmap/components/GoogleMapLine";
import GoogleMapAutoComplete from "../../components/gmap/components/GoogleMapAutoComplete";

// import { mapSettings, MARKER_ICON } from '../../components/gmap/constants/mapSettings';
import { mapSettings, MARKER_ICON } from '../../components/gmap/constants/mapSettings';

export default {
  props:['marker-color-reset', 'stops', 'mreset', 'mcenter', 'remove-marker'],

  components: {
    GoogleMapLoader,
    GoogleMapAutoComplete,
    GoogleMapMarker,
    GoogleMapInfoWindow,
    GoogleMapLine
  },  

  data() {
    return {
      // markers: [
      //   {
      //     id: "a",
      //     position: { lat: 3, lng: 101 }
      //   },
      //   {
      //     id: "b",
      //     position: { lat: 5, lng: 99 }
      //   },
      //   {
      //     id: "c",
      //     position: { lat: 6, lng: 97 }
      //   }
      // ],
      markers:[],      
      lines: [
        {
          id: "1",
          path: [{ lat: 3, lng: 101 }, { lat: 5, lng: 99 }]
        },
        {
          id: "2",
          path: [{ lat: 5, lng: 99 }, { lat: 6, lng: 97 }]
        }
      ],
      markerOptions: {
        clickable: true,
        draggable: false
      },
      infoWindowOptions: {
        pixelOffset: {
          width: 0,
          height: -35
        }
      },
      iconSettings: {      
        path: MARKER_ICON,
        strokeOpacity: 0.7,
        strokeWeight: 2,
        strokeColor: 'white',
        fillColor: 'red',
        fillOpacity: 0.7,
        scale: 1
      },      
      clickedMarker: {},
      infoWindowOpened: false,
      loaded: false  // MapLoader not loaded fully        
    };
  },  

  watch: {
    mreset(value) {
      console.log('reset=', value);
      if (value == true) 
      
        this.$emit('map-reseted');

        if (this.markers.length == 0) return;
        
        for (let i = 0; i < this.markers.length; i++) {
          this.markers[i].setVisible(false);
          this.markers[i].setMap(null);
        }
        this.markers = [];
        this.changeMarkerIconSettings('red', 'white');
    },

    removeMarker(index) {
      console.log('rmI=', index)
      if (index >= 0) {
        this.markers[index].setVisible(false)
        this.markers[index].setMap(null)
        this.markers.splice(index, 1)
      }
    },

    markerColorReset(value) {
      console.log('ColorRed')
      if (value == true) {
        console.log('chngColorRed')
        // this.changeMarkerIconSettings('red', 'white');
        const iconSettings = this.iconSettings;
        
        iconSettings.fillColor = 'red';
        iconSettings.strokeColor = 'white';        

        this.$emit('stop-added', {
          iconSettings: iconSettings,
          markers: this.markers
        })
      }
    }
  },

  computed: {
    mapConfig() {
      return {
        ...mapSettings,
        center: this.mapCenter,        
        mapTypeId: 'roadmap',     //'terrain',   // 'satellite'
        zoom: this.mapZoom, 
      }
    },

    isStopsAvailable() {
         if (this.stops.length > 0) {
           return true;
         }
         return false;
      },
      mapCenter() {
        if (this.isStopsAvailable) {
          return {
            lat: parseFloat(this.stops[0].latitude),
            lng: parseFloat(this.stops[0].longitude)
          }
        }
        
        if ( this.mcenter.hasOwnProperty('latitude') &&
            this.mcenter.hasOwnProperty('longitude')) {

          return {
            lat: parseFloat(this.mcenter.latitude),
            lng: parseFloat(this.mcenter.longitude)
          }
        }

        return {
          lat: 24.183969,
          lng: 89.945963
        }
      },

    // mapCenter() {
    //   return this.markers[1].position;
    // },

    mapZoom() {
      return (this.stops.length > 0) ?
          7 : 7;      
    },

    infoWindowPosition() {
      return {
        lat: parseFloat(this.clickedMarker.latitude),
        lng: parseFloat(this.clickedMarker.longitude)
      }
      // return this.clickedMarker;
    },    
  },
  methods: {    
    mapLoaderStatus(e) {
        // console.log('evnt', e)
        this.loaded = e
    },
    getPosition(stop) {
      if (Object.keys(stop).length == 0) return;

      return {
        lat: parseFloat(stop.latitude),
        lng: parseFloat(stop.longitude)
      }
    },    
    handleMapClicked(event) {
      this.changeMarkerIconSettings('blue', 'lightcyan');
            
      this.$emit('add-stop', {event:event, markers: this.markers});      
    },
    changeMarkerIconSettings(fillColor, strokeColor) {      
      this.iconSettings.fillColor = fillColor;
      this.iconSettings.strokeColor = strokeColor;
    },
    handleMarkerCreated(marker) {
      console.log('created=', marker)
      this.markers.push(marker)
    },
    handleMarkerClicked(marker) {
      this.clickedMarker = marker;
      this.infoWindowOpened = true;
    },

    handleInfoWindowClose() {
      console.log('wclosed')
      this.clickedMarker = {};
      this.infoWindowOpened = false;
    },    

    setMarkerIcon(path) {
        this.iconSettings.path = path;
    }
  }
}
</script>
<style lang="scss" scoped>
  span.info-window {
    letter-spacing: 0.18rem;
    font-weight: 500;
  }
  li.info {
    list-style: none;
    letter-spacing: 0.0785rem;
    margin-bottom: 0.375rem;
    color: hsla(208, 8%, 41%, 1);
  }
</style>  