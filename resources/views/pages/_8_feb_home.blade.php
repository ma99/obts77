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
          {{-- <div> --}}
              {{-- <app-modal modal-id="seatSelection"> 
                @include('includes.seatselection')
              </app-modal>                          --}}

              <div v-if="!vm.isSeatBooked && vm.showSearch" class="card border-0 bg-transparent">
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
              <div v-show="vm.isValidSearchMini" class="bg-lightlemonyellow rounded">
                <div class="bg-success info-table-top"></div>
                <button type="button" class="close float-right mr-2" aria-label="Close" @click.prevent="vm.setSearchMini('false')">
                  <span aria-hidden="true">&times;</span>
                </button>
                <div class="d-md-flex justify-content-around p-3 my-2">
                  @include('includes.search-mini')
                </div>
              </div>

              <div v-if="vm.showSchedule && !vm.searchMini" class="bg-lightlemonyellow rounded">
                <div class="bg-success info-table-top"></div>  
                <div class="d-md-flex flex-column justify-content-center align-items-center my-2">
                  {{-- <div class="d-flex flex-column justify-content-center align-items-center">
                    <div class="p-2 text-center"> 
                      <h5> @{{ vm.selectedCityFrom}} to @{{ vm.selectedTo}} </h5>
                    </div>

                    <div class="p-2 d-flex justify-content-center align-items-center"> 
                      <div class="p-2 bg-bus" :style="vm.styles"></div>
                      <div class="p-2 bg-danger">Date</div>
                    </div>
                    
                  </div>
                   --}}
                    <div class="r1 d-md-flex align-items-top">
                      {{-- ROUTE --}}
                      <div class="bg-success"> 
                        <strong> @{{ vm.selectedCityFrom}} to @{{ vm.selectedTo}} </strong>
                      </div>                        
                      <div class="bg-info">
                        @{{vm.convertToDate(vm.startDate)}}
                      </div>                     
                    </div>  {{-- r1 --}}

                    <div class="r2 d-md-flex justify-content-center align-items-center">
                        {{-- BUS ICON --}}
                        <div class="px-2 bg-bus mx-auto" :style="vm.styles"></div>

                       {{-- DATE NAVIGATION --}}
                      <div class="px-2 d-flex justify-content-center align-items-center">
                        <div class="px-2">                    
                          <button type="button" @click.prevent="vm.handleSearch('prev')" class="px-4 btn btn-info form-control rounded-pill" :disabled="vm.isValidDate">
                          <i class="fas fa-angle-double-left mr-2"></i>Prev Day                  
                          </button>
                        </div>
                        <div class="px-2">                    
                          <button type="button" @click.prevent="vm.handleSearch('next')" class="px-4 btn btn-info form-control rounded-pill">
                           Next Day                  
                          <i class="fas fa-angle-double-right ml-2"></i>
                          </button>
                        </div>
                      </div>

                      {{-- SEARCH AGAIN BTN --}}
                      <div class="px-2">
                        <button type="button" @click.prevent="vm.handleSearchMini()" class="px-4 btn btn-warning form-control mb-sm-1">
                      Search <i class="fas fa-undo ml-2"></i>
                      </div>
                    </div> {{-- r2 --}}

                </div>
              </div>

              <div v-show="vm.showSchedule" class="info-table mb-3 rounded shadow">
                <div class="bg-warning info-table-top"></div>
                <div class="d-md-flex p-2 mb-3 rounded">
                  <div class="p-2 info-table-left flex-shrink-1">
                    <div class="filter-title">Fillter</div>
                    <div class="filter-element">                      
                      <form>
                        <div 
                          class="custom-control custom-checkbox mb-1"
                          v-for="(bus, index) in vm.busTypes"
                          :key="bus.bus_id"
                        >
                          <input type="checkbox" class="custom-control-input" :id="vm.setBusTypeCheckId(index)" :value="bus.type" v-model="vm.bus.checkedTypes" />
                          <label class="custom-control-label" :for="vm.setBusTypeCheckId(index)">
                            @{{ bus.type }}
                          </label>
                        </div>                                       
                      </form>                    
                    </div>
                  </div>

                  <div class="p-2 mb-2 flex-fill">
                    {{-- Flex item --}}
                    <div class="pb-2" v-if="vm.bus.checkedTypes.length > 0">
                      <button 
                        type="button" 
                        class="btn btn-outline-info btn-sm rounded-pill mr-1"
                        v-for="(type, index) in vm.bus.checkedTypes"
                        @click.prevent="vm.removeFilter(type)"
                      >
                        @{{ type }} 
                        <i class="fas fa-times-circle"></i>
                      </button>                      
                    </div>
                    {{-- <div class="card info-scroll"> --}}
                    <div class="card info-scroll">
                      <div class="card-body p-0">
                        {{-- <div id="scrollbar"> --}}
                        <table class="table table-striped table-hover">
                           <!-- Table Headings -->
                            <thead style="background-color:hsla(75, 58%, 64%, 1);">
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
                                {{-- <tr v-for="(bus, index) in vm.buses"> --}}
                                <tr v-for="(bus, index) in vm.busesByType">
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
          {{-- </div>       --}}
      </seat-display>              
    </div>      
  </div>
</div>
@endsection