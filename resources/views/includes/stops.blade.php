{{-- <div class="col-md-3"> --}}
  <div class="form-group">
    <label for="pickupPoint"> Pickup </label>
    <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
    <select v-model="vm.stops.selectedPickupPoint" class="form-control" id="pickupPoint">
      <!-- <option disabled value="">Please select one</option> -->
      <option v-if="!vm.error.pickupPoint" disabled value="">Please select one</option>
      <option v-if="vm.error.pickupPoint" disabled value="">@{{vm.error.pickupPoint }}</option>    
      <option v-for="pickup in vm.pickupStops">
        @{{ pickup.name }}
      </option>                           
    </select>
  </div>

  <div class="form-group">
    <label for="droppingPoint"> Dropping </label>
    <!-- <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email" -->
    <select v-model="vm.stops.selectedDroppingPoint" class="form-control" id="droppingPoint">
      <!-- <option disabled value="">Please select one</option> -->
      <option v-if="!vm.error.droppingPoint" disabled value="">Please select one</option>
      <option v-if="vm.error.droppingPoint" disabled value="">@{{ vm.error.droppingPoint }}</option>
      <option v-for="dropping in vm.droppingStops">
        @{{ dropping.name }}
      </option>                           
    </select>
  </div>
{{-- </div>   --}}