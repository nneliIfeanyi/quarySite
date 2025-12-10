<?php

/**
 * Flash Message Helper Functions
 * Stores messages in the session for display after redirects
 */

/**
 * Set a flash message
 * @param string $key The message key/type (e.g., 'success', 'error', 'warning', 'info')
 * @param string|array $message The message(s) to display
 */
function setFlash($key, $message)
{
    if (!isset($_SESSION['flash'])) {
        $_SESSION['flash'] = [];
    }

    if (is_array($message)) {
        $_SESSION['flash'][$key] = $message;
    } else {
        $_SESSION['flash'][$key] = [$message];
    }
}

/**
 * Get all flash messages of a specific type
 * @param string $key The message key/type
 * @param bool $delete Whether to delete the message after retrieving it
 * @return array The messages
 */
function getFlash($key, $delete = true)
{
    if (!isset($_SESSION['flash'][$key])) {
        return [];
    }

    $messages = $_SESSION['flash'][$key];

    if ($delete) {
        unset($_SESSION['flash'][$key]);
    }

    return $messages;
}

/**
 * Check if flash messages exist for a specific type
 * @param string $key The message key/type
 * @return bool
 */
function hasFlash($key)
{
    return isset($_SESSION['flash'][$key]) && count($_SESSION['flash'][$key]) > 0;
}

/**
 * Display flash messages as Bootstrap alerts
 * @param string $key The message key/type
 * @param string $alertClass Bootstrap alert class (e.g., 'alert-success', 'alert-danger')
 * @param bool $delete Whether to delete the message after displaying it
 */
function displayFlash($key, $alertClass = 'alert-info', $delete = true)
{
    $messages = getFlash($key, $delete);

    if (empty($messages)) {
        return;
    }

    foreach ($messages as $message) {
        echo '<div class="alert ' . htmlspecialchars($alertClass) . ' alert-dismissible fade show" role="alert">';
        echo htmlspecialchars($message);
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
    }
}

/**
 * Display all flash messages
 * Maps message types to Bootstrap alert classes
 */
function displayAllFlashes()
{
    $typeMap = [
        'success' => 'alert-success',
        'error' => 'alert-danger',
        'danger' => 'alert-danger',
        'warning' => 'alert-warning',
        'info' => 'alert-info'
    ];

    if (!isset($_SESSION['flash'])) {
        return;
    }

    foreach ($typeMap as $type => $alertClass) {
        if (hasFlash($type)) {
            displayFlash($type, $alertClass);
        }
    }
}
