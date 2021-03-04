<div class="card border-secondary border-top-0">
    <div class="card-header bg-secondary border-secondary text-white">Admin/ Operator</div>
    <div class="card-body">
		<form method="POST" action="/seatbooking" v-on:submit.prevent="vm.seatBookingByStaff()" @keydown="vm.form.errors.clear($event.target.name)">
			<div v-show="vm.form.phone!=''" class="text-center">
			    {{-- <span v-show="userExist" class="text-success"> User already exist</span> 
			    <span v-show="!userNotExist" class="text-danger"> User doesn't exist </span>  --}}
			  <div v-show="vm.userExist" class="alert alert-success" role="alert">
			  {{-- <i class="fas fa-user-check mr-1"></i> --}}
				  <span class="fa-stack fa-2x mr-2">
					  <i class="fas fa-circle fa-stack-2x"></i>
					  <i class="fas fa-user-check fa-stack-1x fa-inverse"></i>
					</span>			  
				  User already exist!
				</div>
				<div v-show="!vm.userExist" class="alert alert-warning" role="alert">
			  {{-- <i class="fas fa-user-alt-slash mr-1"></i> --}}
				  <span class="fa-stack fa-2x mr-2">
					  <i class="fas fa-user fa-stack-1x"></i>
					  <i class="fas fa-ban fa-stack-2x" style="color:Tomato"></i>
					</span>
				  User doesn't exist!
				</div>
			</div>

			<div class="m-1">			  
			  {{-- <input type="hidden" name="userExist" id="userExist1" v-model="userExist"  disabled> --}}
			  <input type="hidden" name="userId" id="userId1" v-model="vm.userInfo.id"  disabled>
			</div>
			<div class="form-group">
			<label for="phone" class="control-label">Mobile No.</label>
			<div class="input-group">
		    <span class="input-group-prepend">
        	<div class="input-group-text bg-white">
		    		<i class="fas fa-mobile-alt"></i>
		    	</div>
		    </span>
		    <input id="phone" type="text" class="form-control border-left-0" name="phone" v-model.lazy="vm.form.phone">
			</div>
			<span class="help text-danger" v-if="vm.form.errors.has('phone')" v-text="vm.form.errors.get('phone')"></span>
			<span class="text-mute text-danger" v-if="vm.userInfo.hasOwnProperty('error')" v-text="vm.userInfo.error"></span>
			</div>

			<div class="form-group">
			<label for="name" class="control-label">Name</label>
			<div class="input-group">
		    <span class="input-group-prepend">
        	<div class="input-group-text bg-white">
		    		<i class="fas fa-user"></i>
		    	</div>
		    </span>
		    <input id="name" type="text" class="form-control border-left-0" name="name" v-model="vm.form.name">
			</div>
			<span class="help text-danger" v-if="vm.form.errors.has('name')" v-text="vm.form.errors.get('name')"></span>
			</div>						

			<div class="form-group">
			<label for="email" class="control-label">E-Mail</label>
			<div class="input-group">
		    <span class="input-group-prepend">
        	<div class="input-group-text bg-white">
		    		<i class="fas fa-envelope"></i>
		    	</div>
		    </span>
		    <input id="email" type="email" class="form-control border-left-0" name="email" v-model="vm.form.email">
			</div>
			<span class="help text-danger" v-if="vm.form.errors.has('email')" v-text="vm.form.errors.get('email')"></span>
			</div>
			
			{{-- @include('includes.options') --}}

			<button v-show="vm.isValid" class="btn btn-primary btn-block" :disabled="vm.form.errors.any()">Continue</button>
		</form>
	</div>
</div>