<?php
session_start();
require_once 'includes/connection.php';
/** @var mysqli $db */

$type = $_POST['type'];
$value = $_POST['value'];
$user_id = $_SESSION['user_id']; // Set this on login

$allowed = ['heart', 'brain', 'glucose', 'vital'];
if (in_array($type, $allowed)) {
    $stmt = $db->prepare("UPDATE permissions SET $type = ? WHERE user_id = ?");
    $stmt->bind_param('ii', $value, $user_id);
    $stmt->execute();
}
?>
