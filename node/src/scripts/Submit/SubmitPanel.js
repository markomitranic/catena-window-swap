"use strict";


class SubmitPanel {

	constructor(errorPopup, adapter, uploadSectionWrapper, successCallback) {
		this.errorPopup = errorPopup;
		this.adapter = adapter;
		this.uploadSectionWrapper = uploadSectionWrapper;
		this.successCallback = successCallback;
		this.form = this.uploadSectionWrapper.querySelector('form.form');
		this.submitLoaderWrapper = this.form.querySelector('.submit-button');
		this.form.addEventListener('submit', event => this.submit(event));
		this.videoFieldWrapper = this.form.querySelector('.file-upload');
		this.videoField = this.videoFieldWrapper.querySelector('#video');
		this.videoField.addEventListener('change', (e) => {
			if (this.videoField.files.length !== 0) {
				this.videoFieldWrapper.classList.add('contains-files');
			} else {
				this.videoFieldWrapper.classList.remove('contains-files');
			}
		});
	}

	submit(event) {
		event.preventDefault();
		const formData = new FormData(this.form);
		this.submitLoaderWrapper.classList.add('is-disabled');

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
		this.submitLoaderWrapper.classList.remove('is-disabled');
		this.errorPopup.add('Your video is safe and sound. Pending approval.');
		this.successCallback();
	}

	error(error) {
		this.submitLoaderWrapper.classList.remove('is-disabled');
		console.error(error);
		this.errorPopup.add(error);
	}

}

export default SubmitPanel;
