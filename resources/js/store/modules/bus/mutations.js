export const ADD_BUS = (state, data) => {          
    state.availableBusList.push({
        bus: data.bus,
        total_seats: data.seats 
    })
}

export const DELETE_BUS = (state, index) => {
    state.availableBusList.splice(index, 1);
}

export const UPDATE_BUS = (state, bus) => {

    let index = bus.index;
    state.availableBusList[index].bus = bus.data;
}

// export const SET_BUS_TYPES = (state, types) => {
//     state.types = types;
// }

export const SET_BUSES = (state, buses) => {
    state.availableBusList = buses;
}        

export const SORT_BUSES_BY_ID = (state, buses) => {
    state.availableBusList = buses;
}

export const SORT_BUSES_BY_REG_NUMBER = (state, buses) => {
    
    state.availableBusList = buses;
}

// export const SET_SEATPLANS = (state, seatplans) => {
//     state.availableSeatPlanList = seatplans;
// },

// export const SORT_SEATPLANS_BY_ID = (state) => {
//     const seatplans = state.availableSeatPlanList;
    
//     seatplans.sort((a, b) => {
//         return a.id - b.id;
//     });
    
//     state.availableSeatPlanList = seatplans;
// },

export const SET_SCHEDULES_BY_BUS = (state, schedules) => {
    state.schedulesByBus = schedules;
}

export const ADD_SCHEDULES_BY_BUS = (state, data) => {          
    state.schedulesByBus = data;
}

export const DELETE_SCHEDULE_BY_BUS = (state, index) => {
    state.schedulesByBus.splice(index, 1);
}

export const EMPTY_SCHEDULES_BY_BUS = (state, schedules) => {
    state.schedulesByBus = [];
}

export const SORT_BUS_SCHEDULES_BY_CITY = (state, schedules) => {
    state.schedulesByBus = schedules;
}

export const SORT_BUS_SCHEDULES_BY_TIME = (state, schedules) => {
    state.schedulesByBus = schedules;
}

/*** STAFF */
export const SET_STAFF_BY_BUS = (state, staff) => {    
    state.staffByBus = staff;
}

export const ADD_STAFF_BY_BUS = (state, staff) => {    
    console.log(staff);
    if (staff.driver !== false) {
        state.staffByBus.drivers.push(staff.driver);
    }
    if (staff.helper !== false) {
        state.staffByBus.helpers.push(staff.helper);
    }
    if (staff.supervisor !== false) {
        state.staffByBus.supervisors.push(staff.supervisor);
    }
}

export const REMOVE_STAFF_BY_BUS = (state, staff) => {
    console.log(staff);
    if (staff.type == 'driver') {
        const index = state.staffByBus.drivers.findIndex(element => element.id === staff.id);
        state.staffByBus.drivers.splice(index, 1);
    }

    if (staff.type == 'helper') {
        const index = state.staffByBus.helpers.findIndex(element => element.id === staff.id);
        state.staffByBus.helpers.splice(index, 1);
    }

    if (staff.type == 'supervisor') {
        const index = state.staffByBus.supervisors.findIndex(element => element.id === staff.id);
        state.staffByBus.supervisors.splice(index, 1);
    }
}

export const EMPTY_STAFF_BY_BUS = (state, schedules) => {   
    state.staffByBus = [];
}