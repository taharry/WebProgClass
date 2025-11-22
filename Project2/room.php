<?php
require_once 'config.php';

$era = isset($_GET['era']) ? $_GET['era'] : 'present';
$valid_eras = ['past', 'present', 'future'];

if (!in_array($era, $valid_eras)) {
    $era = 'present';
}

$message = '';
$error = '';
$used_hint = false;

// Handle form submit (answer + hint)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $era = $_POST['era'];

    // Hint button
    if (isset($_POST['hint'])) {
        // reduce score for hint
        $_SESSION['game']['score'] -= 5;
        $used_hint = true;
    }

    // Answer submit
    if (isset($_POST['answer_submit'])) {
        $user_answer = trim($_POST['answer']);
        $correct = get_correct_answer($era);

        if (strcasecmp($user_answer, $correct) === 0) {
            $_SESSION['game'][$era . '_solved'] = true;
            $message = "Timeline stabilized! The {$era} has been resolved.";
        } else {
            $error = "Incorrect code. The paradox intensifies...";
            $_SESSION['game']['score'] -= 2;
        }
    }
}

$game = $_SESSION['game'];

// Simple text for each era – replace with your environmental story
function get_era_title($era) {
    switch ($era) {
        case 'past':    return 'The Past – Forgotten Vault Chamber';
        case 'present': return 'The Present – Control Room';
        case 'future':  return 'The Future – Quantum Lock Corridor';
        default:        return 'Unknown Era';
    }
}

function get_era_description($era) {
    switch ($era) {
        case 'past':
            return 'Ancient gears and dusty relics surround you. Inscriptions hint at a code that was once used to seal the vault.';
        case 'present':
            return 'Screens flicker, alarms pulse. You must decode the current security override before time fractures.';
        case 'future':
            return 'The corridor hums with energy. A quantum lock reads a code that hasn’t technically existed yet.';
        default:
            return '';
    }
}
?>
<?php include 'header.php'; ?>

<section class="room-section era-<?php echo htmlspecialchars($era); ?>">
    <h2><?php echo get_era_title($era); ?></h2>
    <p class="room-description"><?php echo get_era_description($era); ?></p>

    <div class="room-status">
        <p><strong>Status:</strong>
            <?php echo $game[$era . '_solved'] ? 'Solved' : 'Unresolved'; ?>
        </p>
        <p><strong>Score:</strong> <?php echo $game['score']; ?></p>
    </div>

    <?php if ($message): ?>
        <div class="msg success"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if ($error): ?>
        <div class="msg error"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <!-- Puzzle Form -->
    <form action="room.php?era=<?php echo htmlspecialchars($era); ?>" method="post" class="puzzle-form">
        <input type="hidden" name="era" value="<?php echo htmlspecialchars($era); ?>">

        <label for="answer">Enter the temporal code:</label>
        <input type="text" id="answer" name="answer" required>

        <div class="button-row">
            <button type="submit" name="answer_submit" class="btn-primary">Submit Code</button>
            <button type="submit" name="hint" class="btn-ghost">Hint (-5)</button>
        </div>
    </form>

    <!-- Hint text placeholder (you can make it change based on $used_hint) -->
    <?php if ($used_hint): ?>
        <div class="hint-box">
            <p><strong>Hint:</strong> Replace this text with a real hint for the <?php echo htmlspecialchars($era); ?> puzzle.</p>
        </div>
    <?php endif; ?>

    <a href="hub.php" class="back-link">Return to Temporal Hub</a>
</section>

<?php include 'footer.php'; ?>
