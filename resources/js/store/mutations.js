export const SET_ERRORS = (state, errors) => {
    // Object.assign(state.errors, errors)
    state.errors = 
    { ...state.errors, ...errors };
    // state.errors = stateErrors;
}

export const SET_SUCCESS = (state, success) => {
    state.success = success.status;
}

export const RESET_ERRORS = (state, field) => {
	if (field) {
        delete state.errors[field];

        return;
    }
    state.errors = {};
}    