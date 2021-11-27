import Helper from '../../../api/helper';

export const getHelpers = ({ commit, dispatch }) => {
    return Helper.helpers().then(response => {
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