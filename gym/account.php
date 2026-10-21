<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Sign in or create your Brabus Gym account.">
    <title>Join Brabus | Brabus Gym</title>
    <link rel="shortcut icon" type="image/x-icon" href="img/favicon.png">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/account.css">
</head>
<body class="account-page">
    <main class="account-shell">
        <section class="account-visual" aria-label="Brabus Gym">
            <a class="account-brand" href="index.php" aria-label="Brabus home">BRABUS<span>.</span></a>
            <div class="visual-copy">
                <p class="eyebrow">TRAIN WITH PURPOSE</p>
                <h1>Stronger starts<br>right here.</h1>
                <p>Build your strength, find your rhythm, and make every session count.</p>
            </div>
            <div class="visual-footer">
                <span>YOUR SPACE. YOUR PACE.</span>
                <a href="index.php"><i class="fa fa-arrow-left" aria-hidden="true"></i> Back to Brabus</a>
            </div>
        </section>

        <section class="account-content">
            <div class="account-card">
                <a class="mobile-brand" href="index.php" aria-label="Brabus home">BRABUS<span>.</span></a>
                <p class="eyebrow">WELCOME TO BRABUS</p>
                <h2 id="account-heading">Good to see you.</h2>
                <p class="account-intro" id="account-intro">Sign in to continue your fitness journey.</p>

                <div class="account-tabs" role="tablist" aria-label="Account options">
                    <button class="account-tab is-active" id="login-tab" type="button" role="tab"
                        aria-selected="true" aria-controls="login-panel" data-panel="login">Log in</button>
                    <button class="account-tab" id="register-tab" type="button" role="tab"
                        aria-selected="false" aria-controls="register-panel" data-panel="register">Create account</button>
                </div>

                <form class="account-form" id="login-panel" role="tabpanel" aria-labelledby="login-tab">
                    <label for="login-email">Email address</label>
                    <div class="input-wrap">
                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                        <input id="login-email" name="email" type="email" placeholder="you@example.com"
                            autocomplete="email" required>
                    </div>

                    <div class="label-row">
                        <label for="login-password">Password</label>
                        <a href="#" class="form-link demo-link">Forgot password?</a>
                    </div>
                    <div class="input-wrap">
                        <i class="fa fa-lock" aria-hidden="true"></i>
                        <input id="login-password" name="password" type="password" placeholder="Enter your password"
                            autocomplete="current-password" required>
                    </div>

                    <button class="account-submit" type="submit">Log in <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    <p class="form-notice" aria-live="polite"></p>
                    <p class="switch-prompt">New to Brabus? <button type="button" class="form-link switch-tab" data-panel="register">Create an account</button></p>
                </form>

                <form class="account-form" id="register-panel" role="tabpanel" aria-labelledby="register-tab" hidden>
                    <div class="name-fields">
                        <div>
                            <label for="register-first-name">First name</label>
                            <input id="register-first-name" name="first_name" type="text" placeholder="First name"
                                autocomplete="given-name" required>
                        </div>
                        <div>
                            <label for="register-last-name">Last name</label>
                            <input id="register-last-name" name="last_name" type="text" placeholder="Last name"
                                autocomplete="family-name" required>
                        </div>
                    </div>

                    <label for="register-email">Email address</label>
                    <input id="register-email" name="email" type="email" placeholder="you@example.com"
                        autocomplete="email" required>

                    <label for="register-password">Create password</label>
                    <input id="register-password" name="password" type="password" placeholder="At least 8 characters"
                        autocomplete="new-password" minlength="8" required>

                    <label class="terms-check">
                        <input type="checkbox" name="terms" required>
                        <span>I agree to the <a href="#" class="form-link demo-link">Terms of Service</a> and <a href="#" class="form-link demo-link">Privacy Policy</a>.</span>
                    </label>

                    <button class="account-submit" type="submit">Create account <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                    <p class="form-notice" aria-live="polite"></p>
                    <p class="switch-prompt">Already have an account? <button type="button" class="form-link switch-tab" data-panel="login">Log in</button></p>
                </form>

                <p class="demo-disclaimer"><i class="fa fa-info-circle" aria-hidden="true"></i> Account forms are a visual preview. Registration and sign-in are not connected yet.</p>
            </div>
        </section>
    </main>

    <script>
        const tabs = document.querySelectorAll('.account-tab');
        const panels = {
            login: document.getElementById('login-panel'),
            register: document.getElementById('register-panel')
        };
        const heading = document.getElementById('account-heading');
        const intro = document.getElementById('account-intro');

        function showPanel(name) {
            for (const tab of tabs) {
                const isActive = tab.dataset.panel === name;
                tab.classList.toggle('is-active', isActive);
                tab.setAttribute('aria-selected', String(isActive));
            }
            for (const [panelName, panel] of Object.entries(panels)) {
                panel.hidden = panelName !== name;
            }
            heading.textContent = name === 'login' ? 'Good to see you.' : 'Start your journey.';
            intro.textContent = name === 'login'
                ? 'Sign in to continue your fitness journey.'
                : 'Create your Brabus account to get started.';
        }

        document.querySelectorAll('[data-panel]').forEach((control) => {
            control.addEventListener('click', () => showPanel(control.dataset.panel));
        });

        document.querySelectorAll('.demo-link').forEach((link) => {
            link.addEventListener('click', (event) => event.preventDefault());
        });

        document.querySelectorAll('.account-form').forEach((form) => {
            form.addEventListener('submit', (event) => {
                event.preventDefault();
                form.querySelector('.form-notice').textContent =
                    'This preview is not connected yet. Account functionality will be added in a later step.';
            });
        });
    </script>
</body>
</html>
