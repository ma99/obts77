import Api from './api';

export default {
	seatplans(token) {
		return Api.get('api/seatplans', {
			headers: {                   
        		Authorization: `Bearer ${token}`
    		}
		});
	},

	store(data) {
		return Api.post('seatplans', data);
	},

	delete(id) {
        return Api.delete(`seatplans/${id}`);
    },
}