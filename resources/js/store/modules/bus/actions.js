import Bus from '../../../api/bus';


    //axios.get('/api/types').then(response => {
    // export const getBusTypes = ({ commit, dispatch }) => {
    //     return Bus.types().then(response => {
    //         commit('SET_BUS_TYPES', response.data);
    //     })
    //     .catch(error => {
    //         console.log(error.response.data);
    //         dispatch('setErrors', 
    //              error.response.data.errors,
    //             { root: true }
    //         );
    //     });
    // }

    export const getBuses = ({ commit, dispatch }, {token}) => {            
        return Bus.buses(token).then(response => {
            commit('SET_BUSES', response.data);
            dispatch('sortByBusId');
        })
        .catch(error => {
            console.log(error.response.data);
            dispatch('setErrors', 
                 error.response.data.errors,
                { root: true }
            );
        });
    }

    export const sortByBusId = ({ commit, state }) => {
        const buses = state.availableBusList;

        buses.sort((a, b) => {
            return a.bus.id - b.bus.id
        });

        commit('SORT_BUSES_BY_ID', buses);
    }

    export const sortByRegNumber = ({ commit, state }) => {
        const buses = state.availableBusList;

        buses.sort((a, b) => {
            let nameA = a.bus.reg_no; 
            let nameB = b.bus.reg_no; 
            if (nameA < nameB) {
                return -1;
            }
            if (nameA > nameB) {
                return 1;
            }            
            return 0;
        });

        commit('SORT_BUSES_BY_REG_NUMBER', buses);
    }

    export const addBus = ({ commit, dispatch }, { bus, numberOfSeat }) => {

        const data = {
            seat_plan_id: bus.seatPlanId,
            reg_no: bus.regNumber,
            number_plate: bus.numberPlate,
            type_id: bus.typeId,
            route_id: bus.routeId,
            description: bus.description
        }

        Bus.store(data).then(response => {
            const data = {
                bus: response.data,
                seats: numberOfSeat
            }
            commit('ADD_BUS', data);
            dispatch('setSuccess', 
                {status: true},
                { root: true }
            );
        })
        .catch(error => {
            // console.log(error.response.data);
            dispatch('setErrors', 
                 error.response.data.errors,
                { root: true }
            );
        });
    }

    export const updateBus = ({ commit, dispatch }, { bus, busToEdit }) => {
        
        const data = {
            seat_plan_id: bus.seatPlanId,
            reg_no: bus.regNumber,
            number_plate: bus.numberPlate,
            type_id: bus.typeId,
            route_id:bus.routeId,
            description: bus.description
        }
        
        Bus.update(data, busToEdit.id).then(response => {            
            
            data.id = busToEdit.id;

            const bus = {
                data: data,
                index: busToEdit.index,
            }
            
            commit('UPDATE_BUS', bus);
            dispatch('setSuccess', 
                {status: true},
                { root: true }
            );
        })
        .catch(error => {
            // console.log(error.response.data);
            dispatch('setErrors', 
                 error.response.data.errors,
                { root: true }
            );
        });
    }

    export const deleteBus = ({ commit, state }, id) => {

        return Bus.delete(id).then(response => {
        
            let index = state.availableBusList.findIndex(bus => bus.bus.id === id);
                        
            commit('DELETE_BUS', index);
        })
        .catch(error => {
            console.log(error.response.data);
        });
    }

export const getSchedulesByBus = ({ commit, dispatch }, id) => {
    return Bus.schedules(id).then(response => {
        // try {
        //     commit('SET_SCHEDULES_BY_BUS', response.data);
        //     dispatch('sortBusSchedulesByTime');
        // }       
        // catch(e) {
        //     console.log(e);
        // } 
        commit('SET_SCHEDULES_BY_BUS', response.data);
        dispatch('sortBusSchedulesByTime');
    })
    .catch(error => {
            // console.log(error.response.data);
            // let errors = {"schedules":[error.response.data.message]};
            // commit('EMPTY_SCHEDULES_BY_BUS');
            dispatch('setErrors', 
             error.response.data.errors,
                { root: true }
            );
    });
}

export const addSchedulesByBus = ({ commit, dispatch }, {data, id}) => {
    Bus.attach(data, id).then(response => {
        commit('ADD_SCHEDULES_BY_BUS', response.data);
        dispatch('sortBusSchedulesByTime');
        dispatch('setSuccess', 
             {status: true},
            { root: true }
        );
    })
    .catch(error => {
        //console.log(error.response.data.message);
        dispatch('setErrors', 
             error.response.data.errors,
            { root: true }
        );
    });
}

export const removeScheduleByBus = ({ commit, dispatch }, {schedule, bus}) => {

    Bus.detach(schedule, bus).then(response => {
      
        commit('SET_SCHEDULES_BY_BUS', response.data);
        dispatch('sortBusSchedulesByTime');
    })
    .catch(error => {
        console.log(error.response.data);
    });
}

export const emptySchedulesByBus = ({ commit }) => { 
    commit('EMPTY_SCHEDULES_BY_BUS');
}

export const sortBusSchedulesByCity = ({ commit, state, rootGetters }) => { 

    const schedules = state.schedulesByBus;
    //let tempSchedules = [] ;
    console.log('m=',schedules)

    schedules.forEach(schedule => {
        let city = rootGetters['city/getCityById'](schedule.pivot.departure_city_id);
        
        schedule.departure_city = city.name; 
    })
    //console.log(schedules);
    // schedules.sort((a, b) => {
    //     return 
    //     a.pivot.departure_city_id -      
    //     b.pivot.departure_city_id       
    // });

    schedules.sort((a, b) => {
        let nameA = a.departure_city.toUpperCase(); 
        let nameB = b.departure_city.toUpperCase(); 
        if (nameA < nameB) {
        return -1;
        }
        if (nameA > nameB) {
        return 1;
        }
        // names must be equal
        return 0;
    })

   commit('SORT_BUS_SCHEDULES_BY_CITY', schedules);
}

export const sortBusSchedulesByTime = ({ commit, getters, state, rootGetters }) => { 

    const schedules = state.schedulesByBus;

    schedules.sort((a, b) => {      
        return (
            rootGetters.convertTime12To24(a.departure_time) - rootGetters.convertTime12To24(b.departure_time)
            );
    });

   commit('SORT_BUS_SCHEDULES_BY_TIME', schedules);
}

/** STAFF */
// export const getDriversByBus = ({ commit, dispatch }, id) => {
//     return Bus.drivers(id).then(response => {        
//         commit('SET_DRIVERS_BY_BUS', response.data);
//         // dispatch('sortBusSchedulesByTime');
//     })
//     .catch(error => {
//             // console.log(error.response.data);
//             // let errors = {"schedules":[error.response.data.message]};
//             // commit('EMPTY_SCHEDULES_BY_BUS');
//             dispatch('setErrors', 
//              error.response.data.errors,
//                 { root: true }
//             );
//     });
// }

export const getStaffByBus = ({ commit, dispatch }, {id, token}) => {            
    return Bus.staff(id, token).then(response => {
        commit('SET_STAFF_BY_BUS', response.data);
        // dispatch('sortByBusId');
    })
    .catch(error => {
        console.log(error.response.data);
        dispatch('setErrors', 
             error.response.data.errors,
            { root: true }
        );
    });
}

export const addStaffByBus = ({ commit, dispatch }, {data, id}) => {
    Bus.attachStaff(data, id).then(response => {
        commit('ADD_STAFF_BY_BUS', response.data);
        // dispatch('sortBusSchedulesByTime');
        dispatch('setSuccess', 
             {status: true},
            { root: true }
        );
    })
    .catch(error => {
        //console.log(error.response.data.message);
        dispatch('setErrors', 
             error.response.data.errors,
            { root: true }
        );
    });
}

export const removeStaffByBus = ({ commit, dispatch }, {staffId, type, busId}) => {    
    Bus.detachStaff(staffId, type, busId).then(response => {
      
        commit('REMOVE_STAFF_BY_BUS', response.data);
        // dispatch('sortBusSchedulesByTime');
    })
    .catch(error => {
        console.log(error.response.data);
    });
}

export const emptyStaffByBus = ({ commit }) => { 
    commit('EMPTY_STAFF_BY_BUS');
}

// users
export const getUsers = ({ commit, dispatch }, {token}) => {            
    return Bus.users(token).then(response => {
        commit('SET_USERS', response.data);
        dispatch('sortUsersByName');
    })
    .catch(error => {
        console.log(error.response.data);
        dispatch('setErrors', 
             error.response.data.errors,
            { root: true }
        );
    });
}

export const sortUsersByPhone = ({ commit, state }) => {
    const users = state.users;

    users.sort((a, b) => {
        return a.phone - b.phone
    });

    commit('SORT_USERS_BY_PHONE', users);
}

export const sortUsersByName = ({ commit, state }) => {
    const users = state.users;

    users.sort((a, b) => {
        let nameA = a.name.toUpperCase(); 
        let nameB = b.name.toUpperCase(); 
        if (nameA < nameB) {
            return -1;
        }
        if (nameA > nameB) {
            return 1;
        }            
        return 0;
    });

    commit('SORT_USERS_BY_NAME', users);
}

// Trips
export const getTripsBy = ({ commit, dispatch }, id) => {            
    return Bus.trips(id).then(response => {
        if (response.data.message !== 'Not Available') {            
            commit('SET_TRIPS', response.data);
        }
        // dispatch('sortByTripId');
    })
    .catch(error => {
        console.log(error.response.data);
        dispatch('setErrors', 
             error.response.data.errors,
            { root: true }
        );
    });
}

    // export const sortByTripId = ({ commit, state }) => {
    //     const trips = state.trips;

    //     trips.sort((a, b) => {
    //         return a.id - b.id
    //     });

    //     commit('SORT_TRIPS_BY_ID', trips);
    // }

export const updateTrip = ({ commit, dispatch, state }, trip ) => {       
        const DATA = {
            status: trip.status,
            driver_id: trip.driverId,
            supervisor_id: trip.supervisorId,
            helper_id: trip.helperId,
            entry_by: trip.entryBy
        }      
       
        return Bus.updateTrip(DATA, trip.id).then(response => {            
            console.log(response.data)
            // DATA.id = SLIDE.id;
            // DATA.image = SLIDE.image;

            // let slide = {
            //     data: DATA,
            //     index: SLIDE.index,
            // }
            if (response.data.message !== 'success') {
                return;
            }
            let index = state.trips.findIndex(item => item.id === trip.id);

            commit('UPDATE_TRIPS', index);

            dispatch('setSuccess', 
                {status: true},
                { root: true }
            );
        })
        .catch(error => {
            dispatch('setErrors', 
                 error.response.data.errors,
                { root: true }
            );
        });
}