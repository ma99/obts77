import Api from './api';

export default {
	helpers(token) {
		return Api.get('api/helpers', {
			headers: {
				Authorization: `Bearer ${token}`
			}
		});
	},

	store(data) {
		return Api.post('helpers', data);
	},

	delete(data) {
        return Api.delete('helpers/delete', {data: data});
    },
}