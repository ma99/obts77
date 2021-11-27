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