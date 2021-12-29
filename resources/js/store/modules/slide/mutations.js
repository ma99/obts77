export const SET_SLIDES = (state, slides) => {
    state.availableSlideList = slides;
}

export const SORT_SLIDES_BY_ID = (state) => {
    const slides = state.availableSlideList;
    
    slides.sort((a, b) => {
        return a.id - b.id;
    });    
        
    state.availableSlideList = slides;
}

export const ADD_SLIDE = (state, slide) => {          
    state.availableSlideList.push(slide);
}

export const UPDATE_SLIDE = (state, slide) => {
    let index = slide.index;
    state.availableSlideList[index] = slide.data;
}

export const DELETE_SLIDE = (state, index) => {
    state.availableSlideList.splice(index, 1);
}

export const SET_DELETED_STATUS = (state, deleted) => {
    state.deleted = deleted.status;
}