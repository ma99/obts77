import Api from './api';

export default {
	supervisors(token) {
		return Api.get('api/supervisors', {
			headers: {
				Authorization: `Bearer ${token}`
			}
		});
	},

	store(data) {
		return Api.post('supervisors', data);
	},

	delete(data) {
        return Api.delete('supervisors/delete', {data: data});
    },
}