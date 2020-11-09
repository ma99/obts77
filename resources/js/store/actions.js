export const setErrors = ({ commit }, errors) => {

	// const stateErrors = state.errors;

	// Object.keys(errors).forEach(key => {
	//     // console.log(key, errors[key]);
	//     // state.errors.key = errors[key];
	//     stateErrors.key = errors[key];
	// });

	// console.log(stateErrors);		
    
    commit('SET_ERRORS', errors);
}

// export const resetErrors = ({ commit }, field) => {
//     commit('RESET_ERRORS', field);
// }

export const resetErrors = ({ commit, getters }, field) => {
	if (getters.any()) {
    	commit('RESET_ERRORS', field);
    }
}

export const setSuccess = ({ commit }, success) => {	
    commit('SET_SUCCESS', success);
}