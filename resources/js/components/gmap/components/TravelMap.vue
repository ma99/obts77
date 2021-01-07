<template>
  <GoogleMapLoader
    apiKey="AIzaSyAohU2OqkaeuRNtW_9M2DQFJtet15Zt64o"
    :mapConfig="mapConfig"
    :mapStyle="{width:'100%', height:'500px'}"    
    @clicked="handleMapClicked"
  >
  
    <template v-slot="{ google, map }">

      <GoogleMapAutoComplete
        :google="google"
        :map="map"
      />

      <GoogleMapMarker
        v-for="marker in markers"
        :key="marker.id"
        :options="markerOptions"
        :position="getPosition(marker)"
        :google="google"
        :map="map"
        :icon="iconSettings"
        @click="handleMarkerClicked(marker.position)"
      />
      <GoogleMapInfoWindow        
        :google="google"
        :map="map"
        :options="infoWindowOptions"
        :position="infoWindowPosition"
        :opened="infoWindowOpened"
        @closed="handleInfoWindowClose"
      >
      <p> Hello world </p>
      <hr>
      lat: {{ clickedMarker.lat }} /
      lng: {{ clickedMarker.lng }}
      </GoogleMapInfoWindow>

      <GoogleMapLine
        v-for="line in lines"
        :key="line.id"
        :path.sync="line.path"
        :google="google"
        :map="map"
      />
    </template>
  </GoogleMapLoader>
</template>

<script>
import GoogleMapLoader from "./GoogleMapLoader";
import GoogleMapMarker from "./GoogleMapMarker";
import GoogleMapInfoWindow from "./GoogleMapInfoWindow";
import GoogleMapLine from "./GoogleMapLine";
import GoogleMapAutoComplete from "./GoogleMapAutoComplete";

import { mapSettings, MARKER_ICON } from '../../../components/gmap/constants/mapSettings';

export default {
  components: {
    GoogleMapLoader,
    GoogleMapAutoComplete,
    GoogleMapMarker,
    GoogleMapInfoWindow,
    GoogleMapLine
  },

  data() {
    return {
      markers: [
        {
          id: "a",
          position: { lat: 3, lng: 101 }
        },
        {
          id: "b",
          position: { lat: 5, lng: 99 }
        },
        {
          id: "c",
          position: { lat: 6, lng: 97 }
        }
      ],
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
    };
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

    mapCenter() {
      return this.markers[1].position;
    },

    mapZoom() {
      return (this.markers.length > 0) ?
          7 : 5;      
    },

    infoWindowPosition() {
      return {
        lat: parseFloat(this.clickedMarker.lat),
        lng: parseFloat(this.clickedMarker.lng)
      }
      // return this.clickedMarker;
    },
  },
  methods: {    
    getPosition(marker) {
      return {
        lat: parseFloat(marker.position.lat),
        lng: parseFloat(marker.position.lng)
      }
    },
    handleMapClicked(event) {
      
      this.changeMarkerIconSettings()
            
      this.markers.push({
        id: Math.random().toString(36).substring(4),
        position: {
          lat: parseFloat(event.latLng.lat()),
          lng: parseFloat(event.latLng.lng())    
        }
      });      
    },
    changeMarkerIconSettings() {
      this.iconSettings.fillColor = 'blue';
      this.iconSettings.strokeColor = 'lightcyan';
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
