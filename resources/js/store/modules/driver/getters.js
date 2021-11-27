export const getDriverBy = (state) => (id) => {         
    return state.availableDriverList.find(driver => 
    	driver.id == id);     
}