{{-- <div v-show="isSeatBooked" class="row justify-content-center"> --}}
<div v-show="vm.isSeatBooked" class="row justify-content-center mt-4">
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
              <div class="col-7 p-2">left OD
                <div class="row mx-0">

                <div class="col-12 mb-3 border-bottom">
                  <h4 class="card-title text-success text-center">Booking Details</h4>
                </div>          

                <div class="col-12 mb-3">
                  Booking Ref: <strong>@{{ vm.bookedSeatInfo.booking_ref }}</strong>
                </div>
              
                @auth
                @if ( auth()->user()->hasAnyRole(['admin', 'super_admin', 'operator']) )
                  {{-- @include('includes.guest') --}}
                  <div class="col-6 mb-2">
                    Name: <strong>@{{ vm.userInfo.name }}</strong>
                  </div>
                  <div class="col-6 mb-2">
                    Phone: <strong>@{{ vm.userInfo.phone }}</strong>
                  </div>
                @else 
                  <div class="col-6 mb-2">
                    Name: <strong>{{ auth()->user()->name }}</strong>
                  </div>
                  <div class="col-6 mb-2">
                    Phone: <strong>{{ auth()->user()->phone }}</strong>
                  </div>
                @endif
                @endauth

                <div class="col-7 mb-2">
                  Seat No(s): <strong>@{{ vm.bookedSeatInfo.seats}}</strong>
                </div>
                <div class="col-7 mb-2">
                  Amount: <strong>@{{ vm.bookedSeatInfo.amount }} </strong> Tk
                </div>
                <div class="col-6 mb-2">
                  Date: <strong>@{{ vm.bookedSeatInfo.date }}</strong>
                </div>
                <div class="col-6 mb-2">
                  Time: <strong>@{{ vm.selectedBus.departure_time }}</strong>
                </div>
                <div class="col-6 mb-2">
                  Pickup Point: @{{ vm.bookedSeatInfo.pickup_point }} 
                </div>
                <div class="col-6 mb-2">
                  Dropping Point: @{{ vm.bookedSeatInfo.dropping_point }} 
                </div>
                <div class="col-6 mb-2">
                  Coach: @{{ vm.selectedBus.bus_number_plate }} 
                </div>         
                
                </div>
              </div>

              <div class="col-5 p-3"
                style="hsl(134deg 76% 88%) !important;" 
              >
                <h4>
                  Order Summary
                </h4>
                <div class="mt-2">
                @auth
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
                @endauth 
                </div>
              </div>
            </div>

          </div>            
        </div>
      </div>
    </div>
  </div>
</div>