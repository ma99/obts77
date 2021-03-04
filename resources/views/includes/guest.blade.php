<div class="card">
    <div class="card-header">For Guest</div>
    <div class="card-body">
		<form method="POST" action="/seatbooking" v-on:submit.prevent="vm.seatBookingByGuest()" @keydown="vm.form.errors.clear($event.target.name)">
			<div class="form-group">
			<label for="name" class="control-label">Name</label>
			<div class="input-group">
			    <span class="input-group-addon"><i class="fa fa-user fa-fw"></i></span>
			    <input id="name" type="text" class="form-control" name="name" v-model="vm.form.name">
			</div>
			<span class="help text-danger" v-if="vm.form.errors.has('name')" v-text="vm.form.errors.get('name')"></span>
			</div>

			<div class="form-group">
			<label for="email" class="control-label">E-Mail</label>
			<div class="input-group">
			    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
			    <input id="email" type="email" class="form-control" name="email" v-model="vm.form.email">
			</div>
			<span class="help text-danger" v-if="vm.form.errors.has('email')" v-text="vm.form.errors.get('email')"></span>
			</div>

			<div class="form-group">
			<label for="phone" class="control-label">Mobile No.</label>
			<div class="input-group">
			    <span class="input-group-addon"><i class="fa fa-mobile fa-fw"></i></span>
			    <input id="phone" type="text" class="form-control" name="phone" v-model="vm.form.phone">
			</div>
			<span class="help text-danger" v-if="vm.form.errors.has('phone')" v-text="vm.form.errors.get('phone')"></span>
			</div>
			{{-- options --}}
			{{-- <div class="radio">
			  <label class="radio-inline">
			    <input type="radio" name="optionsRadios" id="optionsRadios1" value="seatbooking" v-model="url">
			    Book 
			  </label>	  
			</div>
			<div class="radio">
			  <label class="radio-inline">
			    <input type="radio" name="optionsRadios" id="optionsRadios2" value="seatbuying" v-model="url">
			    Buy
			  </label>
			</div>
			<span> Picked @{{ url }}</span> --}}
			{{-- @include('includes.stops') --}}
			@include('includes.options')

			<button v-show="vm.isSeatSelected" class="btn btn-primary" :disabled="vm.form.errors.any()">Continue</button>
		</form>
	</div>
</div>