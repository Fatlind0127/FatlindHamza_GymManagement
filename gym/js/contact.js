document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('contactForm');
    var status = document.getElementById('contactFormStatus');
    var submit = document.getElementById('contactSubmit');

    if (!form || !status || !submit) {
        return;
    }

    form.addEventListener('submit', function (event) {
        event.preventDefault();
        if (!form.reportValidity()) {
            return;
        }

        status.hidden = true;
        submit.disabled = true;
        submit.textContent = 'Sending...';

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { Accept: 'application/json' }
        })
            .then(function (response) {
                return response.json().then(function (result) {
                    return { ok: response.ok, result: result };
                });
            })
            .then(function (response) {
                status.textContent = response.result.message || 'Unable to send your message.';
                status.className = 'contact-form-status ' + (response.ok && response.result.success ? 'is-success' : 'is-error');
                status.hidden = false;
                if (response.ok && response.result.success) {
                    form.reset();
                }
            })
            .catch(function () {
                status.textContent = 'We could not send your message. Please try again later.';
                status.className = 'contact-form-status is-error';
                status.hidden = false;
            })
            .finally(function () {
                submit.disabled = false;
                submit.textContent = 'Send message';
            });
    });
});