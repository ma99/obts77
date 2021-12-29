import Api from './api';

export default {
	drivers(token) {
		return Api.get('api/drivers', {
			headers: {
				Authorization: `Bearer ${token}`
			}
		});
	},

	store(data) {
		return Api.post('drivers', data);
	},

	delete(data) {		
        return Api.delete('drivers/delete', {data: data});
    },
}