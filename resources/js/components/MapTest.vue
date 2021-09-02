<template>
  <div id="map">
    <template>
      <slot
        :google="google"
        :map="map"
      />
    </template>
  </div>    
</template>

<script>
  import { Loader } from "@googlemaps/js-api-loader";

    export default {        
        data() {
            return {
              google: null,
              map: null
            }
        },

      created() {
        console.log('created');
        // this.google="mmmmmm"
      },
       mounted() {
            console.log('Test Map CHILD Component mounted.')                
            const loader = new Loader({
              apiKey: "AIzaSyAohU2OqkaeuRNtW_9M2DQFJtet15Zt64o" ,
              libraries: ['places'],
            });        

               const mapOptions = {
                  center: {
                    lat: 10,
                    lng: 10,
                  },
                  zoom: 4,
                };

             // Promise
            loader
              .load()
              .then((google) => {
                // const g1 = google; 
                console.log(google)
                // this.google = g1;
                this.google = google;
                const map = new this.google.maps.Map(document.getElementById("map"), mapOptions);
                this.map = map;
                console.log(map)
                this.$emit('loadEvent', 1)
              })
              .catch((e) => {
                // do something
              });
              console.log('lllll')
              console.log('os=',this.google)

        },      

    }
</script>
<style lang="scss" scoped>
    #map {
        height: 500px;
        width: 80%;        
        background: gray;
      }
</style>