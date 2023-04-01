let login = {
    emailPattern: '[-\.\w]*\@sunland.dk',
    run: function () {
        this.checkEmailDomainOnLogin();
    },
    checkEmailDomainOnLogin: function () {
        let form = document.getElementById('login_form');
        
        if (form == null) {
            return;
        }

        form.addEventListener('submit', function (e) {
            return; //temporarily disable checking by domain, remove to enable
            let emailField = document.getElementById('inputEmail');
            const regex = new RegExp(login.emailPattern);
            if (regex.test(emailField.value) === false) {
                alert('Error: Only emails under \'@sunland.dk\' domain are allowed!')
                e.preventDefault();
            }
        })
    },
}

export {login}