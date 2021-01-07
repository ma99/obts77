<template>
  <div ref="infoW">
    <slot></slot>
  </div>
</template>

<script>
// import { POINT_MARKER_ICON_CONFIG } from '../../../components/gmap/constants/mapSettings';

export default {
  props: {
    google: {
      type: Object,
      required: true
    },
    map: {
      type: Object,
      required: true
    },
    opened: {
      type: Boolean,
      required: true,
    },
    options: {
      type: Object,
      required: true,
    },
    position: {
      type: Object,
      // default: () => ({
      //   lat: 10,
      //   lng: 10,
      // }),            
    },
    // remake: {
    //   type: Boolean,
    //   default: false
    // }
  },
  data() {
    return {
      mapInfoWindow: null,      
      content: null,
    }
  },
  
  mounted() {    
    const el = this.$refs.infoW;
    if (el === null) return;
    this.content = el;
    el.parentNode.removeChild(el); 
  },

  beforeUnmount() {
    if (this.mapInfoWindow == null) return;

    this.mapInfoWindow.close()    
    this.google.maps.event.clearInstanceListeners(this.mapInfoWindow)
  },

  watch: {
    opened(value) {
      const infoWindow = this.mapInfoWindow;      
      
      // if (infoWindow === null) return;

      if (value == true) {
          this.open(infoWindow);
          return;
      }            
      this.close(infoWindow);
    },

    position(position) {
      if (this.empty(position)) return;

      if (this.mapInfoWindow !== null) {
        this.mapInfoWindow.setPosition(position)
        return;
      }
      this.makeInfoWindow();
    },

    // remake(value) {
    //   if (value === true && this.mapInfoWindow === null ) {
    //     this.makeInfoWindow();
    //   }
    // }
  },
  methods: {    
    emitCloseClickEvent() {      
      var vm = this;
      this.mapInfoWindow.addListener('closeclick', () => 
        vm.$emit('closed')
      );
    },
    empty(position) {
      return (Object.keys(position).length == 0) ?
            true : false;
    },
    makeInfoWindow() {
      const { InfoWindow } = this.google.maps;
      const options = this.options;

      this.mapInfoWindow = new InfoWindow({ 
        content: this.content,
        disableAutoPan: true,
        position: this.position,
        ...options 
        });

      this.emitCloseClickEvent();
    },
    open(infoWindow) {
      infoWindow.open(this.map);
    },
    close(infoWindow) {
      infoWindow.close();   
    }
  },  
}
</script>
