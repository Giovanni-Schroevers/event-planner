<div class="login-container">
    <h1>Login</h1>

    <form action="/login" method="POST" class="login-form">
        <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Wachtwoord</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn btn-primary">Login</button>

        <p class="form-footer">
            Nog geen account? <a href="/register">Registreer hier</a>
        </p>
    </form>
</div>