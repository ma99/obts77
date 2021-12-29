import Slide from '../../../api/slide';

export const getSlides = ({ commit, dispatch }, {token}) => {
    return Slide.slides(token).then(response => {
        commit('SET_SLIDES', response.data);
        commit('SORT_SLIDES_BY_ID');
    })
    .catch(error => {
        console.log(error.response.data);
        dispatch('setErrors', 
            error.response.data.errors,
            { root: true }
        );
    });
}

export const addSlide = ({ commit, dispatch }, {slide, image}) => {
    const DATA = {        
        active: slide.activate,
        image: image
    }
   Slide.store(DATA).then(response => {
        commit('ADD_SLIDE', response.data);
        //dispatch('setFaresByRoute');
        dispatch('setSuccess', 
            {status: true},
            { root: true }
        );
    })
    .catch(error => {
        console.log(error.response.data);
        dispatch('setErrors', 
             error.response.data.errors,
            { root: true }
        );
    });
}

export const updateSlide = ({ commit, dispatch }, { slide }) => {
        
        const DATA = {
            active: slide.active,
             image: [],            
        }
        DATA.image.push(slide.image);
       
        const SLIDE = slide; 
        
        Slide.update(DATA, slide.id).then(response => {            

            DATA.id = SLIDE.id;
            DATA.image = SLIDE.image;

            let slide = {
                data: DATA,
                index: SLIDE.index,
            }

            commit('UPDATE_SLIDE', slide);

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

export const deleteSlide = ({ commit, dispatch, state }, id) => {

   return Slide.delete(id).then(response => {

        let index = state.availableSlideList.findIndex(slide => slide.id === response.data.id);
                    
        commit('DELETE_SLIDE', index);
        dispatch('setDeletedStatus', {status: true});
    })
    .catch(error => {
        console.log(error.response.data);
    });
}

export const setDeletedStatus = ({ commit }, deleted) => {    
    commit('SET_DELETED_STATUS', deleted);
}
