export const SET_DRIVERS = (state, drivers) => {
    state.availableDriverList = drivers;
}

export const SORT_DRIVERS_BY_ID = (state) => {
    const drivers = state.availableDriverList;
    
    drivers.sort((a, b) => {
        return a.id - b.id;
    });    
        
    state.availableDriverList = drivers;
}

export const ADD_DRIVER = (state, driver) => {          
    state.availableDriverList.push(driver);
}

export const DELETE_DRIVER = (state, index) => {
    state.availableDriverList.splice(index, 1);
}

export const SET_DELETED_STATUS = (state, deleted) => {
    state.deleted = deleted.status;
}