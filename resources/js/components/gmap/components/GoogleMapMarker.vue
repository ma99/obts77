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
    options: {
      type: Object,
      required: true
    },
    position: {
      type: Object,
      required: true
    },
    icon: {
      type: Object,
      // required: true
    }
  },
  data() {
    return {
      mapMarker: null,
    }
  }, 
  mounted() {    
    const { Marker } = this.google.maps;
    const options = this.options;
    this.mapMarker = new Marker({
      position: this.position,
      map: this.map,
      // icon: POINT_MARKER_ICON_CONFIG,
      icon: this.icon,
      ...options
    });
    this.emitMarkerCreated()
    this.emitClickEvent();
  },
  beforeUnmount() {
    this.mapMarker.setMap(null);
    // window.google.maps.event.clearInstanceListeners(this.mapMarker)
    this.google.maps.event.clearInstanceListeners(this.mapMarker)
  },

  
  methods: {
    emitMarkerCreated() {
      this.$emit('created', this.mapMarker);
    },
    
    emitClickEvent() {
      var vm = this;
      this.mapMarker.addListener('click', () => 
          vm.$emit('click')
      );
    }
  },

  render() {}
};
</script>
