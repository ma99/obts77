import Api from './api';

export default {
	supervisors() {
		return Api.get('api/supervisors');
	},

	store(data) {
		return Api.post('supervisors', data);
	},

	delete(id) {
        return Api.delete(`supervisors/${id}`);
    },
}