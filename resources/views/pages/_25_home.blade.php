@extends('layouts.app')

@section('warningbar')
  @include('includes.unverified.phone-warning')                
@endsection

@section('content')
<div class="container">
  <div class="row">
    <div class="col-12">        
      welcome to home page of obts
    </div>
     {{--  <seat cities= "{{ $cities }}" ></seat>        --}}
    <div class="col-12 mt-3">
      {{-- <seat-display inline-template> --}}
      <seat-display v-slot="vm">
          <div>
              {{-- <app-modal modal-id="seatSelection"> 
                @include('includes.seatselection')
              </app-modal>                          --}}

              <div v-show="!vm.isSeatBooked" class="card border-0 bg-transparent">
                {{-- <div class="card-heading">Search Schedule</div> --}}
                <div class="card-body">                  
                  <form>
                    <div class="row align-items-center">
                      <div class="col-5 search-form shadow">
                        @include('includes.search')                       
                      </div>
                      <div class="col-7">                        
                      </div>
                    </div>                    
                  </form> 
                </div>
              </div>
              {{-- SCHEDULE --}}    
              <div v-show="vm.showSchedule" class="info-table">              
                <div class="card">
                  <div class="card-body p-0">
                    {{-- <div id="scrollbar"> --}}
                      <table class="table table-striped table-hover">
                       <!-- Table Headings -->
                        <thead>
                            <th>SL No.</th>                                
                            <th>Dept. Time</th>            
                            {{-- <th>Arr. Time</th>              --}}
                            <th>Type</th>                                
                            <th>Available Seats</th>
                            <th>Fare</th>                                
                            <th>View</th>
                            {{-- <th>&nbsp;</th> --}}
                        </thead>
                        <!-- Table Body -->
                        <tbody>
                            <tr v-for="(bus, index) in vm.buses">
                                <td class="table-text">
                                  <div> @{{ index + 1 }} </div>
                                </td>

                                <td class="table-text">
                                  <div> @{{ bus.departure_time }} </div>
                                </td>
                                {{-- <td class="table-text">
                                  <div> @{{ bus.arrival_time }} </div>
                                </td> --}}
                                <td class="table-text">
                                  <div> @{{ bus.bus_type }} </div>
                                </td>
                                <td class="table-text">
                                  <div> @{{ bus.available_seats }} </div>
                                </td>
                                <td class="table-text">
                                  <div> @{{ bus.fare }} </div>
                                </td>
                                <td class="table-text">
                                  {{-- <div>  --}}
                                   {{--  <button v-on:click.prevent="viewSeats(bus.schedule_id, bus.bus_id, bus.fare)" class="btn btn-success">View</button>  --}}
                                  {{-- </div> --}}
                                  <button type="button" class="btn btn-outline-primary"@click.prevent="vm.viewSeatsOf(bus)">    
                                      <i class="button-icon fas fa-eye"></i>View
                                  </button>   
                                </td>
                            </tr>                                                            
                        </tbody>
                      </table>                        
                    {{-- </div> --}}
                  </div>            
                </div>
              </div>  

              <loader :show="vm.loading"></loader>

              {{-- <div class="col-sm-6 col-sm-offset-2"> --}}
                  {{-- Booked Seat Info --}}
                  @include('includes.booking')
              {{-- </div>                     --}}

              <!-- Modal / unit in rem -->
              {{-- <modal :show.sync="vm.modal" width="45" padding="0.5">
                @include('includes.seatselection')
              </modal> --}}   
                
                {{-- ************ --}}
                <!-- Modal -->
                <div class="modal fade" id="seatSelection" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-width  modal-dialog-centered modal-dialog-scrollable">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="staticBackdropLabel">
                            Seat Selection
                          </h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <!-- <div class="modal-body scrollbar-modal"> -->
                        <div class="modal-body">
                          @include('includes.seatselection')   
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary rounded-pill px-5" data-dismiss="modal">Got it..</button>
                          <!-- <button type="button" class="btn btn-primary">Understood</button> -->
                        </div>
                      </div>
                    </div>
                </div>    
                {{-- ****** --}}

              {{-- @include('includes.modal') --}}
          </div>      
      </seat-display>              
    </div>      
  </div>
</div>
@endsection