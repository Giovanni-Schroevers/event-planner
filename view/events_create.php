<div class="form-wrapper">
    <h1>Nieuw Evenement Aanmaken</h1>

    <div class="form-container">
        <form action="/events/create" method="POST" class="form">
            <div class="form-group">
                <label for="name">Naam *</label>
                <input type="text" id="name" name="name" required class="form-control">
            </div>

            <div class="form-group">
                <label for="location">Locatie</label>
                <input type="text" id="location" name="location" class="form-control">
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="event_date">Datum & Tijd *</label>
                    <input type="datetime-local" id="event_date" name="event_date" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="registration_deadline">Deadline Inschrijving *</label>
                    <input type="datetime-local" id="registration_deadline" name="registration_deadline" required
                        class="form-control">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Prijs (€)</label>
                    <input type="number" id="price" name="price" step="0.01" min="0" value="0" class="form-control">
                </div>

                <div class="form-group">
                    <label for="max_participants">Max. Deelnemers</label>
                    <input type="number" id="max_participants" name="max_participants" min="1" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <label for="description">Beschrijving</label>
                <textarea id="description" name="description" rows="5" class="form-control"></textarea>
            </div>

            <div class="form-actions">
                <a href="/events" class="btn btn-secondary">Annuleren</a>
                <button type="submit" class="btn btn-primary">Evenement Aanmaken</button>
            </div>
        </form>
    </div>
</div>