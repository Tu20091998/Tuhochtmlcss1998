        const app = document.getElementById('app');

        //tạo container chính
        const card = document.createElement('div');
        card.className = 'card';

        //tạo tiêu đề
        const title = document.createElement('h2');
        title.textContent = 'Sign In';
        card.appendChild(title);

        //tạo email input
        const emailGroup = document.createElement('div');
        emailGroup.className = 'form-group';
        const emailLabel = document.createElement('label');
        emailLabel.textContent = 'Email: ';
        const emailInput = document.createElement('input');
        emailInput.type = 'email';
        emailInput.placeholder = 'Enter your email';
        emailGroup.appendChild(emailLabel);
        emailGroup.appendChild(emailInput);
        card.appendChild(emailGroup);

        //tạo password input
        const passwordGroup = document.createElement('div');
        passwordGroup.className = 'form-group';
        const passwordLabel = document.createElement('label');
        passwordLabel.textContent = 'Password: ';
        const passwordInput = document.createElement('input');
        passwordInput.type = 'password';
        passwordInput.placeholder = 'Enter your password';
        passwordGroup.appendChild(passwordLabel);
        passwordGroup.appendChild(passwordInput);
        card.appendChild(passwordGroup);

        //forgot password link
        const forgotLink = document.createElement("div");
        forgotLink.className = "forgot-link";
        forgotLink.innerHTML = '<a href="#">Forgot Password?</a>';
        card.appendChild(forgotLink);

        //tạo button
        const signInButton = document.createElement('button');
        signInButton.className = 'btn';
        signInButton.textContent = 'Sign In';
        card.appendChild(signInButton);

        //tạo footer
        const footer = document.createElement('div');
        footer.className = 'footer';
        footer.innerHTML = 'Don`t have an account? <a href="#">Register</a>';

        //render ra giao diện
        app.appendChild(card);

        // Vùng hiển thị lỗi/thông báo
        const message = document.createElement('div');
        message.className = 'error';
        card.appendChild(message);

        //kiểm tra sự kiện click button
        signInButton.addEventListener('click', function() {
                const email = emailInput.value.trim();
                const password = passwordInput.value.trim();

                // Regex kiểm tra email và password
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

                //kiểm tra email
                if (!emailRegex.test(email)) {
                        alert('Vui lòng nhập email hợp lệ.');
                        return;
                }

                //kiểm tra password
                if (!passwordRegex.test(password)) {
                        alert('Mật khẩu phải có ít nhất 8 ký tự, bao gồm chữ hoa, chữ thường, số và ký tự đặc biệt.');
                        return;
                }

                //kiểm tra đăng nhập thành công
                if(email.includes("admin") && password === "Adm!n123") {
                        message.style.color = 'green';
                        message.textContent = 'Đăng nhập thành công!';
                }
                else{
                        message.style.color = 'red';
                        message.textContent = 'Đăng nhập thất bại. Vui lòng kiểm tra lại email và mật khẩu.';
                }
        });
        