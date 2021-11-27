export const SET_DRIVERS = (state, drivers) => {
    state.availableDriverList = drivers;
}

export const SORT_DRIVERS_BY_ID = (state) => {
    const drivers = state.availableDriverList;
    
    drivers.sort((a, b) => {
        return a.id - b.id;
    });    
        
    state.availableDriverList = drivers;
}

export const ADD_SEATPLAN = (state, seatplan) => {          
    state.availableSeatPlanList.push(seatplan);
}

export const DELETE_SEATPLAN = (state, index) => {
    state.availableSeatPlanList.splice(index, 1);
}