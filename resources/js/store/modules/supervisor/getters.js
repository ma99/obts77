export const getSupervisorBy = (state) => (id) => {         
    return state.availableSupervisorList.find(supervisor => 
    	supervisor.id == id);     
}