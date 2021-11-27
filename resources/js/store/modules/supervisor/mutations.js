export const SET_SUPERVISOR = (state, supervisor) => {
    state.availableSupervisorList = supervisor;
}

export const SORT_SUPERVISOR_BY_ID = (state) => {
    const supervisor = state.availableSupervisorList;
    
    supervisor.sort((a, b) => {
        return a.id - b.id;
    });    
        
    state.availableSupervisorList = supervisor;
}
