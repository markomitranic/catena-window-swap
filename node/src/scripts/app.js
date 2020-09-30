import Provider from "./Video/Provider";
import VideoPanel from "./Video/VideoPanel";
import YoutubeEmbedResolver from "./Video/YoutubeEmbedResolver";
import PanelManager from "./PanelManager";

const panelManager = new PanelManager(
	document.querySelector('.home-section'),
	document.querySelector('.video-section'),
	document.querySelector('.upload-section')
);

const videoPanel = new VideoPanel(
	new Provider(),
	new YoutubeEmbedResolver(),
	document.getElementById('iframe-wrapper')
);

document.querySelector('.home-section .buttons .submit').addEventListener('click', () => {
	panelManager.showPanel('submit');
});

document.querySelector('.home-section .buttons .video').addEventListener('click', () => {
	panelManager.showPanel('video');
	videoPanel.next();
});

document.getElementById('next-video-button').addEventListener('click', () => {
	videoPanel.next();
});

document.querySelector('.video-wrapper .buttons .submit').addEventListener('click', () => {
	panelManager.showPanel('submit');
	videoPanel.off();
});

