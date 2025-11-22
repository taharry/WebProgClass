<?php
require_once 'config.php';
?>
<?php include 'header.php'; ?>

<section class="intro-section">
    <h2>Welcome to the Vault</h2>
    <p>
        You are trapped inside a time-locked vault.  
        To escape, you must travel between the <strong>Past</strong>, <strong>Present</strong>, and <strong>Future</strong>,
        solving paradoxical puzzles that affect each other across time.
    </p>

    <form action="hub.php" method="post">
        <button type="submit" class="btn-primary">Start Game</button>
    </form>
</section>

<?php include 'footer.php'; ?>
