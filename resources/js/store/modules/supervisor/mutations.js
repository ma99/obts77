export const SET_SUPERVISORS = (state, supervisor) => {
    state.availableSupervisorList = supervisor;
}

export const SORT_SUPERVISORS_BY_ID = (state) => {
    const supervisor = state.availableSupervisorList;
    
    supervisor.sort((a, b) => {
        return a.id - b.id;
    });    
        
    state.availableSupervisorList = supervisor;
}

export const ADD_SUPERVISOR = (state, supervisor) => {          
    state.availableSupervisorList.push(supervisor);
}

export const DELETE_SUPERVISOR = (state, index) => {
    state.availableSupervisorList.splice(index, 1);
}

export const SET_DELETED_STATUS = (state, deleted) => {
    state.deleted = deleted.status;
}
