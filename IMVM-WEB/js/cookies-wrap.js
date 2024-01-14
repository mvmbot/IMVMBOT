const btnAcceptCoookies = document.getElementById('btn-accept-cookies');
const CookiesWrap = document.getElementById('cookies-wrap');
const backgroundCookiesWrap = document.getElementById('background-cookies-wrap');

dataLayer = [];

if(!localStorage.getItem('accepted-cookies')){
	CookiesWrap.classList.add('active');
	backgroundCookiesWrap.classList.add('active');
} else {
	dataLayer.push({'event': 'cookies'});
}

btnAcceptCoookies.addEventListener('click', () => {
	CookiesWrap.classList.remove('active');
	backgroundCookiesWrap.classList.remove('active');

	localStorage.setItem('accepted-cookies', true);

	dataLayer.push({'event': 'accepted-cookies'});
});