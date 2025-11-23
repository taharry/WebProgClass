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

//Handle form submit (answer + hint)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $era = $_POST['era'];

    //Hint button
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

//Simple text for each era replace with  environmental story
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
            return 'You travel to the past  to find a source of the paradox. <br>The Time Machines doors open to reveal a cave covered in vivid paintings of the local wildlife. You must be in the prehistoric era!<br> The object causing the disturbance must be nearby...';
        case 'present':
            return 'Screens flicker, alarms pulse.<br> The time machine has become unstable due to a time paradox and threatans reality itsself!<br> You must decode the current security override before time fractures!';
        case 'future':
            return 'You have solved the paradox in the past, yet the timeline is still unstable. <br>You travel to the future just incase something from the past was misplaced there. <br>This lobby in a sleek futuristic office building looks promising!';
        default:
            return '';
    }
}

// changes hint depending on the era
function get_hint($era) {
    switch ($era) {
        case 'present': 
            return 'abc equals 123';
        case 'past':    
            return 'search for a device that does not belong';
        case 'future':  
            return 'what looks out of place here?';
        default:        return '';
    }
}
//gets source for image file depending on the room and era
function get_src($era) {
    switch ($era) {
        case 'present': 
            return 'present.png';
        case 'past':    
            return 'past.png';
        case 'future':  
            return 'future.png';
        default:        return '';
    }
}

?>


<?php include 'header.php'; ?>

<section class="room-section era-<?php echo htmlspecialchars($era); ?>">
    <h2><?php echo get_era_title($era); ?></h2>
    <p class="room-description"><?php echo get_era_description($era); ?></p>

    <div class= "location">
        <img src="<?php echo get_src($era) ?>" alt="">
    </div>

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

    <!-- Hint text placeholder -->
    <?php if ($used_hint): ?>
        <div class="hint-box">
            <p><strong>Hint:<?php echo get_hint($era); ?></strong> Replace this text with a real hint for the <?php echo htmlspecialchars($era); ?> puzzle.</p>
        </div>
    <?php endif; ?>

    <a href="hub.php" class="back-link">Return to Temporal Hub</a>
</section>

<?php include 'footer.php'; ?>

