@csrf
<input id="booking_id" name="booking_id" type="hidden" :value="vm.bookedSeatInfo.booking_ref">
<div class="row">
	<div class="col-7">
		Subtotal (@{{vm.bookedSeatInfo.total_seats}})
	</div>
	<div class="col-5">
		<span class="float-right">
			৳ @{{vm.bookedSeatInfo.amount}}
		</span> 
	</div>
	<div class="col-12">	
		<div class="form-row">
	    <div class="form-group mb-1 col-8">	      
	      <input type="text" class="form-control px-1" id="discountCode" placeholder="Enter Discount Code" v-model="vm.discount.code" />
	      {{-- <discount v-model="vm.discount.code" /> --}}
	    </div>
	    
	    <div class="form-group mb-1 col-4">
	      <button type="button" class="btn btn-info px-2 float-right"
	      @click.prevent="vm.applyDiscount()"
	      :disabled="vm.discount.code ==''"
	      >
		  	Apply
	  	</button>
	    </div>
		</div>
	</div>

	<div class="col-7">
		Total
	</div>
	<div class="col-5">
		<span class="float-right">
			৳ @{{vm.totalAmount}}
		</span> 
	</div>
	
</div>

<div class="form-group my-3">
{{-- <button class="btn btn-success btn-block" :disabled="!bookedSeatInfo.booking_ref">Pay Now</button> --}}
<button class="btn btn-success btn-block" :disabled="vm.disablePayButton">Pay Now</button>
</div>