"use strict";

class YoutubeEmbedResolver {

	getEmbedCode(videoId) {
		return `<iframe src="https://www.youtube.com/embed/${videoId}?rel=0&modestbranding=1&autohide=1&showinfo=0&controls=0&autoplay=1&disablekb=1&fs=0&loop=1&playsinline=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
	}

}

export default YoutubeEmbedResolver;
