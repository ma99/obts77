import Api from './api';

export default {
	drivers() {
		return Api.get('api/drivers');
	},

	store(data) {
		return Api.post('drivers', data);
	},

	delete(id) {
        return Api.delete(`drivers/${id}`);
    },
}