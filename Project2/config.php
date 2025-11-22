<?php
// config.php
session_start();

// Initialize game state array if not set
if (!isset($_SESSION['game'])) {
    $_SESSION['game'] = [
        'present_solved' => false,
        'past_solved'    => false,
        'future_solved'  => false,
        'score'          => 100,    // starting score; hints can reduce this
    ];
}

// Simple helper: check if all rooms solved
function all_rooms_solved() {
    $g = $_SESSION['game'];
    return $g['present_solved'] && $g['past_solved'] && $g['future_solved'];
}

// Placeholder puzzle answers – change these to your real puzzles
function get_correct_answer($era) {
    switch ($era) {
        case 'present': return 'PRESENTCODE';
        case 'past':    return 'PASTRELIC';
        case 'future':  return 'FUTUREKEY';
        default:        return '';
    }
}
