function toaster(title,message) {
	document.querySelector('#toaster').style.transform 		= 'translateX(0%)';
	document.querySelector('#toaster').style.transition 	= '2s';
	document.querySelector('.toaster-title').innerHTML 		= title;
	document.querySelector('.toaster-message').innerHTML 	= message;
	setTimeout(clean,3000);
}

function clean() {
	document.querySelector('#toaster').style.transform = 'translateX(120%)';
	document.querySelector('#toaster').style.transition = '2s';
}