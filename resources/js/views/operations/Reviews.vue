<template>
    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">
            <div class="row">            
              <div class="col-12">              
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="tripsToBeReviewed-tab" data-toggle="tab" href="#tripsToBeReviewed" role="tab" aria-controls="tripsToBeReviewed" aria-selected="true">To be Reviewed</a>
                  </li>
                  <li class="nav-item" role="presentation">
                    <a class="nav-link" id="tripsReviewed-tab" data-toggle="tab" href="#tripsReviewed" role="tab" aria-controls="tripsReviewed" aria-selected="false">Review History</a>
                  </li>                  
                </ul>
              </div>

              <loader :show="loading"></loader>

              <!-- Tab panes -->
              <div class="col-12 tab-content my-3">
                <div class="tab-pane active" id="tripsToBeReviewed" role="tabpanel" aria-labelledby="tripsToBeReviewed-tab">
                  <div 
                    class="my-2" 
                    v-for="(trip, index) in tripsToBeReviewed"
                  >
                    <div class="card card-success card-outline">                    
                      <div class="card-body row">                       
                        <div class="mb-2 col-sm-2">
                          <!-- <i class="fas fa-bus-alt fa-3x mt-2"></i> -->
                          <span class="fa-stack fa-3x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-bus-alt fa-stack-1x fa-inverse"></i>
                          </span>
                        </div>
                        <div class="col-sm-7">
                          <ul class="list-unstyled ml-sm-2">
                            <li class="text-muted h6">
                              <i class="far fa-calendar-alt mx-2 text-success"></i>
                              Travelled on {{ convertToDate(trip.date) }} 
                            </li>
                          <!-- Trip: {{trip.id}} -->
                            <li class="h5 tex-info">
                              <i class="far fa-map mx-2 text-success"></i> {{ trip.route_cities}}
                            </li> 
                            <li>         
                              <i class="far fa-clock mx-2 text-success"></i>
                              {{ trip.departure_time}}
                            </li>
                          </ul>
                        </div>
                        <div class="col-sm-3">                          
                          <button @click.prevent="showReviewPanelFor(trip)" type="button" class="btn btn-success mr-2 px-5 rounded-pill" :disabled="isReviewPanelSelecctedFor(trip)">
                            <i class="fas fa-tasks mr-2"></i>Review
                          </button>                           
                        </div>

                        <div class="col-12 mt-3" v-if="isReviewPanelSelecctedFor(trip)">
                          <ratings 
                            :trip="trip"
                            @cancel="handleCancelClicked"
                            @reviewed="handleTripReviewed"
                          />                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="tab-pane scrollbar" id="tripsReviewed" role="tabpanel" aria-labelledby="tripsReviewed-tab">                  
                  <div
                    class="my-2"                     
                    v-for="(trip, index) in tripsReviewed"
                  >                    
                    <div class="card">                    
                      <div class="card-body row">
                        <div class="col-12">
                          <!-- Travelled on  -->
                          <i class="far fa-calendar-alt mr-2"></i><strong>{{ convertToDate(trip.date) }} </strong> 
                          <i class="far fa-clock mx-2"></i>{{ trip.departure_time }}
                           <i class="far fa-map mx-2"></i> <strong>{{trip.route_cities}}</strong>
                        </div>
                        <div class="col-12 mt-3">
                          <div class="row justify-content-center">
                            <div class="col-12 my-2 col-lg-4 my-lg-0"
                              v-for="(review, index) in trip.reviews" 
                            >
                              <div class="card">            
                                <div class="card-header h5 pt-1" :class="[titleClass(index), bgClass(index)]">
                                  {{ ownerType(review.owner_type)}}
                                </div>
                                <div class="card-body py-2">
                                  <stars 
                                    :value="review.rate" 
                                    :id="trip.id"
                                    :index="index" 
                                    @impression="handleImpression" 
                                    :disable="true"
                                  />
                                </div>
                                <div class="card-footer">
                                  <span class="font-weight-bold">{{review.text}}
                                  </span>
                                </div>
                              </div> 
                            </div>
                          </div>
                        </div>                        
                      </div>
                    </div>
                  </div>
                </div>                  
              </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
  </div>
  <!-- /.content -->    
</template>

<script>
    import Ratings from '../../components/Ratings';
    import Stars from '../../components/Stars';

    const TRIPS_TO_BE_REVIEWED_URL = '/reviews/pending';
    const TRIPS_REVIEWED_URL = '/reviews/completed';

    export default {
        components: {
            Ratings,
            Stars
        },
        data() {
          return {
            instanceOfScrollbar: undefined,
            loading: false,
            tripsToBeReviewed: [],
            tripsReviewed: [],        
            routeCity: '',
            reviewPanelToBeShownId: '',
            intViewportHeight: window.innerHeight
          }
        },
        async mounted() {
            console.log('Component mounted.')
            this.loading = true;
            await this.getTripsReviewed();
            await this.getTripsToBeReviewed();
            this.enableScroll();
            this.loading = false;
        },
        beforeUnmount() {
          if (this.instanceOfScrollbar !== undefined) {
            this.instanceOfScrollbar.destroy();
          }
        },
        watch: {
          intViewportHeight(value) {
            console.log(value)
          }
        },
        methods: {
          actionAlert(icon, message) {
              swal({           
                title: 'Reviews',
                text: `${message} successfully!`,
                icon: icon,
                timer: 2000,
                closeOnClickOutside: false,
              });
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
          convertToDate(string) {
            let date = string.split("-");
            let mydate = new Date(date[2], date[1] - 1, date[0]); 
            // return mydate.toDateString();
            return mydate.toLocaleDateString('en-US', {
                day : 'numeric',
                month : 'short',
                year : 'numeric',
                // weekday: 'long'
            });
          },
          bgClass(index) {            
            if(index === 0) {
              return 'bg-skyblue';
            }
            if(index === 1) {
              return 'bg-lightpurple';
            }
            return 'bg-lightcyan';
          },
          titleClass(index) {            
            if(index === 0) {
              return 'text-primary';
            }
            if(index === 1) {
              return 'text-blueviolet';
            }
            return 'text-skyblue';
          },
          ownerType(string) {
            return string.split("\\")[1];
          },
          getTripsReviewed() {
            this.tripsReviewed = [];
            // console.log('tr1')
            axios.get(TRIPS_REVIEWED_URL)
              .then(response => {
                this.tripsReviewed = response.data;
                // this.tripsReviewed = [... response.data];
              })
              .catch(error => {
                 console.log(error.response.data.error)
              })
          },
          getTripsToBeReviewed() {
            this.tripsToBeReviewed = [];

            axios.get(TRIPS_TO_BE_REVIEWED_URL)
              .then(response => {
                this.tripsToBeReviewed = response.data;
                // this.tripsToBeReviewed = [... response.data];
              })
              .catch(error => {
                 console.log(error.response.data.error)
              })
          },
          handleCancelClicked() {
            this.reviewPanelToBeShownId = '';
          },
          handleImpression(event) {
            let index = this.tripsReviewed.findIndex(element => element.id === event.trip_id);
            this.addImpressionAsTextTo(this.tripsReviewed, index, event);
          },
          addImpressionAsTextTo(tripsReviewed, index, event) {
            tripsReviewed[index].reviews[event.review_index].text = event.impression;
          },
          handleTripReviewed(event) {
            this.actionAlert('success', 'completed')
            this.addTripTo(this.tripsReviewed, event.trip, event.reviews);
            this.removeTripFrom(this.tripsToBeReviewed, event.trip);
          },
          addTripTo(tripsReviewed, trip, reviews) {
            let tripArray = [];
            tripArray = trip;
            tripArray['reviews'] = reviews;            
            return tripsReviewed.push(tripArray);
          },
          removeTripFrom(tripsToBeReviewed, trip) {
            let index = tripsToBeReviewed.indexOf(trip);
            return tripsToBeReviewed.splice(index, 1);
          },          
          showReviewPanelFor(trip) {
            this.reviewPanelToBeShownId = trip.id;
          },
          isReviewPanelSelecctedFor(trip) {
            return (this.reviewPanelToBeShownId === trip.id) ?
              true : false;
          } 
        }                
    }
</script>
<style scoped>
  .scrollbar {
    height: calc(100vh - 200px);
  }
</style>