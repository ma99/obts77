import Type from '../../../api/type';

export const getBusTypes = ({ commit, dispatch }) => {
    return Type.types().then(response => {
        commit('SET_BUS_TYPES', response.data);
    })
    .catch(error => {
        console.log(error.response.data);
        dispatch('setErrors', 
             error.response.data.errors,
            { root: true }
        );
    });
}

export const addType = ({ commit, dispatch }, type) => {
    // console.table(type);
    return Type.store(type).then(response => {        
        commit('ADD_TYPE', response.data);
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

export const deleteType = ({ commit, state }, id) => {

   return Type.delete(id).then(response => {
    
        let index = state.types.findIndex(type => type.id === id);
                    
        commit('DELETE_TYPE', index);
    })
    .catch(error => {
        console.log(error.response.data);
    });
}
