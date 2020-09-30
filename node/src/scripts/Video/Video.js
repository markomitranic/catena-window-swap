"use strict";

class Video {

	constructor(name, location, videoId) {
		this.name = name;
		this.location = location;
		this.videoId = videoId;
	}

	getName() {
		return this.name;
	}

	getLocation() {
		return this.location;
	}

	getVideoId() {
		return this.videoId;
	}

}

export default Video;
