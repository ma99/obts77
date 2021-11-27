import Api from './api';

export default {
	// types() {
	// 	return Api.get('api/types');
	// },

	buses() {
		return Api.get('api/buses');
	},

	seatplans() {
		return Api.get('api/seatplans');
	},

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

	// drivers(id) {
	// 	return Api.get(`api/${id}/drivers`);
	// },
	staff(id) {
		return Api.get(`api/${id}/staff`);
	},

	attachStaff(data, id) {
		return Api.post(`/${id}/staff`, data)
	},
	detachStaff(staffId, type, busId) {
		return Api.delete(`staff/${type}/${staffId}/bus/${busId}`)
	},
}