import Supervisor from '../../../api/supervisor';

export const getSupervisors = ({ commit, dispatch }) => {
    return Supervisor.supervisors().then(response => {
        commit('SET_SUPERVISOR', response.data);
        commit('SORT_SUPERVISOR_BY_ID');
    })
    .catch(error => {
        console.log(error.response.data);
        dispatch('setErrors', 
            error.response.data.errors,
            { root: true }
        );
    });
}

