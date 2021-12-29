import Driver from '../../../api/driver';

export const getDrivers = ({ commit, dispatch }, {token}) => {
    return Driver.drivers(token).then(response => {
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

export const addDriver = ({ commit, dispatch }, {driver, images}) => {
    const data = {
        user_id: driver.selectedUserId,
        nid: driver.nid,
        address: driver.address,
        images: images
    }
   Driver.store(data).then(response => {
        commit('ADD_DRIVER', response.data);
        //dispatch('setFaresByRoute');
        dispatch('setSuccess', 
            {status: true},
            { root: true }
        );
    })
    .catch(error => {
        console.log(error.response.data);
        dispatch('setErrors', 
             error.response.data.errors,
            { root: true }
        );
    });
}

export const deleteDriver = ({ commit, dispatch, state }, {driver}) => {

   return Driver.delete(driver).then(response => {
        let index = state.availableDriverList.findIndex(driver => driver.id === response.data.id);
                    
        commit('DELETE_DRIVER', index);
        dispatch('setDeletedStatus', {status: true});
    })
    .catch(error => {
        console.log(error.response.data);
    });
}

export const setDeletedStatus = ({ commit }, deleted) => {    
    commit('SET_DELETED_STATUS', deleted);
}
