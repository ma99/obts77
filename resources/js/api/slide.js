import Api from './api';

export default {
	slides(token) {
		return Api.get('api/slides', {
			headers: {
				Authorization: `Bearer ${token}`
			}
		});
	},

	store(data) {
		return Api.post('slides', data);
	},

	update(data, id) {
        return Api.patch(`slides/${id}`, data);
    },

	delete(id) {		
        return Api.delete(`slides/${id}`);
    },
}