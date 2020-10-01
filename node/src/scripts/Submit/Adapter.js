"use strict";

import axios from "axios";

class Adapter {

	submit(name, location, video, callback) {
		const formData = new FormData();
		formData.append('name', name);
		formData.append('location', location);
		formData.append('video', video);

		axios.post('/api/video/submit', formData, {headers: {'Content-Type': 'multipart/form-data'}})
			.then(response => callback(response.data))
			.catch(error => {
				let errorMessage = error.message;
				if (error.response.data.error) {
					errorMessage = error.response.data.error;
				}

				callback(null, errorMessage);
			});
	}

}

export default Adapter;
