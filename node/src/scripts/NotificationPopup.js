"use strict";

class NotificationPopup {

	constructor() {
		this.wrapper = document.getElementById('error-popup-wrapper');
	}

	add(message, level = 'danger') {
		this.wrapper.append(this.getTemplate(message, level));
	}

	getTemplate(message, level) {
		const wrapper = document.createElement('li');
		wrapper.innerHTML = `<div class="alert alert-${level} alert-dismissible fade show" role="alert">
			<strong>Holy guacamole!</strong> <br> ${message}
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">&times;</span>
			</button>
		</div>`;
		return 	wrapper;
	}

}

export default NotificationPopup;
