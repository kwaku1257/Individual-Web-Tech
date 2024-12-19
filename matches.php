
    <h3>Add New Match</h3>
    <form action="actions/add_match_action.php" method="POST">
        <label for="match_title">Match Title</label>
        <input type="text" id="match_title" name="match_title" placeholder="Match Title" required>
        
        <label for="match_location">Location</label>
        <input type="text" id="match_location" name="match_location" placeholder="Location" required>
        
        <label for="match_time">Match Time</label>
        <input type="datetime-local" id="match_time" name="match_time" required>
        
        <button type="submit" class="btn">Add Match</button>
    </form>

