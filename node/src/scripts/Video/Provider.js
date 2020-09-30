"use strict";

import axios from "axios";
import Video from "./Video";

class Provider {

	get(callback) {
		axios.get('/api/video/random')
			.then((response) => {
				callback(new Video(
					response.data.data.name,
					response.data.data.location,
					response.data.data.videoId
				));
			})
			.catch(error => console.error(error));
	}

}

export default Provider;
