var ten = document.querySelector('#name'), email = document.querySelector('#email'), password = document.querySelector('#password');
function onEmailFocus(e) {
	e.target.parentElement.classList.add("focusWithText");
	getCoord();
}

function onEmailBlur(e) {
	if(e.target.value == "") {
		e.target.parentElement.classList.remove("focusWithText");
	}
	resetFace();
}

function onEmailFocus2(a) {
	a.target.parentElement.classList.add("focusWithText");
	getCoord();
}

function onPasswordFocus(e) {
	coverEyes();
}

function onPasswordBlur(e) {
	uncoverEyes();
}
email.addEventListener('focus', onEmailFocus);
email.addEventListener('blur', onEmailBlur);
ten.addEventListener('focus', onEmailFocus2);
ten.addEventListener('blur', onEmailBlur);
password.addEventListener('focus', onPasswordFocus);
password.addEventListener('blur', onPasswordBlur);