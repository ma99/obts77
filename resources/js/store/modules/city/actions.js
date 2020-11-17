import City from '../../../api/city';

export const getDivisions = ({ commit }) => {
    return City.divisions().then(response => {
        commit('SET_DIVISIONS', response.data);
    });
}

export const getDistricts = ({ commit }) => {
    return City.districts().then(response => {
        commit('SET_DISTRICTS', response.data);      
    });
}

export const getUpazilas = ({ commit }) => {
    return City.upazilas().then(response => {
        commit('SET_UPAZILAS', response.data);
        //commit('SORT_SEATPLANS_BY_ID');
    });
}

// export const getUpazilasByDistrict = ({ commit, getters }, id) => {  
// 	let upazilas = getters.upazilasByDistrict(id);  

//     commit('SET_UPAZILAS_BY_DISTRICT', upazilas);    
// }

export const getBusAvailableToCities = ({ commit, dispatch }) => {
    return City.cities().then(response => {
        commit('SET_CITIES', response.data);
        commit('SORT_CITIES_BY_NAME');
    })
    .catch(error => {
       console.log(error.response.data);
       dispatch('setErrors', 
             error.response.data.errors,
            { root: true }
        );
    });
}

export const sortCitiesByName =  ({ commit }) => { 
    commit('SORT_CITIES_BY_NAME');
}

export const sortCitiesByDistrict  =  ({ commit }) => { 
    commit('SORT_CITIES_BY_DISTRICT');
}

export const addCity = ({ commit, dispatch }, city) => {

        City.store(city).then(response => {
            commit('ADD_CITY', response.data);
            //commit('SORT_CITIES_BY_NAME');
            dispatch('setSuccess', 
                {status: true},
                { root: true }
            );
        })
        .catch(error => {
            dispatch('setErrors', 
                 error.response.data.errors,
                { root: true }
            );
        });
    }

    export const deleteCity = ({ commit, state }, id) => {

        return City.delete(id).then(response => {
        
            let index = state.cityList.findIndex(city => city.id === id);
                        
            commit('DELETE_CITY', index);
        })
        .catch(error => {
            console.log(error.response.data);
        });
    }

    export const getCitiesByDivisionOfFirstAndSecondCity = ({ commit, getters }, route) => {  
    let cities = getters.citiesByDivisionOfFirstAndSecondCity(route);  

    commit('SET_CITIES_BY_DIVISION_OF_ROUTE', cities);    
}