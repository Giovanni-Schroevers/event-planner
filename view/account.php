<div class="form-wrapper">
    <h1>Mijn Account</h1>

    <div class="form-container">
        <form action="/account/update" method="POST" class="form">
            <div class="form-group">
                <label for="email">Email Adres *</label>
                <input type="email" disabled id="email" name="email" required class="form-control"
                    value="<?= htmlspecialchars($user->email); ?>">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="firstname">Voornaam *</label>
                    <input type="text" id="firstname" name="firstname" required class="form-control"
                        value="<?= htmlspecialchars($user->firstname); ?>">
                </div>

                <div class="form-group">
                    <label for="middle_name">Middelse naam</label>
                    <input type="text" id="middle_name name=" middle_name" class="form-control"
                        value="<?= htmlspecialchars($user->middleName ?? ''); ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="lastname">Achternaam *</label>
                <input type="text" id="lastname" name="lastname" required class="form-control"
                    value="<?= htmlspecialchars($user->lastname); ?>">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="phone">Telefoonnummer</label>
                    <input type="tel" id="phone" name="phone" class="form-control"
                        value="<?= htmlspecialchars($user->phone ?? ''); ?>">
                </div>

                <div class="form-group">
                    <label for="membership_number">Lidnummer</label>
                    <input type="text" disabled id="membership_number" name="membership_number" class="form-control"
                        value="<?= htmlspecialchars($user->membershipNumber ?? ''); ?>">
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Wijzigingen Opslaan</button>
            </div>
        </form>

        <hr>

        <div class="danger-zone">
            <h3>Account Verwijderen</h3>
            <p>Let op: Dit deactiveert je account en schrijft je direct uit voor alle toekomstige evenementen.</p>
            <form action="/account/delete" method="POST"
                onsubmit="return confirm('Dit kan niet ongedaan worden gemaakt en je wordt uitgeschreven voor alle toekomstige evenementen.');">
                <button type="submit" class="btn btn-danger">Account Verwijderen</button>
            </form>
        </div>
    </div>
</div>