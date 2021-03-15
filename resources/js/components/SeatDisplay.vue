<template>
  <div>    
    <stepper 
      :search="steps.search" 
      :select="steps.select" 
      :buy="steps.buy"  
    />
    <div v-if="!isSeatBooked && showSearch" class="card border-0 bg-transparent">
              
      <div class="card-body">                  
        <form>
          <div class="row align-items-center">
            <div class="col-12 col-md-4 mt-md-n5 search-form shadow order-2 order-md-1">
              <!-- @include('includes.search') -->
              <!-- ///// SEARCH BIG -->
              <div class="form-row justify-content-center">
                <div class="form-group col-8">
               <!--  {{-- <autocomplete 
                  input-label="From"
                  :suggestions="availableCityList" 
                  v-model:city="selectedCityFrom" 
                >
                </autocomplete>   --}} -->
                  <autocomplete 
                    :suggestions="availableCityList" 
                    :city="selectedCityFrom" 
                    @update:city="handleCityFromInputEvent"  
                    input-label="From"
                  >
                  </autocomplete>  
                </div>
                <div class="form-group col-8">
                  <!-- {{-- <autocomplete :suggestions="availableCityList" v-model="selectedTo" input-label="To">
                  </autocomplete> --}} -->
                  <autocomplete 
                    :suggestions="availableCityList" 
                    :city="selectedTo"       
                    @update:city="handleCityToInputEvent"  
                    input-label="To"
                  >
                  </autocomplete>
                </div>
                <div class="form-group col-8">  
                    <label for="startDate">Date of Journey</label> 
                    <div id="sandbox-container">
                      <div class="input-group date">
                        <input name="date" id="startDate" class="form-control border-right-0" type="text" v-model="startDate" placeholder="Select Date">
                        <span class="input-group-append">
                            <div class="input-group-text bg-white"><i class="fas fa-calendar-alt" style="color: hsl(86, 51%, 54%);"></i></div>
                        </span>
                      </div>
                    </div>
                </div>
                <div class="col-8">
                  <button type="button" @click.prevent="searchBus" class="btn btn-warning btn-search form-control" :disabled="isDisabled">Search &nbsp;
                    <i class="fa fa-search"></i>
                  </button>   
                </div>                          
              </div> 
              <!-- ///// -->                       
            </div>
            <div class="col-12 px-0 pl-md-4 col-md-7 order-1 order-md-2">                        
              <slider />
            </div>
          </div>                    
        </form> 
      </div>
    </div>

    <!-- // SCHEDULE -->
    <div v-show="isValidSearchMini" class="bg-lightlemonyellow rounded">
      <div class="bg-success info-table-top"></div>
      <button type="button" class="close float-right mr-2" aria-label="Close" @click.prevent="setSearchMini('false')">
        <span aria-hidden="true">&times;</span>
      </button>
      <div class="d-md-flex justify-content-around p-3 my-2">
        <!-- @include('includes.search-mini') -->
        <!-- SEARCH MINI -->
        <div class="form-row justify-content-center">
          <div class="form-group col-sm-3 col-md-3">  
            <autocomplete 
              :suggestions="availableCityList" 
              :city="selectedCityFrom"       
              @update:city="handleCityFromInputEvent" 
              input-label="From"
            >
            </autocomplete>  
          </div>
          <div class="form-group col-sm-3 col-md-3">    
            <autocomplete 
              :suggestions="availableCityList" 
              :city="selectedTo"       
              @update:city="handleCityToInputEvent"  
              input-label="To"
            >
            </autocomplete>
          </div>
          <div class="form-group col-sm-4 col-md-4">  
              <label for="startDateMini">Date of Journey</label> 
              <div id="sandbox-container-mini">
                <div class="input-group date">
                  <input name="date" id="startDateMini" class="form-control border-right-0" type="text" v-model="startDate" placeholder="Select Date">
                  <span class="input-group-append">
                      <div class="input-group-text bg-white"><i class="fas fa-calendar-alt" style="color: hsl(86, 51%, 54%);"></i></div>
                  </span>
                </div>
              </div>
          </div>
          <div class="col-sm-10 col-md-2 align-self-center">
            <button type="button" v-on:click.prevent="searchBus" class="btn btn-warning btn-search form-control px-md-1 mb-sm-2 mb-md-0 mt-md-3" :disabled="isDisabled">Search
              <i class="fa fa-search ml-1"></i>
            </button>
          </div>                          
        </div> 
        <!-- / -->
      </div>
    </div>
    <!-- // -->

    <!-- NAVIGATION -->
    <div v-if="showSchedule && !searchMini && !isSeatBooked" class="bg-lightlemonyellow rounded">
      <div class="bg-success info-table-top"></div>  
      
      <div class="card mb-3 bg-lightlemonyellow">
        <div class="card-header">
          <span class="rounded-circle ml-n2 ml-sm-0 mr-2" 
            style="
                background-color: hsl(45deg 70% 77%);
                padding: 0.6rem 0.75rem;
                /*margin-left: -0.5rem;*/
                /*margin-right: 0.5rem;*/
            "
          >
            <i class="fas fa-route"></i>
          </span>
          <span style="letter-spacing: 1px">
            {{ selectedCityFrom}} to {{ selectedTo}} 
          </span>
          <span class="h5 d-block ml-4 ml-sm-0 mt-1 px-3 text-success d-sm-inline" style="letter-spacing: 2px">
            {{convertToDate(startDate)}}
          </span>
        </div>
        <div class="card-body mt-n3 mb-md-n3 p-3 px-sm-4 d-md-flex justify-content-center align-items-center">
          <div class="px-2"> 
            <img :src="'./storage/images/bus-icon.png'" class="img-bus mx-auto d-block">
          </div>

          <!-- {{-- DATE NAVIGATION --}} -->
          <div class="px-sm-2 mb-3 mb-md-0 d-flex flex-fill justify-content-center align-items-center">
              <div class="pr-1 w-100">                    
                <button type="button" @click.prevent="handleSearch('prev')" class="px-sm-4 btn btn-info form-control rounded-pill" :disabled="isValidDate">
                <i class="fas fa-angle-double-left mr-1"></i>
                Prev Day                  
                </button>
              </div>
              <div class="pl-1 w-100">                    
                <button type="button" @click.prevent="handleSearch('next')" class="px-sm-4 btn btn-info form-control rounded-pill">
                Next Day                  
                <i class="fas fa-angle-double-right ml-1"></i>
                </button>
              </div>
          </div>
        
          <div class="px-sm-2 mb-1 mb-md-0 flex-fill">
            <button type="button" @click.prevent="handleSearchMini()" class="px-4 btn btn-warning form-control rounded-pill">
            Search <i class="fas fa-undo ml-2"></i>
            </button>
          </div>

        </div>                    
      </div>
    </div>
    <!-- // -->
    <!-- SCHEDULE TABLE  -->
    <div v-show="showSchedule && !isSeatBooked" class="info-table mb-3 rounded shadow">
      <div class="bg-warning info-table-top"></div>
      <div class="d-md-flex p-2 mb-3 rounded">
        <div class="p-2 info-table-left flex-shrink-1">
          <div class="filter-title">Fillter</div>
          <div class="filter-element">                      
            <form>
              <span 
                class="d-inline-block d-md-block ml-3 ml-md-4 px-2 px-md-0 custom-control custom-checkbox mb-1"
                v-for="(bus, index) in busTypes"
                :key="bus.bus_id"
              >
                <input type="checkbox" class="custom-control-input" :id="setBusTypeCheckId(index)" :value="bus.type" v-model="busCheckedTypes" />
                
                <!-- <input type="checkbox" class="custom-control-input" :value="bus.type" v-model="busCheckedTypes" /> -->
                <label class="custom-control-label" :for="setBusTypeCheckId(index)">
                  {{ bus.type }}
                </label>
              </span>                                       
            </form>                    
          </div>
        </div>

        <div class="p-2 mb-2 flex-fill">
          <div class="pb-2" v-if="busCheckedTypes.length > 0">
            <button 
              type="button" 
              class="btn btn-outline-info btn-sm rounded-pill mr-1"
              v-for="(type, index) in busCheckedTypes"
              @click.prevent="removeFilter(type)"
            >
              {{ type }} 
              <i class="fas fa-times-circle"></i>
            </button>                      
          </div>
          <div class="card info-scroll">
            <div class="card-body p-0">
              <!-- {{-- <div id="scrollbar"> --}} -->
              <table class="table table-striped table-hover">
                 <!-- Table Headings -->
                  <thead style="background-color:hsla(75, 58%, 64%, 1);">
                      <th>SL No.</th>                                
                      <th>Dept. Time</th>            
                   <!--    {{-- <th>Arr. Time</th>              --}} -->
                      <th>Type</th>                                
                      <th>Available Seats</th>
                      <th>Fare</th>                                
                      <th>View</th>
                      <!-- {{-- <th>&nbsp;</th> --}} -->
                  </thead>
                  <!-- Table Body -->
                  <tbody>
                      <tr v-for="(bus, index) in busesByType">
                          <td class="table-text">
                            <div> {{ index + 1 }} </div>
                          </td>

                          <td class="table-text">
                            <div> {{ bus.departure_time }} </div>
                          </td>
                          <!-- <td class="table-text">
                            <div> {{ bus.arrival_time }} </div>
                          </td>  -->
                          <td class="table-text">
                            <div> {{ bus.bus_type }} </div>
                          </td>
                          <td class="table-text">
                            <div> {{ bus.available_seats }} </div>
                          </td>
                          <td class="table-text">
                            <div> {{ bus.fare }} </div>
                          </td>
                          <td class="table-text">                          
                            <button type="button" class="btn btn-outline-primary" @click.prevent="viewSeatsOf(bus)">    
                                <i class="button-icon fas fa-eye"></i>View
                            </button>   
                          </td>
                      </tr>                                                            
                  </tbody>
              </table>                        
              <!-- {{-- </div> --}} -->
            </div>            
          </div>
        </div>                  
      </div>                              
    </div>
    <!-- // -->

    <loader :show="loading"></loader>

    <!-- @include('includes.booking') -->
    <!-- BOOKING -->      
    <div v-show="isSeatBooked" class="row justify-content-center mt-5">
      <div class="col-12">
        <div class="card">
          <div class="icon-box success">        
            <i class="fas fa-file-invoice"></i>
          </div>  
          <div class="card-body">        
            <div class="row booking-info p-3">
              <div class="col-12 mt-2">
                <p class="text-muted text-center">Your Booking Request has been completed.</p>
              
                <div class="row mx-0">         
                  <div class="col-7 p-2 shadow">
                    <div class="row mx-0">

                      <div class="col-12 mb-3 border-bottom">
                        <h4 class="card-title text-success">Booking Details</h4>
                      </div>          

                      <div class="col-12 mb-3">
                        Booking Ref: <strong>{{ bookedSeatInfo.booking_ref }}</strong>
                      </div>
                  
                     <!--  @auth
                      @if ( auth()->user()->hasAnyRole(['admin', 'super_admin', 'operator']) )
                        <div class="col-6 mb-2">
                          Name: <strong>{{ userInfo.name }}</strong>
                        </div>
                        <div class="col-6 mb-2">
                          Phone: <strong>{{ userInfo.phone }}</strong>
                        </div>
                      @else 
                        <div class="col-6 mb-2">
                          Name: <strong>{{ auth()->user()->name }}</strong>
                        </div>
                        <div class="col-6 mb-2">
                          Phone: <strong>{{ auth()->user()->phone }}</strong>
                        </div>
                      @endif
                      @endauth -->

                      <div class="col-7 mb-2">
                        Seat No(s): <strong>{{ bookedSeatInfo.seats}}</strong>
                      </div>
                      <div class="col-7 mb-2">
                        Amount: <strong>{{ bookedSeatInfo.amount }} </strong> Tk
                      </div>
                      <div class="col-6 mb-2">
                        Date: <strong>{{ bookedSeatInfo.date }}</strong>
                      </div>
                      <div class="col-6 mb-2">
                        Time: <strong>{{ selectedBus.departure_time }}</strong>
                      </div>
                      <div class="col-6 mb-2">
                        Pickup Point: {{ bookedSeatInfo.pickup_point }} 
                      </div>
                      <div class="col-6 mb-2">
                        Dropping Point: {{ bookedSeatInfo.dropping_point }} 
                      </div>
                      <div class="col-6 mb-2">
                        Coach: {{ selectedBus.bus_number_plate }} 
                      </div>                           
                    </div>
                  </div>

                  <div class="col-5 p-3"
                    style="hsl(134deg 76% 88%) !important;" 
                  >
                    <h4>
                      Payment Summary
                    </h4>
                    <div class="mt-2">
                    <!-- @auth
                            @if ( auth()->user()->hasAnyRole(['admin', 'super_admin', 'operator']) )
                              <form method="post" action="{{ route('make.payment.cash')}}">
                                @include('includes.paymentoptions')
                                @include('includes.paymentsubmit')                        
                              </form>                    
                            @else
                              <form method="post" action="{{ route('make.payment.card')}}">            
                                @include('includes.paymentsubmit')                        
                              </form>
                            @endif
                    @endauth  -->
                      <div v-if="!userRole.isGuest">
                        <div v-if="userRole.isStaff">
                          <form method="post" :action="cashPaymentRoute">
                            <csrf-token />
                            <!-- <div class="payment-options p-2 my-2">
                              <div class="radio">
                                <label class="radio-inline">
                                  <input type="radio" name="paymentMethod" id="optionsRadios1" value="cash" v-model="payment.method">
                                  Cash
                                </label>    
                              </div>
                              <div class="radio">
                                <label class="radio-inline">
                                  <input type="radio" name="paymentMethod" id="optionsRadios2" value="pos" v-model="payment.method">
                                  POS
                                </label>
                              </div>
                              <div class="form-group" v-show="payment.method=='pos'">
                                <label for="transacton">Transaction:</label>  
                                <input type="text" class="form-control" name="transaction" id="transaction" v-model="payment.transaction" placeholder="Enter transaction number">
                              </div>
                            </div> -->
                            <!-- Payment Summary    -->
                            <input id="booking_id" name="booking_id" type="hidden" :value="bookedSeatInfo.booking_ref">

                            <input id="cash_discount_id" name="cash_discount_amount" type="hidden" :value="discount.amount">
                            <div class="row">
                              <div class="col-7 py-1">
                                Subtotal ({{bookedSeatInfo.total_seats}} seat)
                              </div>
                              <div class="col-5 py-1">
                                <span class="float-right">
                                  ৳ {{bookedSeatInfo.amount}}
                                </span> 
                              </div>
                              <div class="col-12 py-1">  
                                <div v-if="!isDiscountAvailable" class="form-row">
                                  <div class="form-group mb-1 col-8">       
                                    <input type="text" class="form-control px-1" id="discountCode" placeholder="Enter Discount Code" v-model="discount.code" /> 
                                  </div>
                                  
                                  <div class="form-group mb-1 col-4">
                                    <button type="button" class="btn btn-info px-2 float-right"
                                    @click.prevent="applyDiscount()"
                                    :disabled="discount.code ==''"
                                    >
                                    Apply
                                    </button>
                                  </div>
                                  <span class="help text-danger px-2" v-if="has('discount')" v-text="get('discount')"></span>
                                </div>
                                <div v-if="isDiscountAvailable" class="form-row">
                                  <div class="col-8"> Discount <small @click="removeDiscount()" class="px-2 text-danger" style="cursor: pointer;">remove</small></div>
                                  <div class="col-4">
                                    <span class="px-2 px-2 float-right">
                                    ৳ {{ discount.amount}} </span>
                                  </div>
                                </div>
                              </div>

                              <div class="col-7 py-1 font125">
                                Total
                              </div>
                              <div class="col-5 py-1 font125">
                                <span class="float-right">
                                  ৳ {{totalAmount}}
                                </span> 
                              </div>
                              
                            </div>
                            <!-- // -->
                            <!-- Payment Options -->
                              <div class="payment-options p-2 my-2 bg-light rounded">
                              <div class="radio">
                                <label class="radio-inline">
                                  <input type="radio" class="mr-1" name="paymentMethod" id="optionsRadios1" value="cash" v-model="payment.method">
                                  Cash
                                </label>    
                              </div>
                              <div class="radio">
                                <label class="radio-inline">
                                  <input type="radio" class="mr-1" name="paymentMethod" id="optionsRadios2" value="pos" v-model="payment.method">
                                  POS
                                </label>
                              </div>
                              <div class="form-group" v-show="payment.method=='pos'">
                                <label for="transacton">Transaction:</label>  
                                <input type="text" class="form-control" name="transaction" id="transaction" v-model="payment.transaction" placeholder="Enter transaction number">
                              </div>
                            </div>
                            <!-- / -->
                            <div class="form-group my-3">
                              <button type="submit" class="btn btn-success btn-block rounded-pill" :disabled="disablePayButton">Pay Now</button>
                            </div>                                 
                          </form>                    
                        </div>
                        <div v-else>
                          <form method="post" :action="cardPaymentRoute">
                            <!-- <input type="hidden" name="_token" :value="csrf"> -->
                            <csrf-token />
                            <!-- card payment -->
                            <input id="booking_id" name="booking_id" type="hidden" :value="bookedSeatInfo.booking_ref">
                            <input id="card_discount_id" name="card_discount_amount" type="hidden" :value="discount.amount">
                            <div class="row">
                              <div class="col-7 py-1">
                                Subtotal ({{bookedSeatInfo.total_seats}} seat)
                              </div>
                              <div class="col-5 py-1">
                                <span class="float-right">
                                  ৳ {{bookedSeatInfo.amount}}
                                </span> 
                              </div>
                              <div class="col-12 py-1">  
                                <div v-if="!isDiscountAvailable" class="form-row">
                                  <div class="form-group mb-1 col-8">       
                                    <input type="text" class="form-control px-1" id="discountCode" placeholder="Enter Discount Code" v-model="discount.code" /> 
                                  </div>
                                  
                                  <div class="form-group mb-1 col-4">
                                    <button type="button" class="btn btn-info px-2 float-right"
                                    @click.prevent="applyDiscount()"
                                    :disabled="discount.code ==''"
                                    >
                                    Apply
                                    </button>
                                  </div>
                                  <span class="help text-danger px-2" v-if="has('discount')" v-text="get('discount')"></span>
                                </div>
                                <div v-if="isDiscountAvailable" class="form-row">
                                  <div class="col-8"> Discount <small @click="removeDiscount()" class="px-2 text-danger" style="cursor: pointer;">remove</small></div>
                                  <div class="col-4">
                                    <span class="px-2 px-2 float-right">
                                    ৳ {{ discount.amount}} </span>
                                  </div>
                                </div>
                              </div>

                              <div class="col-7 py-1 font125">
                                Total
                              </div>
                              <div class="col-5 py-1 font125">
                                <span class="float-right">
                                  ৳ {{totalAmount}}
                                </span> 
                              </div>
                              
                            </div>

                            <div class="form-group my-3">
                              <button type="submit" class="btn btn-success btn-block rounded-pill" :disabled="disablePayButton">Pay Now</button>
                            </div>
                            <!-- // -->
                          </form>                    
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
    <!-- // -->

    <!-- Modal -->
    <div class="modal fade" id="seatSelection" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-width  modal-dialog-centered modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="staticBackdropLabel">
                Seat Selection
              </h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click.prevent="close()">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <!-- <div class="modal-body scrollbar-modal"> -->
            <div class="modal-body">
              <!-- @include('includes.seatselection')    -->
             <!-- SEAT SELECTION  -->
              <div class="card-columns">
                <div class="seat-layout mb-4">
                  <div class="card border-primary border-top-0">
                    <div class="card-header bg-primary border-primary text-white">Seat Plan</div>      
                    <div class="card-body">
                      <div class="row driver-seat">                      
                        <button class="btn btn-outline-secondary" :disabled="true">Driver</button>
                      </div>
                      <div class="row justify-content-center" style="margin-left: -5px;">
                           
                            <button
                              class="btn btn-outline-primary col-xs-2"
                              v-bind:class="{ 
                                'is-active': seat.checked, 
                                booked: seat.status=='booked'? true : false,
                                buying: isSeatBuying(seat.status),                 
                                confirmed: seat.status=='confirmed'? true : false, 
                                empty: seat.status=='n/a'? true : false,             
                                'col-xs-offset-2': emptySpace(index, seat.seat_no) }"
                              v-for="(seat, index) in seatList"          
                              @click="toggle(seat)"           
                              :disabled="isDisabledSeatSelection(seat.status)"                   
                            >               
                              <span v-show="!isSeatBuying(seat.status)" > {{ seat.seat_no }} </span>
                              <span v-show="isSeatBuying(seat.status)" class="fas fa-sync fa-spin text-danger"></span>  
                             
                            </button> 
                      </div>
                    </div>
                    <!-- {{-- card-footer --}} -->           
                    <div class="card-footer">
                      <show-alert :show.sync="showAlert" :type="alertType"> 
                      <!-- altert type can be info/warning/danger -->
                        <strong>{{ seatNo }} </strong> has been <strong>{{ seatStatus }} </strong>
                      </show-alert>
                    </div>  
                  </div>
                </div>
                <!-- <div v-show="isSeatSelected" class="mb-4"> -->
                <div class="mb-4">
                  <div class="card border-info border-top-0">      
                    <div class="card-header bg-info border-info text-white">Selected Seat Info</div>
                    <div class="card-body p-0">
                      <h5 v-show="!isSeatSelected" class="py-2 text-center">
                        Seat's not selected yet!
                      </h5>
                      <table v-show="isSeatSelected" class="table table-striped">
                        <thead>
                          <th>Sl.#</th>
                          <th>Selected Seat</th>
                          <th>Fare</th>
                          <th>Remove</th>
                          <!-- <th>&nbsp;</th> -->
                        </thead>
                        <tbody>
                          <tr v-for="(seat, index) in selectedSeat">
                            <td class="table-text">
                              <div> {{ index + 1 }} </div>
                            </td>
                            <td class="table-text">
                              <div> {{ seat.seat_no }} </div>
                            </td>
                            <td class="table-text text-primary">
                               <div> {{ getFareFor(seat) }} </div>
                            </td>
                            <td class="table-text">
                               <div>
                                  <button @click.prevent="removeSeat(seat.seat_no, seat)" type="button" class="close" data-dismiss="alert" aria-label="Close">
                                   <i class="fa fa-times text-danger" aria-hidden="true"></i>
                                  </button>
                                </div>
                              </td>                                    
                          </tr>    
                        </tbody>
                      </table>       
                    </div>
                    <div v-show="isSeatSelected" class="card-footer total">
                      <strong>Total Amount:</strong> {{ totalFare }} 
                    </div>        
                  </div>
                </div>

                <div class="mb-4">
                  <!-- Pickup & Dropping Selection -->
                  <div class="card border-success border-top-0">
                    <div class="card-header bg-success border-success text-white">Pickup & Dropping</div>
                    <div class="card-body">
                      <!-- @include('includes.stops') -->
                      <!-- STOPS -->
                      <div class="form-group">
                        <label for="pickupPoint"> Pickup </label>
                        <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
                        <select v-model="stops.selectedPickupPoint" class="form-control" id="pickupPoint">
                          <!-- <option disabled value="">Please select one</option> -->
                          <option v-if="!error.pickupPoint" disabled value="">Please select one</option>
                          <option v-if="error.pickupPoint" disabled value="">{{error.pickupPoint }}</option>    
                          <option v-for="pickup in pickupStops">
                            {{ pickup.name }}
                          </option>                           
                        </select>
                      </div>

                      <div class="form-group">
                        <label for="droppingPoint"> Dropping </label>
                        <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
                        <select v-model="stops.selectedDroppingPoint" class="form-control" id="droppingPoint">
                          <!-- <option disabled value="">Please select one</option> -->
                          <option v-if="!error.droppingPoint" disabled value="">Please select one</option>
                          <option v-if="error.droppingPoint" disabled value="">{{ error.droppingPoint }}</option>
                          <option v-for="dropping in droppingStops">
                            {{ dropping.name }}
                          </option>                           
                        </select>
                      </div>
                      <!-- // -->
                    </div>
                  </div>         
                </div>

                <div class="mb-4">
                  <!-- @include('includes.errors')
                  @auth
                    @if ( auth()->user()->hasAnyRole(['admin', 'super_admin', 'operator']) )
                      @include('includes.operator')
                    @elseif ( auth()->user()->hasVerifiedPhone() )       
                        @include('includes.user')        
                    @else
                        @include('includes.unverified.user')                
                    @endif
                  @endauth
                  @guest
                    @include('includes.guest')
                  @endguest -->
                  <div v-if="!userRole.isGuest">
                    
                    <div v-if="userRole.isStaff">
                      <h2>STAFF</h2>
                      <div class="card border-secondary border-top-0">
                        <div class="card-header bg-secondary border-secondary text-white">Admin/ Operator</div>
                        <div class="card-body">
                          <form v-on:submit.prevent="seatBookingByStaff(), showTheModal('seatSelection', false)" @keydown="form.errors.clear($event.target.name)">
                            <div v-show="form.phone!=''" class="text-center">
                              <div v-show="userExist" class="alert alert-success" role="alert">                          
                                <span class="fa-stack fa-2x mr-2">
                                  <i class="fas fa-circle fa-stack-2x"></i>
                                  <i class="fas fa-user-check fa-stack-1x fa-inverse"></i>
                                </span>       
                                User already exist!
                              </div>
                              <div v-show="!userExist" class="alert alert-warning" role="alert">
                                <span class="fa-stack fa-2x mr-2">
                                  <i class="fas fa-user fa-stack-1x"></i>
                                  <i class="fas fa-ban fa-stack-2x" style="color:Tomato"></i>
                                </span>
                                User doesn't exist!
                              </div>
                            </div>

                            <div class="m-1">                                 
                              <input type="hidden" name="userId" id="userId1" v-model="userInfo.id" disabled>
                            </div>
                            <div class="form-group">
                            <label for="phone" class="control-label">Mobile No.</label>
                            <div class="input-group">
                              <span class="input-group-prepend">
                                <div class="input-group-text bg-white">
                                  <i class="fas fa-mobile-alt"></i>
                                </div>
                              </span>
                              <input id="phone" type="text" class="form-control border-left-0" name="phone" v-model.lazy="form.phone"
                                placeholder="Enter mobile number here" 
                              >
                            </div>
                            <span class="help text-danger" v-if="form.errors.has('phone')" v-text="form.errors.get('phone')"></span>
                            <span class="text-mute text-danger" v-if="userInfo.hasOwnProperty('error')" v-text="userInfo.error"></span>
                            </div>

                            <div class="form-group">
                            <label for="name" class="control-label">Name</label>
                            <div class="input-group">
                              <span class="input-group-prepend">
                                <div class="input-group-text bg-white">
                                  <i class="fas fa-user"></i>
                                </div>
                              </span>
                              <input id="name" type="text" class="form-control border-left-0" name="name" v-model="form.name"
                                placeholder="Enter name here" 
                              >
                            </div>
                            <span class="help text-danger" v-if="form.errors.has('name')" v-text="form.errors.get('name')"></span>
                            </div>            

                            <div class="form-group">
                            <label for="email" class="control-label">E-Mail</label>
                            <div class="input-group">
                              <span class="input-group-prepend">
                                <div class="input-group-text bg-white">
                                  <i class="fas fa-envelope"></i>
                                </div>
                              </span>
                              <input id="email" type="email" class="form-control border-left-0" name="email" v-model="form.email"
                                placeholder="Enter email here" 
                              >
                            </div>
                            <span class="help text-danger" v-if="form.errors.has('email')" v-text="form.errors.get('email')"></span>
                            </div>                        
                            
                            <button class="btn btn-primary btn-block rounded-pill" :disabled="!isValid || form.errors.any()">Continue</button>
                          </form>
                        </div>
                      </div>
                    </div>  

                    <div v-else-if="userRole.isVerified"> 
                      <div class="d-flex">
                        <div class="p-2 flex-fill info-l">
                          <i class="mt-3 fas fa-user-clock fa-2x"></i>
                        </div>
                        <div class="p-2 flex-fill info-r">
                          <h5 class="mx-2">Ticket!</h5>
                          <form v-on:submit.prevent="seatBookingByUser(), showTheModal('seatSelection', false)">      
                          <p class="mt-2 mx-2"> Book The Ticket(s) 
                            <button :disabled="!isValid" class="mt-2 btn btn-primary btn-block rounded-pill">Continue</button>
                          </p>
                          </form>
                        </div>        
                      </div>      
                    </div>

                    <div v-else>
                      <h3>Unverified User</h3>

                      <div class="d-flex">          
                        <div class="p-2 flex-fill warning-l">
                          <i class="mt-2 fas fa-exclamation-triangle fa-2x"></i>
                        </div>
                        <div class="p-2 flex-fill warning-r">
                          <h4 class="mx-2">Oops!</h4>
                          <p class="mx-2">Phone Verification Pending.<br>             
                            <a class="mt-2 btn btn-secondary btn-block" :href="phoneVerificationRoute" role="button">Verify Your Phone Please</a>    
                          </p>           
                        </div>
                      </div>
                    </div>

                  </div>
                  
                  <div v-else>
                      <!-- <h3>GUEST</h3> -->
                      <div class="d-flex">          
                        <div class="p-2 flex-fill warning-l">
                          <i class="mt-3 fas fa-user-times fa-3x"></i>
                        </div>
                        <div class="p-2 flex-fill warning-r">
                          <h4 class="mx-2 pb-2 border-bottom">Oops!</h4>
                          <div class="mx-2 my-2 text-center">
                            You are not logged in!   
                            <a class="mt-3 mb-2 px-2 btn btn-warning btn-block rounded-pill" :href="loginRoute" role="button">Login</a>    

                            <a class="mb-2" :href="registerRoute">New User?
                            </a>    
                          </div>                        
                        </div>
                      </div>
                  </div>
                </div>
              </div>
             <!-- // -->
            </div>
            <!-- <div class="modal-footer">
              <button type="button" class="btn btn-primary rounded-pill px-5" data-dismiss="modal">Close</button>            
            </div> -->
          </div>
        </div>
    </div>    
    <!-- // -->

  </div>
   
</template>
<script>
    // import Modal from './AppModal'; 
    // const URL = './storage/images/bus-icon.png';
    import Stepper from './Stepper';
    import Slider from './Slider';

    const Url = {
      BOOKING_BY_STAFF_URL: 'bookings/byStaff'
    };
      const BOOKING_BY_STAFF_URL = 'bookings/byStaff';

    export default {
      props: [
        'user',
        'phoneVerificationRoute',
        'cashPaymentRoute',
        'cardPaymentRoute',
        'loginRoute',
        'registerRoute'
      ],

       components: {          
            // 'mymodal': Modal,          
            Stepper,
            Slider,
        },     
      
      data() {
          return {            
              alertType: '',
              availableCityList: [],
              availableStopList: [],
              bookedSeatInfo: { },
              busId:'',
              busScheduleId:'',
              busError: false,
              buses:[],
              busTypes: [],
              bus: {
                checkedTypes: [],
              },    
              busCheckedTypes: [],
              // csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),        
              cityList:[],
              cityToList:[],
              dataErrors: [],
              discount: {
                amount: 0,
                code: ''
              },
              droppingStops: [],
              pickupStops: [],
              //error: false,
              error: {
                city: false,
                pickupPoint: false,
                droppingPoint: false
              },
              errors: {},
              loading: false,
              message: '',
              modal: false,
              searchMini: false,
              showAlert: false, // for alert Component
              showSearch: true,
              showSchedule: false,              
              scheduleId:'',
              selection: '',
              startDate: '11-04-2021',               
              selectedBus: '',
              // selectedCityFrom: 'Dhaka',
              // selectedTo: 'Sylhet',
              selectedCityFrom: 'Sylhet',
              selectedTo: 'Dhaka',
              // selectedPickupPoint: '',
              // selectedDroppingPoint: '',
              stops: {
                selectedPickupPoint: '',
                selectedDroppingPoint: '',
              },
              //url: 'seatbooking',             
              url: 'bookings',             
              // seat display
              seatChar:["A","B", "C" , "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O"],                             
              seatNo: '',
              seatStatus: '',              
              seatError: false,                                 
              selectedSeat: [],
              seatList: [],              
              steps: {
                search: {
                  default: true,
                  isDoing: false,
                  isDone: false
                },
                select: {
                  default: true,
                  isDoing: false,
                  isDone: false
                },
                buy: {
                  default: true,
                  isDoing: false,
                  isDone: false
                },
              },
              instanceOfScrollbarInfoTable: undefined,
              indexList: [],
              index: 2, // space starting from this index then 2+4, 6+4
              numberOfRow: '',              
              totalFare: 0,
              totalSeats: 0,              
              // end seat display
              //guestUser: true,   
              payment: {
                method: 'cash',
                transaction: ''
              },           
              userInfo: {
                id: '',
                name: '',
                phone: '',
                email:'',
                error: '',
              },
              userRole: {
                isGuest: undefined,
                isStaff: undefined,
                isVerified: undefined,
              },
              // userExist: false,
              userExist: '',
              form: new Form({  //data as object
                name: '',
                email:'',
                phone:'',
                //non form data
                bus_id: '',
                date: '',
                schedule_id: '',
                bus_schedule_id: '',
                selected_seats: '',
                total_seats: '',
                amount: '',
                pickup_point: '',
                dropping_point:'',
              })
          }
      },
      
      // created() {
      //   this.Url = Url;
      // }, 
      mounted() {
           console.log('Seat search Component ready.');
           //this.createIndexList();            
           //this.cityList = JSON.parse(this.cities);
           
           this.fetchCities();
           this.fetchStops();
           this.showDate();                      
           this.showDateMiniSearch();           
           //console.log(this.user);            
          if (this.user == 'guest') {
            this.userRole.isGuest = true;
            console.log('guest')
            // return;
          } else
          this.getRoleOf(JSON.parse(this.user));          
           // this.enableScroll();         
            // Echo.channel('mychannel.1')
            //   .listen('SeatStatusUpdatedEvent', this.updateSeatStatus);             
          this.eventListenThroughBroadcastChannel();
      },
      beforeUnmount() {
        this.instanceOfScrollbarInfoTable.destroy();
      },
      watch: {
       'form.phone'(value, oldValue) {
        this.getUserInfoIfExist(value);
       },
       'selectedSeat.length'(value) { 
        this.totalSeats = value;
       },
       seatStatus() {        
        var type = this.seatStatus;
        switch (type) {
          case 'available':
            this.alertType = 'success';           
            break;            
          case 'booked':
           this.alertType = 'warning';
            break;          
          case 'confirmed':
            this.alertType = 'danger';           
            break;  
          case 'cancelled':
            this.alertType = 'info';
            break;
          default:
            console.log('Sorry, we are out of ' + type + '.');
        }
       },
       //////// 5feb /////
       // buses() {
       //  this.isBusAvailable();
       //  //this.sortBusByDepartureTime(); 
       // }, 
       /////
       // selectedCityFrom() {
       //    //console.log();
       //   // this.fetchCityToList(this.selectedCityFrom);                        
       //    //this.pickupStopsBy(this.selectedCityFrom);   // Pickup Area List based On From City       
          
       //   //this.arr.push(val);
       // },
       // selectedTo() {
       //    //this.buses=[];
       //    //this.droppingStopsBy(this.selectedTo);   // Pickup Area List based On From City       
       // },      
       
        seatList() {
            this.createIndexList();
        }
      },
      computed: {
        // userNotExist() {        
        //   return (!this.userExist ||
        //     this.userInfo.error
        //     )
        //    ? true : false;
        // },
        // self() { return { ...this } },
        // userIsGuest() {
        //   return (this.user === 'guest') ? true : false;
        // },
        // userIsStaff() {
        //   // if (this->user !='guest') {
        //   //   console.log('STAFF', this.user);
        //   //   return (this.user.role === 'staff') ? true : false;            
        //   // // }
        //   // return false;
        //   if (this.user.role == 'staff') {
        //     console.log('STAFF', this.user);
        //     return true;
        //   } 
        //   return false;
        // },
        // isVerifiedRegularUser() {
        //   console.log(this.user.phone_verified);
        //   console.log(this.user.name);
        //   if (this.user.phone_verified == true) {
        //     console.log('VUUUSR', this.user);
        //     return true;
        //   } 
        //   console.log('UNSR', this.user);
        //   return false;
        // },        
        isDiscountAvailable() {
          if (this.discount.amount !==0) return true;
          return false;
        },
        styles() {
          return {
           'background-image': `url(${URL})`,
            'background-repeat': 'no-repeat',
            'background-size': 'cover'
          }
        },

        totalAmount() {
          let netTotal = this.bookedSeatInfo.amount - this.discount.amount;
          return netTotal;
        },
        isValidDate() {

          // today = new Date()
          // days = 86400000 //number of milliseconds in a day
          // fiveDaysAgo = new Date(today - (5*days))
          
          const days = 86400000;

          let today = new Date();        
          
          let startDate = this.convertStringToDate(this.startDate)

          let searchDate = new Date(startDate - (1*days))

          // to be deleted
          let dateString = this.convertDateToString(searchDate)

          // console.log('T=', today)
          // console.log('SrchD=', startDate)
          // console.log('prev day=', searchDate)
          // console.log('date str =', dateString)
          // del

          if(searchDate <= today){
            return true;
          }
          return false;
        },
        isValidSearchMini() {
          if (this.showSchedule == true && 
              this.searchMini == true)
            return true;
          return false;
        },
        busesByType() {
          const length = this.busCheckedTypes.length;
          if (length === 0) {
            return this.buses;
          }
          return this.buses.filter(bus => { //1
            for (let i = 0; i < length; i++) {
              if (bus.bus_type == this.busCheckedTypes[i]) {
                return bus;
              }
            }
            return false;
          })
        },
        showDataErrors() {
          return (this.dataErrors.length > 0) ? true : false;
        },
        // routeName() {
        //   return '/pay/'+this.bookedSeatInfo.booking_ref;
        // },
        // totalFareForSelectedSeats() {          
        //   var fare = 0;
        //   let len = this.selectedSeat.length;
        //   for (var i=0; i<len; i++){
        //     //fare = fare + parseInt(this.selectedSeat[i].fare, 10);
        //     fare = fare + parseInt(this.getFareFor(this.selectedSeat[i]), 10);
        //   }
        //   console.log('total fare:', fare);
        //   console.log('total seats:', len);
        //   this.totalFare = fare; 
        //   this.totalSeats = len;         
        // },
        disablePayButton() {
          if ( Object.keys(this.bookedSeatInfo).length === 0 ) return true; // empty object

          if (this.payment.method == 'pos') { 
            return ( this.payment.transaction == ''  || this.bookedSeatInfo.booking_ref == '') ?
                true : false;
          }
          return ( this.bookedSeatInfo.booking_ref == '' ) ?
                true : false;
        },
        // validPaymentOption() {
        //   return ( this.payment.method == 'pos' && 
        //     this.payment.transaction != "" ) ?
        //     true : false;
        // },
        isDisabled() {        
          return ( this.selectedCityFrom == "" || this.selectedTo == "" || this.startDate =='' || !this.validJourneyDate ) ? true : false;
       },

       validJourneyDate() {
        //let today = new Date().toISOString().slice(0, 10);
        let date = this.startDate.split('-');

        let today = new Date();
        let dateOfJourney = new Date(`${date[2]}-${date[1]}-${date[0]} 23:50:00`); //yyyy-mm-dd        
        return (dateOfJourney >= today) ? true : false;
       },
        //showSelectedSeatList() {
        isSeatSelected() {
          let len = this.selectedSeat.length;
          return ( len >0 ) ? true : false;
        },
        isValid() {
            return this.isSeatSelected != false &&
              this.stops.selectedPickupPoint != '' &&
              this.stops.selectedDroppingPoint != ''
          },
        isSeatBooked() {
          let len = Object.keys(this.bookedSeatInfo).length;
          //return ( len >0 ) ? true : false;
          if (len >0) {
            this.showSearch = false;
            this.stepsAction('buy', 'isDoing');
            return true;
          } 
          return false;
        },
      },
      methods: {
        stepsAction(name, action) {

          let isDoing = this.steps.[name].isDoing; 
          let isDone = this.steps.[name].isDone;
          console.log('Doing', isDoing);
          console.log('Done', isDone);
          

          if (action === 'default') {
            this.steps.[name].default = true;
            this.steps.[name].isDoing = false;
            return;
          }

          if (action === 'isDoing') {
            this.steps.[name].default = false;
            this.steps.[name].isDoing = true;
            return;
          }

          this.steps.[name].isDoing = false;          
          this.steps.[name].isDone = true;
        },
        removeDiscount() {
          this.discount.amount = 0;
        },
        has(field) {
          
          if (Object.keys(this.errors).length > 0) 
            return this.errors.hasOwnProperty(field);
          return false;
        },
        get(field) {
            if (this.errors[field]) {
                return this.errors[field][0];
            }
        },
        applyDiscount() {
          //bookedSeatInfo
          console.log('discount')
          let code = this.discount.code.toUpperCase();
          this.discount.amount = 0;
          this.errors = {};

          var vm = this;

          // this.loading = true;
          axios.post('/discount', {
            code: code,
            amount: this.totalFare
          })
          .then(response => {
            console.log(response)
            vm.discount.amount = response.data;
            vm.loading = false;
          })
          .catch(error => {
            console.log('err=',error.response.data)
            vm.errors = error.response.data.errors;
            console.log(error.response.data)
            vm.loading = false;
          })

        },
        getRoleOf(user) {
         if (user.role === 'staff') {
          this.userRole.isStaff = true;
          // console.log('staff');
          return;
         }

         if (user.phone_verified === true) {          
          this.userRole.isVerified = true; 
          // console.log('VVVVUUUU')
          return;
         }
        },
        handleSearch(day) {
          const days = 86400000;                    
          const startDate = this.convertStringToDate(this.startDate)
          // console.log('sssss', startDate)
          
          if (day == 'prev') {
            // let searchDate = new Date(startDate - (1*days))
            let searchDate = this.daysToDate('sub', 1, startDate);
            let dateString = this.convertDateToString(searchDate)
            this.startDate = dateString;
            this.searchBus();            
            return;
          }

          
          // let searchDate = startDate.setDate(startDate.getDate() + 1);
          // let searchDate = this.addDays(startDate, 1);
          let searchDate = this.daysToDate('add', 1, startDate);

          let dateString = this.convertDateToString(searchDate)
          this.startDate = dateString; 

          // console.log('SrchD=', startDate)
          // console.log('next day=', searchDate)
          // console.log('date str =', dateString)
          this.searchBus();
        },
        handleSearchMini() {
          this.searchMini = true;
          this.showDateMiniSearch()
        },
        convertDateToString(date) {
          // var d = new Date(date);
          return [
            ('0' + date.getDate()).slice(-2),
            ('0' + (date.getMonth() + 1)).slice(-2),
            date.getFullYear()
          ].join('-');          
        },
        convertStringToDate(dateString) {
          // var dateString = "23-10-2015"; // Oct 23

          let date = dateString.split("-");

          // month is 0-based, that's why we need dataParts[1] - 1
          // Convert String Using Number()
          // return new Date(Number(dateParts[2]), Number(dateParts[1]) - 1, Number(dateParts[0])); 
           return new Date(`${date[2]}-${date[1]}-${date[0]} 23:50:00`); //yyyy-mm-dd        

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
        // addDays(date, days) {
        //   let result = new Date(date);
        //   result.setDate(result.getDate() + days);
        //   return result;
        // },
        daysToDate(action, days, date) {
          const result = new Date(date);

          if (action == 'add') {
           result.setDate(result.getDate() + days);
           return result;
          }

          result.setDate(result.getDate() - days);          
          return result;
        },
        handleCheckedTypes(e) {
          console.log('evnt-', e)
        },
        addFareToTotal(seat) {
          let fare = parseInt(this.getFareFor(seat), 10);
          this.totalFare = this.totalFare + fare;
          console.log('total fare=', this.totalFare)
        },
        removeFilter(name) {
          let i = this.busCheckedTypes.indexOf(name);
          this.busCheckedTypes.splice(i, 1); 
        },
        removeFareFromTotal(seat) {
          let fare = parseInt(this.getFareFor(seat), 10);
          this.totalFare = this.totalFare - fare;
          console.log('total fare=', this.totalFare)
        },
        handleCityFromInputEvent(value) {
          // console.log('ppppp=', value)
          this.selectedCityFrom = value
        },
        handleCityToInputEvent(value) {
          // console.log('ppppp=', value)
          this.selectedTo = value
        },        
        eventListenThroughBroadcastChannel() {
          Echo.channel('mychannel')
              .listen('SeatStatusUpdated', this.updateSeatStatus); 
        },
        getIdOfCity(name) {
          return this.availableCityList.find(city => city.name == name).id;
        },
        getUserInfoIfExist(phone) {
          if (phone.length < 11) {
            this.userInfo.error = 'Phone number not given or Invalid number';
            this.resetUserInfo();
            return;
          }
          this.loading = true;          
          this.userInfo.error = ''; 
          this.resetUserInfo();
          var vm = this;                
          axios.get(`/users/${phone}`)
              .then(function (response) {                  
                response.data.error ? vm.error = response.data.error : vm.userInfo = response.data;
                if( !vm.isEmpty(vm.userInfo) ){                  
                  vm.userExist = true;
                  vm.userInfo.error = '';
                  vm.fillupUserForm(vm.userInfo);
                  //console.log('not empty');                 
                }       
                vm.loading = false;
          });
        },
        fillupUserForm(userInfo) {          
          this.form.phone = userInfo.phone;
          this.form.name = userInfo.name;
          this.form.email = userInfo.email;          
        },
        isEmpty(obj) {
          //console.log('lenn='+ Object.values(obj).length);
          //return Object.keys(obj).length === 0;
          return Object.values(obj).length <= 1;
        },
        resetUserInfo() {
          this.userExist = false;
          this.form.name = '';
          this.form.email = '';
        },
        setSearchMini(status) {
          if (status == 'false') {
            this.searchMini = false;
            return; 
          }
          this.searchMini = true;
        },
        sortBusByDepartureTime() {
          var vm = this;
          this.buses.sort(function(a, b) {
            var timeA = vm.convertTime12to24(a.departure_time);
             // ignore upper and lowercase
            var timeB = vm.convertTime12to24(b.departure_time );// ignore upper and lowercase
            if (timeA < timeB) {
              return -1;
            }
            if (timeA > timeB) {
              return 1;
            }
            // names must be equal
            return 0;
          });
        },
        showTheModal(modalId, show) {                    
          if (show) {

            $(`#${modalId}`).modal({
              backdrop: 'static'
            })    
            return;
          }
          $(`#${modalId}`).modal('hide');    
        },
        convertTime12to24(time12h) {
          const [time, modifier] = time12h.split(' ');

          let [hours, minutes] = time.split(':');

          if (hours === '12') {
            hours = '00';
          }

          if ( modifier === 'PM' || modifier === 'pm') {
            hours = parseInt(hours, 10) + 12;
          }

         // return `${hours}:${minutes}`;
          return `${hours}${minutes}`;
        },
        enableScroll() {
          this.instanceOfScrollbarInfoTable = OverlayScrollbars(document.getElementsByClassName("info-scroll"),
                    { 
                      className: "os-theme-dark",
                      sizeAutoCapable: true,
                      scrollbars: {
                        autoHide: "never",
                        clickScrolling: true
                      } 
                    })
        },   
        getFareFor(seat) {
          //console.log(seat);
          let combinedFare = this.isCombinedType(seat.fare);
          if (combinedFare) {
            let fares = seat.fare.split('|');
            let f1, f2;
            f1 = parseInt(fares[0], 10);
            f2 = parseInt(fares[1], 10);                        

            return (seat.special) ? 
                    ( (f1 > f2) ? f1 : f2 ) : ( (f1 < f2) ? f1 : f2 );
          }
          return seat.fare;
        },        
        isCombinedType(fare) {
          return fare.includes('|') ? true : false;
        },
        close() {
                this.modal = false;
                this.loading = false;                
                this.selectedSeat = [];
                if(this.form.errors) {
                  this.form.errors.clear();                
                }
                this.stepsAction('select', 'default');
        },
        // isBusAvailable() {
        //   let len = this.buses.length;
        //   //this.showSchedule = ( len >0 && this.error==false && this.selectedTo !=="" ) ? true : false;  //true show table
        //   this.showSchedule = ( len >0 ) ? true : false;  //true show table
        // },
        isSeatBuying(seatStatus){
          return seatStatus == 'buying' ? true : false;
        },
        updateSeatStatus(evnt) {          
          var seatNo = evnt.seat.seat_no;
          console.log('seaaatno=', seatNo);
          //var vm = this;
          if ( this.busScheduleId == evnt.busScheduleId &&
              this.startDate == evnt.date) {
            
              var indx = this.seatList.findIndex(function(seat){ 
                // here 'seat' is array object of selectedSeat array
                return seat.seat_no == seatNo;
              });

             // this.seatList[indx].status = "booked"; //prev
            this.seatList[indx].status = evnt.seat.status;
            this.seatNo = seatNo;
            this.seatStatus = evnt.seat.status;         
            this.showAlert = true;
          }
          console.log(evnt.seat.seat_no, evnt.busScheduleId, evnt.date);
        },
        async searchMain() {
          this.loading = true;
          // console.log('sMMMM')

          await this.searchBus()
          
          // console.log('sMMEEEEE')

          this.loading = false;

           if (this.busError) {
              this.seatNotAvailableAlert('SCHEDULE', 'warning');
              return;
           }
           this.sortBusByDepartureTime(); 
           this.setBusTypes();
           if (this.showSearch == true) {
            this.showSearch = false;
           }
           if (this.searchMini == true) {
            this.searchMini = false;
         }
        },
        // searchBus() {         
        //   console.log(this.startDate);

        //   this.busError = false;
        //   // this.loading = true;
           
        //   var vm = this;
        //   this.buses ='';
        //   axios.get('/search', {
        //       params: {                
        //         // from: this.selectedCityFrom,
        //         // to: this.selectedTo,
        //         from: this.getIdOfCity(this.selectedCityFrom),
        //         to: this.getIdOfCity(this.selectedTo),
        //         date: this.startDate,              
        //       }  
        //     })          
        //     .then(function (response) {             
        //        console.log(response.data);
               
        //        response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
        //        vm.loading = false;
        //        if (vm.busError) {
        //           vm.seatNotAvailableAlert('SCHEDULE', 'warning');
        //           return;
        //        }
        //        vm.sortBusByDepartureTime(); 
        //        vm.setBusTypes();
        //        if (vm.showSearch == true) {
        //         vm.showSearch = false;
        //        }
        //        if (vm.searchMini == true) {
        //         vm.searchMini = false;
        //        }               
        //     });
        //     //888888
        //     /*this.loading = false;
        //      if (this.busError) {
        //         this.seatNotAvailableAlert('SCHEDULE', 'warning');
        //         return;
        //      }
        //      this.sortBusByDepartureTime(); 
        //      this.setBusTypes();
        //      if (this.showSearch == true) {
        //       this.showSearch = false;
        //      }
        //      if (this.searchMini == true) {
        //       this.searchMini = false;
        //      }*/
        //     //888
        // },
        async searchBus() {         
          // console.log(this.startDate);
          // this.steps.search.isDoing = true;
          this.stepsAction('search', 'isDoing');
          this.busError = false;
          this.loading = true;
          console.log('sMMMM')           
          var vm = this;
          this.buses ='';

          await this.getBusData().then(response => {
            // console.log(response.data);

            response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
             
             vm.loading = false;
             // vm.steps.search.isDoing = false;
             // vm.steps.search.isDone = true;
             vm.stepsAction('search', 'isDone');
             
             // vm.steps.select.isDoing = true;
             // vm.stepsAction('select', 'isDoing');
             

             console.log('sMMMMEEEE1111')
             if (vm.busError) {
                vm.seatNotAvailableAlert('SCHEDULE', 'warning');
                return;
             }
             vm.sortBusByDepartureTime(); 
             vm.setBusTypes();
             if (vm.showSearch == true) {
              vm.showSearch = false;
             }
             if (vm.searchMini == true) {
              vm.searchMini = false;
             }               
             if (vm.showSchedule == false) {
              vm.showSchedule = true;
             }               

          })
          console.log('sMMMM222222222')          
        },
        async getBusData() {
          try {
            const response = await axios.get('/search', {
              params: {                
                // from: this.selectedCityFrom,
                // to: this.selectedTo,
                from: this.getIdOfCity(this.selectedCityFrom),
                to: this.getIdOfCity(this.selectedTo),
                date: this.startDate,              
              }  
            })
            return response;
          }
          catch (error) {
            console.log(error)
            this.loading = false
          }

        },
        setBusTypes() {
          const buses = this.buses;
          if (buses.length == 0) return;
          let result = _(buses)
          .groupBy(bus => bus.bus_type)
          .map((value, key) => ({type: key, info: value}))
          .value();
          
          console.table(result);
          this.busTypes = result;
        },
        setBusTypeCheckId(id) {
          let i = id+1;
          console.log('cs=', i)
          return `busTypeCheckId${i}`
        },
        //viewSeatsOf(busScheduleId, busId, busFare) {
        viewSeatsOf(bus) {
          // console.log('busSchId=', scheduleId);
          // console.log('busId=', busId);
          // this.steps.select.isDoing = true;
          this.stepsAction('select', 'isDoing');

          this.selectedBus = bus;
          this.seatError = false;
          this.selectedSeat = [];
          this.busScheduleId = bus.bus_schedule_id;
          this.busId = bus.bus_id;
          // this.selectedPickupPoint = '';
          // this.selectedDroppingPoint = '';
          this.stops.selectedPickupPoint = '';
          this.stops.selectedDroppingPoint = '';
          this.totalFare = 0;
          this.loading = true;
          this.pickupStopsBy(this.selectedCityFrom);
          this.droppingStopsBy(this.selectedTo);
          var vm = this;
          axios.get('/viewseats/buses/'+bus.bus_id, {
              params: {
                // from: this.selectedCityFrom,
                // to: this.selectedTo,
                // date: this.startDate,
                bus_schedule_id: bus.bus_schedule_id,
                bus_id: bus.bus_id,
                bus_fare: bus.fare,
                date: vm.startDate,
              }  
            })          
            .then(function (response) {             
                console.log(response.data);
                response.data.error ? vm.seatError = response.data.error : vm.seatList = response.data;
                vm.loading = false;
                if (vm.seatError) {
                  vm.seatNotAvailableAlert('SEAT PLAN', 'error');
                  return;
                }
                // vm.modal = true;
                vm.showTheModal('seatSelection', true);
            });
        },

        seatNotAvailableAlert(val, type) {
          swal({
            //title: "Sorry! Not Available",
            title: val,
            text: "Not Available!",
           // title: '<span style="color:#F8BB86"> <strong>'+val+'</strong></span></br>Not Available. Sorry!',
            //text: '<span style="color:#F8BB86"> <strong>'+val+'</strong></span> Not Available.',
            //html: true,
            //type: "info",
            //type: type,
            icon: type,
            timer: 3000,
            //showConfirmButton: false,
            closeOnClickOutside: true,
          });
        },
        seatBookingByStaff() {         
          // this.url = (this.userInfo.hasOwnProperty('id')) ? `bookings/byStaff/${this.userInfo.id}` : 'bookings/byStaff';
          // if (this.userInfo.name == '' && this.form.name != '' ) {
          //   this.userInfo.name = this.form.name;
          // }
          if (this.userExist) {
            // this.url = `bookings/byStaff/${this.userInfo.id}`;
            // this.url = `${this.Url.BOOKING_BY_STAFF_URL}/${this.userInfo.id}`;
            this.url = `${BOOKING_BY_STAFF_URL}/${this.userInfo.id}`;
          } else {
            // this.url = 'bookings/byStaff';
            this.url = BOOKING_BY_STAFF_URL;
            this.userInfo.phone = this.form.phone;
            this.userInfo.name = this.form.name;
          }
          var vm = this; 
          swal({
            title: "Are you sure?",
            text: "This will register a BOOKING for you",
            icon: "info",                 
            //dangerMode: true,
            buttons: {
                cancel: "cancel",
                confirm: {
                  text: "Yes! Book It.",
                  value: true,
                },                                
            },
          })
          .then((value) => {
            if (value) {

              vm.loading = true;
              vm.buses = []; // hide table
              vm.changeStatusOfSelectedSeat(vm.selectedSeat); 
              // // non form data  
              vm.form.bus_id = vm.busId;
              vm.form.date = vm.startDate;
              //vm.form.schedule_id = vm.scheduleId;
              vm.form.bus_schedule_id = vm.busScheduleId;
              vm.form.selected_seats = vm.selectedSeat;
              vm.form.total_seats = vm.totalSeats;
              vm.form.amount = vm.totalFare; 
              vm.form.pickup_point = vm.stops.selectedPickupPoint; 
              vm.form.dropping_point = vm.stops.selectedDroppingPoint; 


              vm.form.post(vm.url)
                  //.then(response => alert('Wahoo!'));
              .then(function (response) {
                 //console.log(response.data)
                 vm.selectedSeat= [];                                  
                 vm.bookedSeatInfo = response;
                 vm.modal = false;
                 vm.loading = false;
                 // vm.select.isDoing = false;
                 // vm.select.isDone = true;
                 vm.stepsAction('select', 'isDone');
                 
                 //console.log('res=', response);
              })
              .catch(function (error) {
                console.log(error);
                vm.loading = false;
              });
              
            } 
            
          }); 
        },
        seatBookingByUser() {          
          var vm = this; 
          swal({
            title: "Are you sure?",
            text: "This will register a BOOKING for you",
            icon: "info",                 
            //dangerMode: true,
            buttons: {
                cancel: "cancel",
                confirm: {
                  text: "Yes! Book It.",
                  value: true,
                },                                
            },
          })
          .then((value) => {
            if (value) {

              vm.loading = true;
              vm.buses = []; // hide table
              vm.changeStatusOfSelectedSeat(vm.selectedSeat);               

              axios.post(vm.url, {
                //bus_id: vm.busId,
                date: vm.startDate,
                //schedule_id: vm.scheduleId,
                bus_schedule_id: vm.busScheduleId,
                selected_seats:vm.selectedSeat,
                total_seats: vm.totalSeats,
                amount: vm.totalFare,
                pickup_point:  vm.stops.selectedPickupPoint,
                dropping_point: vm.stops.selectedDroppingPoint 
              })                           
              .then(function (response) {
                 //console.log(response.data)
                 vm.selectedSeat= [];
                 vm.bookedSeatInfo = response.data;
                 vm.loading = false;
                 vm.modal = false;
                 vm.stepsAction('select', 'isDone');
                 // response.data.error ? vm.busError = response.data.error : vm.buses = response.data;
              })
              .catch(function (error) {
                //console.log('error='+ error);
                console.log(error.response.data.errors);
                vm.dataErrors = Object.values(error.response.data.errors);
                console.log(vm.dataErrors);
                vm.loading = false;
              });              
            } //if            
          }); 
        },
        // showDataErrors() {
        //   return (this.dataErrors.length > 0) ? true : false;
        // },
        changeStatusOfSelectedSeat(selectedSeat) {
          var vm = this;
          selectedSeat.forEach( function(seat){
            seat.status = (vm.url == 'bookings') ? 'booked' : 'buying';
            //seat.status = 'buying';
          });
        },
        fetchCities() {
          this.loading = true;
          this.availableCityList= [];            
          var vm = this;                
          axios.get('/api/cities')  
              .then(function (response) {
                 response.data.error ? vm.error = response.data.error : vm.availableCityList = response.data;
                 vm.loading = false;
          });
        },
        fetchStops() {
          this.loading = true;
          this.availableStopList= [];            
          var vm = this;                
          axios.get('/api/stops')  
              .then(function (response) {
                 response.data.error ? vm.error = response.data.error : vm.availableStopList = response.data;
                 vm.loading = false;
          });
        },        
        // getCityIdBy(cityName) {
        //   let city = this.availableCityList.find(city => city.name == cityName);
        //   return city.id;
        // },
        pickupStopsBy(city) {          
          this.error.pickupPoint = false;
          this.loading = true;
          let cityId = this.getIdOfCity(city);      
      
          this.pickupStops = [];          
          this.pickupStops =  this.availableStopList.filter(stop => stop.city_id == cityId);
          this.loading = false;
        },

        droppingStopsBy(city) {          
          this.error.droppingPoint = false;
          this.loading = true;
          let cityId = this.getIdOfCity(city);
          
          this.droppingStops = [];          
          this.droppingStops =  this.availableStopList.filter(stop => stop.city_id == cityId);
          this.loading = false;
        },        

        showDate() {
          var vm = this;
          $('#sandbox-container .input-group.date').datepicker({
              format: 'dd-mm-yyyy',                        
              startDate: '0d',
              todayHighlight: true,
              autoclose: true
          }).on("changeDate", () => {vm.startDate = $('#sandbox-container #startDate').val()});

        },
        showDateMiniSearch() {
          var vm = this;
          $('#sandbox-container-mini .input-group.date').datepicker({
              format: 'dd-mm-yyyy',                        
              startDate: '0d',
              todayHighlight: true,
              autoclose: true
          }).on("changeDate", () => {vm.startDate = $('#sandbox-container-mini #startDateMini').val()});

        },
        testDate() {
          console.log(this.startDate); // the startDate value is ''
        },
        
        /*** seat display methods ******/
        createIndexList() {
            this.indexList=[];
            var index = this.index;
            //var numberOfRow = this.numberOfRow;            
            var seatListLength =  this.seatList.length;
            // if (seatListLength < 5 ) {
            //     this.indexList.push(index);
            //     return;
            // } 
            
            var numberOfRow = (seatListLength-1) /4; //2
            this.numberOfRow = numberOfRow;
            var r;
            for ( r=1; r<numberOfRow; r++ ) { 
                this.indexList.push(index);
                index = index+4; 
                //console.log('index', index);
            }
        },

        emptySpace(index, seatNo) {           
            
            if ( this.isFiveCol(seatNo) ) {
              return false; // no need empty space between columns
            }
            /*var seatNumber = parseInt(seatNo.match(/\d+/),10);            
            return ( (seatNumber % 3) == 0 ) ? true : false;*/
            return this.isEmptySpaceAvailable(index);

        },
        
        isFiveCol(seatNo) {          
          /*var seatListLength =  this.seatList.length;
          var numberOfRow = (seatListLength-1) /4; //2*/
          var lastRowChar = this.seatChar[numberOfRow-1] || ''; //B
          var numberOfRow = parseInt(this.numberOfRow);
          //var lastRowChar = this.seatChar[numberOfRow-1]; //B
          lastRowChar = lastRowChar.trim();
          
          var seatChar = seatNo.substr(0, 1); //extract char from seat no
          return ( lastRowChar == seatChar ) ? true : false ;
        },

        isEmptySpaceAvailable(index) {
            var val = this.indexList.find( function(indx) {                            
                return indx == index;
            });
            return (index == val) ? true : false;
        },

        toggle(seat) {
          // console.log('clicked');
          // console.log(seat.no);
          seat.checked = !seat.checked;                         
              if (seat.checked) {
                //console.log('seat checked=', seat.checked);
                //this.addSeat(seat.seat_no); // to selectedSeat array               
                this.addSeat(seat); // to selectedSeat array               
                this.addFareToTotal(seat);
                return ;
              }
              //console.log('seat NOT checked=', seat.checked);               
              this.removeSeat(seat.seat_no, seat); // to selectedSeat array 
              // this.removeFareFromTotal(seat);                           
        },
        addSeat(seat) {
          //console.log('+', seatNo);
          this.selectedSeat.push({
          seat_no: seat.seat_no,
          fare: seat.fare,
          special:seat.special,
          status: 'booked' //'selected'
          });
          this.sortSelectedSeat();
        },
        sortSelectedSeat(){
          this.selectedSeat.sort(function(a, b) {
            var nameA = a.seat_no.toUpperCase(); // ignore upper and lowercase
            var nameB = b.seat_no.toUpperCase(); // ignore upper and lowercase
            if (nameA < nameB) {
              return -1;
            }
            if (nameA > nameB) {
              return 1;
            }
            // names must be equal
            return 0;
          });
        },
        removeSeat(seatNo, seat) {                    
          this.assignSeatCheckedStatusFalseInSeatList(seatNo); // checked = false 
          this.removeSeatFromSelectedSeat(seatNo);
          this.removeFareFromTotal(seat);
        },
        assignSeatCheckedStatusFalseInSeatList(seatNo) {         
          let index = this.seatList.findIndex(seat =>              
            seat.seat_no == seatNo &&
            seat.status == 'available'
          );
          //let index = this.seatList.indexOf(seat);
          this.seatList[index].checked = false;               
        },
        removeSeatFromSelectedSeat(seatNo) {
          let index = this.selectedSeat.findIndex(seat =>            
             seat.seat_no == seatNo
          );
          //let index = this.selectedSeat.indexOf(seat);      
          this.selectedSeat.splice(index, 1);     
        },
        isDisabledSeatSelection(seatStatus) {
          //console.log('disableSelection=', seatStatus);
          return ( seatStatus == 'booked' || 
              seatStatus == 'buying' ||
              seatStatus == 'confirmed' || 
              seatStatus == 'n/a' ) 
              ? 
              true : false;
        }        
        // end display methods
        // totalFareForSelectedSeats(seat) {
        //   console.log('Seatfare=', seat.fare);
        //   let fare;
        //   fare = parseInt(seat.fare, 10) + this.totalFare;
        //   this.totalFare = fare;
        //   console.log('fare=', fare);
        //  return fare;
        // }
      }
      
    }              
</script>

<style lang="scss" scoped>
  
  // /*[v-cloak] { display:none; }*/
  .search-form {
    background: linear-gradient(0deg, #8BC34A, #FFF59D);
    padding: 1.5rem 0;
    border-radius: 0.27rem;
  }
  
 .seat-error {
    text-align: center;
  }

#app .seat-layout {
      //padding-left: 50px;
      // .row {
      //   margin-left: 0px;
      // }
      display: flex;
      flex-wrap: wrap;
      justify-content:  center;
      button {               
        height: 34px; //50px;
        margin: 10px 10px 0 0;
        font-size: 0.8rem;
        &.col-xs-2 {
          width: 15.666667%;
        }
        &.col-xs-offset-2 {
          margin-left: 17.666667%;
        }
        &.is-white {
          background-color: #fff; 
          border-width: 0;
          color: #0a0a0a;
        }
      }   
  }
  
  div.row.driver-seat {      
    height: 4rem;
    position: relative;
  }
  div.row.driver-seat > button {
    position: absolute;
    top: 0;
    right: 10%;
  }  

  /* seat display */
  .is-active {
    background-color: green;
    color: #fff;
  }     
  .booked {
    background-color: yellow; 
    color: black;
  }
  .buying {
    background-color: orange; 
    color: #fff;
  }
  .confirmed {
    background-color: red;
    color: #fff;
  }
  .empty {
    background-color: white;
    border-width: 0;
      /*color: #0a0a0a;*/
    color:white;        
  }
  
  .search-form {
    .input-group-text i {
      color: #a0cc59;
    }
  } 
  .warning-l {
    background-color: #FFE006;
    border-radius: 0.25rem 0 0 0.25rem;
    color: #FAB005;
    text-align: center;
  }
  .warning-r {
    background-color: #fff9db;
    border-radius: 0 0.25rem 0.25rem 0;
    //color: #FAB005;
    //text-align: center;
  }
  .info-l {
    color: #0c5460;
    background-color: #bee5eb; //#d1ecf1;
    border-radius: 0.25rem 0 0 0.25rem;
    text-align: center;
  }
  .info-r {
    background-color: #d1ecf1;
    border-radius: 0 0.25rem 0.25rem 0;
    //color: #FAB005;
    //text-align: center;
  }    
/* end seat display */

.modal-width {
  max-width: 370px;
}

.info-scroll {
  max-height: 25rem;
  overflow-y: auto;
}

// // progressbar
// .shape-outer {
//     display: flex;
//     flex-shrink: 0;
//     height: calc(70px + 4vw);
//     width: calc(70px + 4vw);
//     margin: 0 auto;
//     // background-image: linear-gradient(to bottom right, #ff3cac, #562b7c, #2b86c5);
//     background-image: linear-gradient(to bottom right, var(--warning), hsl(162deg 87% 74%), hsl(205deg 64% 47%));    
//   }

//   .rhombus {
//     -webkit-clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
//         clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
//   }



//   .progressbar {
//     // ul li { 
//     //   display: inline-block;
//     //   width: 12.5rem;
//     //   position: relative;

//       i.progress-icon {
//         // color: green;
//         margin: auto;
//       }
      
//       i.action {
//         background-color: #ccc;
//         border-radius: 50%;
//         color: #fff;
//         font-size: small;
//         padding: 0.375rem;
//         height: 1.5rem;
//         width: 1.5rem;
//       }

//       i.action::after {
//         background-color: #ccc;
//         content: '';
//         height: 0.3125rem;
//         width: 100%; //12.5rem;
//         display: block;
//         position: absolute;
//         left: 0;
//         top: calc(58% + 1vh); //110px; //4.6875rem;
//         z-index: -1;
//       }

//       i.doing {
//         background-color: #148e14;
//       }   
//       i.doing::after {
//         background-color: #148e14;
//       }

//       i.done {
//         background-color: hsla(45, 100%, 51%, 1);
//       }   
//       i.done::after {
//         background-color: hsla(45, 100%, 51%, 1);
//       }

//       .first::after {
//         left: 50% !important; //6.35rem
//         width: 100% !important;
//       }
//       .last::after {
//         width: 50% !important;
//       }

//     // }
//   }
// //

  // Small devices (landscape phones, 576px and up)
  @media (min-width: 576px) { 
    .modal-width {
      max-width: 400px;
    }    
    
    // i.action::after {        
    //   top: calc(61% + 1vh) !important; //110px; //4.6875rem;
    // }

  }

  // Medium devices (tablets, 768px and up)
  @media (min-width: 768px) {
    .modal-width {
      max-width: 500px;
    }    
    // i.action::after {        
    //   top: calc(62% + 1vh) !important; //110px; //4.6875rem;
    // }

  } 
  
  // Large devices (desktops, 992px and up)
  @media (min-width: 992px) {
    .modal-width {
      max-width: 660px;
    }
    // i.action::after {        
    //   top: calc(63% + 1vh) !important; //110px; //4.6875rem;
    // }

  }

  // Extra large devices (large desktops, 1200px and up)
  @media (min-width: 1200px) {
    .modal-width {
      max-width: 760px;
    }
    // i.action::after {        
    //   top: calc(64% + 1vh) !important; //110px; //4.6875rem;
    // }

  }
  // .shape-outer {
  //   display: flex;
  //   flex-shrink: 0;
  //   height: calc(70px + 4vw);
  //   width: calc(70px + 4vw);
  //   margin: 0 auto;
  //   // background-image: linear-gradient(to bottom right, #ff3cac, #562b7c, #2b86c5);
  //   background-image: linear-gradient(to bottom right, var(--warning), hsl(162deg 87% 74%), hsl(205deg 64% 47%));    
  // }

  // .rhombus {
  //   -webkit-clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
  //       clip-path: polygon(50% 0%, 100% 50%, 50% 100%, 0% 50%);
  // }



  // .progressbar {
  //   // ul li { 
  //   //   display: inline-block;
  //   //   width: 12.5rem;
  //   //   position: relative;

  //     i.progress-icon {
  //       // color: green;
  //       margin: auto;
  //     }
      
  //     i.action {
  //       background-color: #ccc;
  //       border-radius: 50%;
  //       color: #fff;
  //       font-size: small;
  //       padding: 0.375rem;
  //       height: 1.5rem;
  //       width: 1.5rem;
  //     }

  //     i.action::after {
  //       background-color: #ccc;
  //       content: '';
  //       height: 0.3125rem;
  //       width: 100%; //12.5rem;
  //       display: block;
  //       position: absolute;
  //       left: 0;
  //       top: calc(58% + 1vh); //110px; //4.6875rem;
  //       z-index: -1;
  //     }

  //     i.doing {
  //       background-color: #148e14;
  //     }   
  //     i.doing::after {
  //       background-color: #148e14;
  //     }

  //     i.done {
  //       background-color: hsla(45, 100%, 51%, 1);
  //     }   
  //     i.done::after {
  //       background-color: hsla(45, 100%, 51%, 1);
  //     }

  //     .first::after {
  //       left: 50% !important; //6.35rem
  //       width: 100% !important;
  //     }
  //     .last::after {
  //       width: 50% !important;
  //     }

  //   // }
  // }
  
  .font125 {
    font-size: 1.125rem;
  }
  .info-table {
    background-color: hsla(60, 56%, 91%, 1);
    // max-height: 350px;
    // :deep(.info-table-top) {
    //   border-top-left-radius: 4px;
    //   border-top-right-radius: 4px;
    //   height: 1rem;
    // }
    :deep(.info-table-left) {
      background-color: hsla(60, 68%, 88%, 1); 
      // border-right: 1px solid hsla(210, 23%, 89%, 1) !important;
      border-right: 1px solid hsla(66, 45%, 80%, 1) !important;
    }
    :deep(.filter-title) {
    // color: var(--dark);
    font-size: 1rem;
    font-weight: 500;
    letter-spacing: 2px;
    background-color: hsl(74, 58%, 64%);
    padding: 5px;
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    text-align: center;
    } 
    :deep(.filter-element) {
      background-color: hsl(74, 46%, 81%);
      font-size: .9rem;
      padding: .5rem;
      border-bottom-left-radius: 4px;
      border-bottom-right-radius: 4px;
    }    
    :deep(.table thead th) {
      border-bottom: none;    
    }
  }
  :deep(.info-table-top) {
    border-top-left-radius: 4px;
    border-top-right-radius: 4px;
    height: 1rem;
  }
  :deep(.bg-bus) {
    position: relative;
    height: 15vh;
    width: 17vh;
  }
  :deep(.img-bus) {
    position: relative;
    height: 15vh;
    width: 17vh;
  }
  
/**** scroll bar ******/
// ::-webkit-scrollbar{
//     width: 10px;
//     height: 10px;
//     padding-top: 40px;
// }

// ::-webkit-scrollbar-track{
//     -webkit-box-shadow: inset 0 0 1px rgba(0,0,0,0.3);
//     border: 1px solid black;
//     background: rgb(41,41,41);
//     border-radius: 10px;

// }
// ::-webkit-scrollbar-thumb{
//     border-radius:10px;
//     height: 30px;
//     width: 8px;
//     border: 1px solid black;
//     background: rgb(111,111,111);
//     -webkit-box-shadow: 0 1px 1px rgb(0,0,0);
//     background: -webkit-linear-gradient(rgb(200,200,200), rgb(150,150,150));
// }

// ::-webkit-scrollbar-track-piece {
//     height: 30px;
//     width: 30px;
// }

/* Works on Firefox */
* {
  scrollbar-width: thin;
  scrollbar-color: blue orange;
}

// /* Works on Chrome, Edge, and Safari */
// *::-webkit-scrollbar {
//   width: 10px;
// }

// *::-webkit-scrollbar-track {
//   background: orange;
// }

// *::-webkit-scrollbar-thumb {
//   background-color: blue;
//   border-radius: 20px;
//   border: 3px solid orange;
// }
::-webkit-scrollbar-track
{
  -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
  background-color: #F5F5F5;
  border-radius: 10px;
}

::-webkit-scrollbar
{
  width: 10px;
  background-color: #F5F5F5;
}

::-webkit-scrollbar-thumb
{
  border-radius: 10px;
  background-image: -webkit-gradient(linear,
                     left bottom,
                     left top,
                     color-stop(0.44, rgb(122,153,217)),
                     color-stop(0.72, rgb(73,125,189)),
                     color-stop(0.86, rgb(28,58,148)));
}
</style>