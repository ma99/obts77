<template>    
    <div class="row justify-content-center">
        <div class="col-md-4">
          <div class="card">            
            <span class="mx-auto my-2">              
              <i class="fas fa-user-cog fa-3x text-primary"></i>
            </span>
            <div class="card-body pt-2 mx-auto">
              <stars type="driver" :id="trip.driver_id" @clicked="handleStarsClicked" />
            </div>
            <div class="text-danger text-center mb-2" v-if="has('0.owner_type')" v-text="get('0.owner_type')">
            </div>
            <div class="card-footer">
              <h5>Driver
                <span class="font-weight-light text-muted" v-if="infoAvailableFor('driver')"> is {{driver.text}} 
                </span>
              </h5>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">            
            <span class="mx-auto my-2">              
              <i class="fas fa-user-tie fa-3x text-blueviolet"></i>
            </span>
            <div class="card-body pt-2 mx-auto">
              <stars type="supervisor" :id="trip.supervisor_id" @clicked="handleStarsClicked" />
            </div>
            <div class="text-danger text-center mb-2" v-if="has('1.owner_type')" v-text="get('1.owner_type')">
            </div>
            <div class="card-footer">
              <h5>Supervisor
                <span class="font-weight-light text-muted" v-if="infoAvailableFor('supervisor')"> is {{supervisor.text}} 
                </span>
              </h5>
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card">            
            <span class="mx-auto my-2">              
              <i class="fas fa-user-tag fa-3x text-skyblue"></i>
            </span>
            <div class="card-body pt-2 mx-auto">
              <stars type="helper" :id="trip.helper_id" @clicked="handleStarsClicked" />
            </div>
            <div class="text-danger text-center mb-2" v-if="has('2.owner_type')" v-text="get('2.owner_type')">
            </div>
            <div class="card-footer">
              <h5>Helper
                <span class="font-weight-light text-muted" v-if="infoAvailableFor('helper')"> is {{helper.text}} 
                </span>
              </h5>
            </div>
          </div> 
        </div>
        <div class="col-12 text-center my-2">
          <div class="button-group">
            <button @click.prevent="save()"  type="button" class="btn btn-primary mr-2 px-5" :disabled="!isValid">
              <i class="far fa-save mr-2"></i>
            Submit
            </button>           
            <button @click.prevent="cancel()"  type="button" class="btn btn-warning">
              <i class="far fa-window-close"></i>
              Cancel
            </button>
          </div>
        </div>
    </div>
</template>

<script>
    import Stars from './Stars';
    export default {
        props: {
          trip: Object
        },
        components: {
            Stars,
        },
        data() {
            return {                            
              errors: {},
              driver:{
                owner_id: '',
                owner_type: '',
                rate: '',
                text: ''
              },
              supervisor:{
                owner_id: '',
                owner_type: '',
                rate: '',
                text: ''
              },
              helper:{
                owner_id: '',
                owner_type: '',
                rate: '',
                text: ''
              }
            }
        },
        mounted() {
           console.log('rating component')           
        },
        computed: {
          isValid() {
            return this.driver.rate !== '' &&
              this.supervisor.rate !== '' &&
              this.helper.rate !== '';
          }
        },
        methods: {            
            handleStarsClicked(event) {
              this[`${event.type}`].owner_id = event.id;
              this[`${event.type}`].owner_type = `App\\${this.capitalizeFirstLetter(event.type)}`;
              this[`${event.type}`].rate = event.star.value;
              this[`${event.type}`].text = event.star.text;
            },
            capitalizeFirstLetter(str) {
              return `${str[0].toUpperCase()}${str.slice(1)}`;
            },
            infoAvailableFor(person) {
              return (this[`${person}`].text !== '') ? true : false; 
            },
            cancel() {
              this.errors = {};
              this.$emit('cancel');
            },
            async save() {              
              this.loading = true;
              this.errors = {};

              const TRIPS_REVIEW_URL = `/reviews/trips/${this.trip.id}/user-trips/${this.trip.pivot.id}`;

              let data = [];               
              data.push(this.driver);
              data.push(this.supervisor);
              data.push(this.helper);
              
              await axios.post(TRIPS_REVIEW_URL, 
                data)
                .then(response => {
                  // console.log(response.data);
                  this.$emit('reviewed', {reviews:response.data, trip: this.trip});
                  this.loading = false;                  
                })
                .catch(error => {
                   // console.log(error.response.data.errors)
                   this.errors = error.response.data.errors;
                })
            },
            has(field) {
              return this.errors.hasOwnProperty(field);
            },
            get(field) {
              if (this.errors[field]) {
                  return this.errors[field][0];
              }
            } 
        }
    }
</script>
