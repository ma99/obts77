export const SET_HELPERS = (state, helpers) => {
    state.availableHelperList = helpers;
}

export const SORT_HELPERS_BY_ID = (state) => {
    const helpers = state.availableHelperList;
    
    helpers.sort((a, b) => {
        return a.id - b.id;
    });    
        
    state.availableHelperList = helpers;
}

export const ADD_HELPER = (state, helper) => {          
    state.availableHelperList.push(helper);
}

export const DELETE_HELPER = (state, index) => {
    state.availableHelperList.splice(index, 1);
}

export const SET_DELETED_STATUS = (state, deleted) => {
    state.deleted = deleted.status;
}