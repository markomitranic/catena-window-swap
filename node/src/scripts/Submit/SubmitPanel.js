"use strict";

class SubmitPanel {

	constructor(errorPopup, adapter, uploadSectionWrapper, successCallback) {
		this.errorPopup = errorPopup;
		this.adapter = adapter;
		this.uploadSectionWrapper = uploadSectionWrapper;
		this.successCallback = successCallback;
		this.form = this.uploadSectionWrapper.querySelector('form.form');
		this.form.addEventListener('submit', event => this.submit(event));
		this.nameField = this.form.querySelector('input#name');
		this.locationField = this.form.querySelector('input#location');
		this.videoField = this.form.querySelector('input#video');
	}

	submit(event) {
		event.preventDefault();
		const formData = new FormData(this.form);

		this.adapter.submit(
			formData.get('name'),
			formData.get('location'),
			formData.get('video'),
			(response, error = null) => {
				if (error) {
					this.error(error);
				} else {
					this.success();
				}
			}
		);
	}

	success() {
		this.errorPopup.add('Your video is safe and sound. Pending approval.');
		this.successCallback();
	}

	error(error) {
		console.error(error);
		this.errorPopup.add(error);
	}

}

export default SubmitPanel;
