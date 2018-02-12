(function(d) {
    let form = d.getElementById('form-forgotpassword');
    let user = d.getElementById('user');
    let message = d.querySelector('.message');
    let responseServer = (response) => {
        if (response.hasOwnProperty('success')) {
            if (response.success) {
                user.parentNode.classList.remove('error');
                message.style.color = '#1ab667';
                form.reset();
            } else {
                user.parentNode.classList.add('error');
                message.style.color = '#ce1a2b';
            }
            if (response.message.hasOwnProperty('user')) {
                message.innerHTML = response.message.user[0];
            } else {
                message.innerHTML = response.message;
            }
        }
    };

    form.addEventListener('submit', (e) => {
        e.preventDefault();
        user.parentNode.classList.remove('error');
        message.innerHTML = '';
        formData = new FormData(form);
        Ajax.send('http://thermobackend.com/resetPassword', 'POST', 'json', responseServer, formData, 'string');
    });

})(document);