export const typeBy = (state) => (id) => {
    let type = state.types.find(type => type.id == id);
    
      if(type) {              
        return type.name;
    }
}