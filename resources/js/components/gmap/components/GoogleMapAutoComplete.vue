<template>  
  <div class="card" style="background-color: hsla(0, 0%, 100%, .15)" ref="autocomplete">
      <div class="card-body">
        <input type="text" v-model="location" ref="autocompleteInput">
      </div>
  </div>
</template>
<script>
    // https://jsfiddle.net/api/post/library/pure/
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
      },
      data() {
        return {
            location: '',
            mapAutoComplete: {},
        }
      },
      mounted() {
        
        const card = this.$refs.autocomplete;
        const input = this.$refs.autocompleteInput;
        // const  Autocomplete  = this.google.maps.places.Autocomplete;
        this.map.controls[this.google.maps.ControlPosition.TOP_LEFT].push(card);

        const autocomplete = new this.google.maps.places.Autocomplete(input);
        
        autocomplete.bindTo("bounds", this.map);
        // autocomplete.setFields(["address_components", "geometry", "icon", "name"]);

        autocomplete.addListener("place_changed", () => {    
            var vm = this;
            const place = autocomplete.getPlace();
            if (!place.geometry) {
              // User entered the name of a Place that was not suggested and
              // pressed the Enter key, or the Place Details request failed.
              window.alert("No details available for input: '" + place.name + "'");
              return;
            }
            console.log('place=', place.name)
            console.log('lat=', place.geometry.location.lat())
            console.log('lng=', place.geometry.location.lng())
            vm.map.setCenter(place.geometry.location);
            vm.map.setZoom(17); // Why 17? Because it looks good.

        })
      },
    }
</script>
