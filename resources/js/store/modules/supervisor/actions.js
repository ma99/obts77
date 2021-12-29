import Supervisor from '../../../api/supervisor';

export const getSupervisors = ({ commit, dispatch }, {token}) => {
    return Supervisor.supervisors(token).then(response => {
        commit('SET_SUPERVISORS', response.data);
        commit('SORT_SUPERVISORS_BY_ID');
    })
    .catch(error => {
        console.log(error.response.data);
        dispatch('setErrors', 
            error.response.data.errors,
            { root: true }
        );
    });
}

export const addSupervisor = ({ commit, dispatch }, {supervisor, images}) => {
    const data = {
        user_id: supervisor.selectedUserId,
        nid: supervisor.nid,
        address: supervisor.address,
        images: images
    }
   Supervisor.store(data).then(response => {
        commit('ADD_SUPERVISOR', response.data);
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

export const deleteSupervisor = ({ commit, dispatch, state }, {supervisor}) => {

   return Supervisor.delete(supervisor).then(response => {
        let index = state.availableSupervisorList.findIndex(supervisor => supervisor.id === response.data.id);
                    
        commit('DELETE_SUPERVISOR', index);
        dispatch('setDeletedStatus', {status: true});
    })
    .catch(error => {
        console.log(error.response.data);
    });
}

export const setDeletedStatus = ({ commit }, deleted) => {    
    commit('SET_DELETED_STATUS', deleted);
}