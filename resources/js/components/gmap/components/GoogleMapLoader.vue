<template>
  <div>
    <div
      class="google-map"
      :style="mapStyle"
      ref="googleMap"
    ></div>
    <template v-if="Boolean(this.google) && Boolean(this.map)">
      <slot
        :google="google"
        :map="map"
      />
    </template>
  </div>
</template>

<script>
import GoogleMapsApiLoader from "google-maps-api-loader";

export default {
  props: {
    apiKey: String,
    mapConfig: Object,
    mapStyle: {
      type: Object,
      default() {
        return {
          height: '400px',
          width: '100%', 
        }
      }
    },
  },

  data() {
    return {
      google: null,
      map: null
    };
  },

  async mounted() {
    const googleMapApi = await GoogleMapsApiLoader({
      apiKey: this.apiKey,
      libraries: ['places'],
    });
    this.google = googleMapApi;
    this.initializeMap();
    this.listenKeyEvent();
    this.listenClickEvent();    
  },

  beforeUnmount() {
    const el = this.$refs.googleMap;
    if (el === null) return; 
    el.removeEventListener('keydown', this.keydownHandler);
    el.removeEventListener('keyup', this.keyupHandler);
    
    this.google.maps.event.clearInstanceListeners(this.map);
  },

  methods: {
    initializeMap() {
      const mapContainer = this.$refs.googleMap;
      this.map = new this.google.maps.Map(mapContainer, this.mapConfig);
    },

    listenKeyEvent() {
      const el = this.$refs.googleMap;
      // var vm = this;
      el.addEventListener('keydown', this.keydownHandler);

      el.addEventListener('keyup', this.keyupHandler);
    },    
    keydownHandler(event) {
        //exit if the event is part of composition event
        if (this.isCompositionEvent(event)) return;

        if (event.ctrlKey) {
            console.log(event.type)
            // console.log(`key ${event.code}`)
            this.setCursor('pointer');
        }
    },
    keyupHandler(event) {         
        if (this.isCompositionEvent(event)) return;
        console.log(event.type)
        this.setCursor('grab');
    },
    isCompositionEvent(event) {
        if (event.isComposing || event.keyCode === 229) {
          return true;
        }
        return false;
    },

    listenClickEvent() {
      var vm = this;
      this.map.addListener('click', (e) => {
          // console.log(e);          
          // windows mouse event is wrapped within google map click event
          const mouseEvent = this.getWindowsMouseEventFromGoogleMap(e);
          
          if (mouseEvent.ctrlKey) {
            console.log('ctrlKey pressed');            
            vm.emitClickEvent(e)
            // vm.$emit('clicked', e)
          }
          // vm.setCursor('grab');
      });      
    },
    emitClickEvent(event) {
       this.$emit('clicked', event);
    },    
    getWindowsMouseEventFromGoogleMap(event) {
      return Object.values(event).find(p => 
        p instanceof window.MouseEvent
      );
    },
    setCursor(cursor) {
      this.map.setOptions({ draggableCursor: cursor });
      // map.setOptions({draggingCursor:'crosshair'});
    },
  }
};
</script>

<style scoped>
/*.google-map {
  width: 100%;
  min-height: 100%;
}*/
</style>
