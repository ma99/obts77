import Driver from '../../../api/driver';

export const getDrivers = ({ commit, dispatch }) => {
    return Driver.drivers().then(response => {
        commit('SET_DRIVERS', response.data);
        commit('SORT_DRIVERS_BY_ID');
    })
    .catch(error => {
        console.log(error.response.data);
        dispatch('setErrors', 
            error.response.data.errors,
            { root: true }
        );
    });
}

export const addSeatplan = ({ commit, dispatch }, data) => {
   Seatplan.store(data).then(response => {
        // console.log('afA=', response.data)

        commit('ADD_SEATPLAN', response.data);
        //dispatch('setFaresByRoute');
        dispatch('setSuccess', 
            {status: true},
            { root: true }
        );
    })
    .catch(error => {
        console.log(error.response.data);
        // dispatch('setErrors', 
        //      error.response.data.errors,
        //     { root: true }
        // );
    });
}

export const deleteSeatplan = ({ commit, state }, id) => {

       return Seatplan.delete(id).then(response => {
        
            let index = state.availableSeatPlanList.findIndex(seatplan => seatplan.id === id);
                        
            commit('DELETE_SEATPLAN', index);
            // dispatch('setFaresByRoute');
        })
        .catch(error => {
            console.log(error.response.data);
        });
    }

export const updateSeatplan = ({ commit }, seatplan ) => {
        // console.log('Fare=', fare);
        const data = {
            city_route_id: fare.city.id,
            details: fare.details
        }
        
        return Seatplan.update(data, fare.id).then(response => {            
            
            fare.updated_at = response.data;
            
            commit('UPDATE_FARE', fare);
        })
        .catch(error => {
            console.log(error.response.data);
        });
}