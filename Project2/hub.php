<?php
require_once 'config.php';
$game = $_SESSION['game'];
?>
<?php include 'header.php'; ?>

<section class="hub-section">
    <h2>Temporal Hub</h2>
    <p>Select a time period to enter. Solving puzzles in one era may change another.</p>

    <div class="timeline">
        <!-- Present -->
        <form action="room.php" method="get" class="timeline-card">
            <input type="hidden" name="era" value="present">
            <h3>Present</h3>
            <p>Status: <?php echo $game['present_solved'] ? 'Solved' : 'Locked'; ?></p>
            <button type="submit" class="btn-secondary">Enter Present</button>
        </form>

        <!-- Past -->
        <form action="room.php" method="get" class="timeline-card">
            <input type="hidden" name="era" value="past">
            <h3>Past</h3>
            <p>Status: <?php echo $game['past_solved'] ? 'Solved' : 'Locked'; ?></p>
            <button type="submit" class="btn-secondary">Enter Past</button>
        </form>

        <!-- Future -->
        <form action="room.php" method="get" class="timeline-card">
            <input type="hidden" name="era" value="future">
            <h3>Future</h3>
            <p>Status: <?php echo $game['future_solved'] ? 'Solved' : 'Locked'; ?></p>
            <?php
            // Example “paradox dependency”: only allow entering Future after Past OR Present solved
            $future_allowed = $game['past_solved'] || $game['present_solved'];
            ?>
            <button type="submit" class="btn-secondary" <?php if (!$future_allowed) echo 'disabled'; ?>>
                Enter Future
            </button>
            <?php if (!$future_allowed): ?>
                <p class="hint-text small">
                    A paradox blocks this route. Solve the Past or Present first.
                </p>
            <?php endif; ?>
        </form>
    </div>

    <div class="score-box">
        <p><strong>Current Score:</strong> <?php echo $game['score']; ?></p>
    </div>

    <?php if (all_rooms_solved()): ?>
        <form action="final.php" method="post" class="final-form">
            <button type="submit" class="btn-primary">Unlock the Vault</button>
        </form>
    <?php endif; ?>
</section>

<?php include 'footer.php'; ?>
