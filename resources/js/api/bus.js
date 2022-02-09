import Api from './api';

export default {
	// types() {
	// 	return Api.get('api/types');
	// },

	// buses() {
	// 	return Api.get('api/buses');
	// },
	buses(token) {
		return Api.get('api/buses', {
		    headers: {   
                // "Content-Type": "application/json",
                Authorization: `Bearer ${token}`
            }
		});
	},
	users(token) {
		return Api.get('api/users', {
		    headers: {   
                // "Content-Type": "application/json",
                Authorization: `Bearer ${token}`
            }
		});
	},

	// seatplans() {
	// 	return Api.get('api/seatplans');
	// },

	store(data) {
        return Api.post('buses', data);
    },

    update(data, id) {
        return Api.patch(`buses/${id}`, data);
    },

    delete(id) {
        return Api.delete(`buses/${id}`);
    },

    schedules(id) {
		return Api.get(`api/${id}/schedules`);
	},
	
	attach(data, id) {
		return Api.post(`/${id}/schedules`, data);
	},

	detach(schedule, bus) {
		return Api.delete(`bus-schedules/${bus}/${schedule}`);
	},

	trips(id) {
		return Api.get(`api/trips/supervisors/users/${id}`);
	},	

	updateTrip(data, id) {
        return Api.patch(`trips/${id}`, data);
    },

	staff(id, token) {
		return Api.get(`api/${id}/staff`, {
			headers: {   
                Authorization: `Bearer ${token}`
            }
		});
	},
	
	attachStaff(data, id) {
		return Api.post(`/${id}/staff`, data)
	},

	detachStaff(staffId, type, busId) {
		return Api.delete(`staff/${type}/${staffId}/bus/${busId}`)
	},
}