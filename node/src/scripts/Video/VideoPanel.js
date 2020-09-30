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
	}

	next() {
		this.videoProvider.get((video) => {
			this.iframeWrapper.innerHTML = this.embedCodeResolver.getEmbedCode(video.getVideoId());
		});
	}

	off() {
		this.iframeWrapper.innerHTML = '';
	}

}

export default VideoPanel;
