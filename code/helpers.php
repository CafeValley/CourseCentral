<?php
/**
 * Helper Functions for CourseCentral System
 * Add this file to config.php: require_once "helpers.php";
 */

/**
 * Safely get POST/GET values with validation
 * 
 * @param string $key The array key to retrieve
 * @param mixed $default Default value if key doesn't exist
 * @param string $type Type validation: 'string', 'int', 'float', 'email'
 * @return mixed Sanitized value
 */
function safe_get($key, $default = '', $type = 'string') {
    // Check POST first, then GET
    $value = $_POST[$key] ?? $_GET[$key] ?? $default;
    
    if ($value === $default && $value !== '') {
        return $value;
    }
    
    // Type validation and sanitization
    switch ($type) {
        case 'int':
            return filter_var($value, FILTER_VALIDATE_INT) !== false ? (int)$value : $default;
        
        case 'float':
            return filter_var($value, FILTER_VALIDATE_FLOAT) !== false ? (float)$value : $default;
        
        case 'email':
            return filter_var($value, FILTER_VALIDATE_EMAIL) !== false ? $value : $default;
        
        case 'string':
        default:
            // Basic XSS protection - HTML escape
            return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
    }
}

/**
 * Execute prepared statement safely
 * 
 * @param mysqli $link Database connection
 * @param string $sql SQL query with ? placeholders
 * @param string $types Parameter types (s=string, i=int, d=double, b=blob)
 * @param mixed ...$params Parameters to bind
 * @return mysqli_result|false Query result or false on failure
 */
function safe_query($link, $sql, $types = '', ...$params) {
    $stmt = $link->prepare($sql);
    if (!$stmt) {
        error_log("Prepare failed: " . $link->error);
        return false;
    }
    
    if (!empty($types) && !empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    if (!$stmt->execute()) {
        error_log("Execute failed: " . $stmt->error);
        $stmt->close();
        return false;
    }
    
    $result = $stmt->get_result();
    $stmt->close();
    return $result;
}

/**
 * Hash password securely
 * 
 * @param string $password Plain text password
 * @return string Hashed password
 */
function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

/**
 * Verify password against hash
 * 
 * @param string $password Plain text password
 * @param string $hash Stored password hash
 * @return bool True if password matches
 */
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

/**
 * Sanitize output for HTML display (XSS protection)
 * 
 * @param string $string String to escape
 * @return string Escaped string
 */
function escape_html($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Check if user is logged in
 * 
 * @return bool True if logged in
 */
function is_logged_in() {
    return isset($_SESSION['suser_name']) && !empty($_SESSION['suser_name']);
}

/**
 * Redirect with message
 * 
 * @param string $url Target URL
 * @param string $message Optional message to pass via GET
 */
function redirect($url, $message = '') {
    if (!empty($message)) {
        $url .= (strpos($url, '?') !== false ? '&' : '?') . 'msg=' . urlencode($message);
    }
    header("Location: $url");
    exit();
}

/**
 * Generate CSRF token
 * 
 * @return string CSRF token
 */
function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Verify CSRF token
 * 
 * @param string $token Token to verify
 * @return bool True if valid
 */
function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Log error securely (doesn't expose to users)
 * 
 * @param string $message Error message
 * @param string $file Optional file name
 * @param int $line Optional line number
 */
function log_error($message, $file = '', $line = 0) {
    $log_message = date('Y-m-d H:i:s') . " - ";
    if (!empty($file)) {
        $log_message .= basename($file);
        if ($line > 0) {
            $log_message .= ":$line";
        }
        $log_message .= " - ";
    }
    $log_message .= $message . "\n";
    
    error_log($log_message, 3, __DIR__ . '/error.log');
}

/**
 * Validate required POST fields
 * 
 * @param array $fields Array of required field names
 * @return array ['valid' => bool, 'missing' => array]
 */
function validate_required($fields) {
    $missing = [];
    foreach ($fields as $field) {
        if (!isset($_POST[$field]) || empty($_POST[$field])) {
            $missing[] = $field;
        }
    }
    return [
        'valid' => empty($missing),
        'missing' => $missing
    ];
}

