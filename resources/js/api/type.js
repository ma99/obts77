import Api from './api';

export default {
	types() {
		return Api.get('api/types');
	},

	store(data) {
        return Api.post('types', data);
    },

    delete(id) {
        return Api.delete(`types/${id}`);
    },
}