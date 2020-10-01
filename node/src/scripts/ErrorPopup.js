"use strict";

class ErrorPopup {

	constructor() {
		this.wrapper = document.getElementById('error-popup-wrapper');
	}

	add(message, level = 'danger') {
		const newNotification = this.getTemplate(message, level);
		this.wrapper.append(newNotification);
		newNotification.querySelector('.close').addEventListener('click', () => {
			this.wrapper.removeChild(newNotification);
		});
	}

	getTemplate(message, level) {
		const wrapper = document.createElement('li');
		wrapper.innerHTML = `<div class="alert" role="alert">
			<strong>Holy guacamole!</strong> <br> ${message}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>`;
		return 	wrapper;
	}

}

export default ErrorPopup;
