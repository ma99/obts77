<div class="form-row justify-content-center">
  <div class="form-group col-8">
  {{-- <autocomplete 
    input-label="From"
    :suggestions="vm.availableCityList" 
    v-model:city="vm.selectedCityFrom" 
  >
  </autocomplete>   --}}
    <autocomplete 
      :suggestions="vm.availableCityList" 
      :city="vm.selectedCityFrom" 
      {{-- @update:city="vm.selectedCityFrom = $event"     --}}
      @update:city="vm.handleCityFromInputEvent"  {{-- 'update:city' is just an evnt name.  --}}
      input-label="From"
    >
    </autocomplete>  
  </div>
  <div class="form-group col-8">
    {{-- <autocomplete :suggestions="vm.availableCityList" v-model="vm.selectedTo" input-label="To">
    </autocomplete> --}}
    <autocomplete 
      :suggestions="vm.availableCityList" 
      :city="vm.selectedTo"       
      @update:city="vm.handleCityToInputEvent"  
      input-label="To"
    >
    </autocomplete>
  </div>
  <div class="form-group col-8">  
      <label for="startDate">Date of Journey</label> 
      <div id="sandbox-container">
        <div class="input-group date">
          <input name="date" id="startDate" class="form-control border-right-0" type="text" v-model="vm.startDate" placeholder="Select Date">
          <span class="input-group-append">
              <div class="input-group-text bg-white"><i class="fas fa-calendar-alt" style="color: hsl(86, 51%, 54%);"></i></div>
          </span>
        </div>
      </div>
  </div>
  <div class="col-8">
    <button type="button" @click.prevent="vm.searchBus" class="btn btn-warning btn-search form-control" :disabled="vm.isDisabled">Search &nbsp;
      <i class="fa fa-search"></i>
    </button>   
  </div>                          
</div> 