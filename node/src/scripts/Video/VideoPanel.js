"use strict";

class VideoPanel {

	constructor(
		videoProvider,
		embedCodeResolver,
		iframeWrapper
	) {
		this.videoProvider = videoProvider;
		this.embedCodeResolver = embedCodeResolver;
		this.iframeWrapper = iframeWrapper;
		this.nameLabel = document.querySelector('.video-info .uploader');
		this.locationLabel = document.querySelector('.video-info .location span');
	}

	next() {
		this.videoProvider.get((video) => {
			this.iframeWrapper.innerHTML = this.embedCodeResolver.getEmbedCode(video.getVideoId());
			this.nameLabel.innerHTML = `${video.name}'s View`
			this.locationLabel.innerHTML = video.location
		});
	}

	off() {
		this.iframeWrapper.innerHTML = '';
		this.nameLabel.innerHTML = '';
		this.locationLabel.innerHTML = '';
	}

}

export default VideoPanel;
