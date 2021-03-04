<div class="form-row justify-content-center">
  <div class="form-group col-sm-3 col-md-3">  
    <autocomplete 
      :suggestions="vm.availableCityList" 
      :city="vm.selectedCityFrom"       
      @update:city="vm.handleCityFromInputEvent" 
      input-label="From"
    >
    </autocomplete>  
  </div>
  <div class="form-group col-sm-3 col-md-3">    
    <autocomplete 
      :suggestions="vm.availableCityList" 
      :city="vm.selectedTo"       
      @update:city="vm.handleCityToInputEvent"  
      input-label="To"
    >
    </autocomplete>
  </div>
  <div class="form-group col-sm-4 col-md-4">  
      <label for="startDateMini">Date of Journey</label> 
      <div id="sandbox-container-mini">
        <div class="input-group date">
          <input name="date" id="startDateMini" class="form-control border-right-0" type="text" v-model="vm.startDate" placeholder="Select Date">
          <span class="input-group-append">
              <div class="input-group-text bg-white"><i class="fas fa-calendar-alt" style="color: hsl(86, 51%, 54%);"></i></div>
          </span>
        </div>
      </div>
  </div>
  <div class="col-sm-10 col-md-2 align-self-center">
    <button type="button" v-on:click.prevent="vm.searchBus" class="btn btn-warning btn-search form-control px-md-1 mb-sm-2 mb-md-0 mt-md-3" :disabled="vm.isDisabled">Search
      <i class="fa fa-search ml-1"></i>
    </button>
  </div>                          
</div> 