<div class="form-wrapper">
    <h1>Registreren</h1>
    <div class="form-container">
        <form action="/register" method="POST" class="form">
            <div class="form-group">
                <label for="firstname">Voornaam <span style="color: var(--error)">*</span></label>
                <input type="text" id="firstname" name="firstname" required>
            </div>

            <div class="form-group">
                <label for="middle_name">Middelste naam</label>
                <input type="text" id="middle_name" name="middle_name">
            </div>

            <div class="form-group">
                <label for="lastname">Achternaam <span style="color: var(--error)">*</span></label>
                <input type="text" id="lastname" name="lastname" required>
            </div>

            <div class="form-group">
                <label for="email">E-mail <span style="color: var(--error)">*</span></label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="phone">Telefoonnummer</label>
                <input type="tel" id="phone" name="phone">
            </div>

            <div class="form-group">
                <label for="membership_number">Lidmaatschapsnummer <span style="color: var(--error)">*</span></label>
                <input type="text" id="membership_number" name="membership_number" required>
            </div>

            <div class="form-group">
                <label for="password">Wachtwoord <span style="color: var(--error)">*</span></label>
                <input type="password" id="password" name="password" required>
            </div>

            <div class="form-group">
                <label for="password_confirm">Bevestig Wachtwoord <span style="color: var(--error)">*</span></label>
                <input type="password" id="password_confirm" name="password_confirm" required>
            </div>

            <button type="submit" class="btn btn-primary">Registreren</button>

            <p class="form-footer">
                Heeft u al een account? <a href="/login">Log hier in</a>
            </p>
        </form>
    </div>
</div>