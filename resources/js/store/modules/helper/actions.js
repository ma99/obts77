import Helper from '../../../api/helper';

export const getHelpers = ({ commit, dispatch }, {token}) => {
    return Helper.helpers(token).then(response => {
        commit('SET_HELPERS', response.data);
        commit('SORT_HELPERS_BY_ID');
    })
    .catch(error => {
        console.log(error.response.data);
        dispatch('setErrors', 
            error.response.data.errors,
            { root: true }
        );
    });
}

export const addHelper = ({ commit, dispatch }, {helper, images}) => {
    const data = {
        user_id: helper.selectedUserId,
        nid: helper.nid,
        address: helper.address,
        images: images
    }
   Helper.store(data).then(response => {
        commit('ADD_HELPER', response.data);
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

export const deleteHelper = ({ commit, dispatch, state }, {helper}) => {

   return Helper.delete(helper).then(response => {
        let index = state.availableHelperList.findIndex(helper => helper.id === response.data.id);
                    
        commit('DELETE_HELPER', index);
        dispatch('setDeletedStatus', {status: true});
    })
    .catch(error => {
        console.log(error.response.data);
    });
}

export const setDeletedStatus = ({ commit }, deleted) => {    
    commit('SET_DELETED_STATUS', deleted);
}