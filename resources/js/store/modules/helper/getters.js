export const getHelperBy = (state) => (id) => {         
    return state.availableHelperList.find(helper => 
    	helper.id == id);     
}