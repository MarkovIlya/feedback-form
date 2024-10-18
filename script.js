document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('contactForm');
    const emailField = document.getElementById('email');
    const submitButton = document.getElementById('submitButton');
    const nameField = document.getElementById('name');
    const phoneField = document.getElementById('phone');
    const messageField = document.getElementById('message');
    const emailError = document.getElementById('email-error');

    form.addEventListener('submit', async function (event) {
        event.preventDefault();
        const valid = await validateForm();
        if (valid) {
            form.submit();
            return true;
        } else {
            submitButton.style.display = "none";
            return false;
        }

    });

    emailField.addEventListener('blur', async function (event) {
        const email = emailField.value.trim();

        const data = {
            email: email,
        };

        let response = await fetch('ajax/check_email.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(data)
        }).then(response => {
            return response.json();
        }).then(result => {
            if (result.exist) {
                submitButton.style.display = "none";
                emailError.innerText = "Такой email уже есть";
            } else {
                submitButton.style.display = "block";
                emailError.innerText = "";
            }
        })
    })

    async function validateForm() {
        let isValid = true;

        const name = nameField.value.trim();
        if (name === '' || /\d/.test(name)) {
            alert('Please enter a valid name without numbers.');
            isValid = false;
        }

        const phone = phoneField.value.trim();
        if (!/^\d{10,12}$/.test(phone)) {
            alert('Please enter a valid phone number (10-12 digits).');
            isValid = false;
        }

        const email = emailField.value.trim();
        if (!/^\S+@\S+\.\S+$/.test(email)) {
            alert('Please enter a valid email address.');
            isValid = false;
        }

        const message = messageField.value.trim();
        if (message === '') {
            alert('Please enter your message.');
            isValid = false;
        }

        const data = {
            name: name,
            phone: phone,
            email: email,
            message: message,
        };

        fetch('ajax/submit.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json;charset=utf-8'
            },
            body: JSON.stringify(data)
        }).then(response => {
            return response.json();
        }).then(result => {
            if (result.exist) {
                isValid = false;
            } else {
                isValid = true;
            }
        })

        return isValid;
    }

});