export const SET_BUS_TYPES = (state, types) => {
    state.types = types;
}

export const SORT_SEATPLANS_BY_ID = (state) => {
    const seatplans = state.availableSeatPlanList;
    
    seatplans.sort((a, b) => {
        return a.id - b.id;
    });    
        
    state.availableSeatPlanList = seatplans;
}

export const ADD_TYPE = (state, type) => {	
	state.types.push(type);
}

export const DELETE_TYPE = (state, index) => {
    state.types.splice(index, 1);
}