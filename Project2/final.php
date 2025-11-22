<?php
require_once 'config.php';

if (!all_rooms_solved()) {
    // Prevent direct access if puzzles not solved
    header('Location: hub.php');
    exit;
}

$final_score = $_SESSION['game']['score'];
?>
<?php include 'header.php'; ?>

<section class="final-section">
    <h2>The Vault Opens</h2>
    <p class="final-text">
        The timelines align, paradoxes resolve, and the vault door slowly swings open.
        You step through into stable reality.
    </p>

    <div class="vault-animation">
        <!-- Pure CSS animated door in styles.css -->
        <div class="vault-door"></div>
    </div>

    <p class="final-score">
        <strong>Final Score:</strong> <?php echo $final_score; ?>
    </p>

    <form action="index.php" method="post">
        <button type="submit" class="btn-secondary">Play Again</button>
    </form>
</section>

<?php include 'footer.php'; ?>
