import Api from './api';

export default {
	helpers() {
		return Api.get('api/helpers');
	},

	store(data) {
		return Api.post('helpers', data);
	},

	delete(id) {
        return Api.delete(`helpers/${id}`);
    },
}