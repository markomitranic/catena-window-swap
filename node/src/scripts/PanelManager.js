"use strict";

class PanelManager {

	constructor(
		homePanelWrapper,
		videoPanelWrapper,
		submitPanelWrapper
	) {
		this.panels = {
			'home': homePanelWrapper,
			'video': videoPanelWrapper,
			'submit': submitPanelWrapper
		};
	}

	showPanel(key) {
		for (const panelName in this.panels) {
			if (panelName === key) {
				this.panels[panelName].classList.remove('is-hidden');
				continue;
			}
			this.panels[panelName].classList.add('is-hidden');
		}
	}

}

export default PanelManager;
