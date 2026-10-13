<?php
/**
 * Birla Precision Technologies - Enquiry Submission Handler
 * Procedural PHP with prepared statements, CSRF verification, and server-side validation
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/includes/data.php';

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method Not Allowed']);
    exit;
}

// 1. CSRF Verification
$submitted_token = $_POST['csrf_token'] ?? '';
$saved_token = $_SESSION['csrf_token'] ?? '';

// If empty submitted token or mismatch
if (empty($saved_token) || !hash_equals($saved_token, $submitted_token)) {
    session_write_close();
    http_response_code(403);
    echo json_encode([
        'status' => 'error',
        'message' => 'Security validation (CSRF) failed. Please refresh the page and try again.'
    ]);
    exit;
}

// Rotate CSRF token and close session early to release lock
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$new_csrf_token = $_SESSION['csrf_token'];
session_write_close();

// 2. Extract and Sanitize Inputs
$customer_name = trim($_POST['customer_name'] ?? filter_input(INPUT_POST, 'customer_name', FILTER_DEFAULT) ?? '');
$company_name  = trim($_POST['company_name'] ?? filter_input(INPUT_POST, 'company_name', FILTER_DEFAULT) ?? '');
$email         = trim($_POST['email'] ?? filter_input(INPUT_POST, 'email', FILTER_DEFAULT) ?? '');
$phone         = trim($_POST['phone'] ?? filter_input(INPUT_POST, 'phone', FILTER_DEFAULT) ?? '');
$address       = trim($_POST['address'] ?? filter_input(INPUT_POST, 'address', FILTER_DEFAULT) ?? '');
$metric_dia    = trim($_POST['metric_dia'] ?? filter_input(INPUT_POST, 'metric_dia', FILTER_DEFAULT) ?? '');
$inch_equiv    = trim($_POST['inch_equiv'] ?? filter_input(INPUT_POST, 'inch_equiv', FILTER_DEFAULT) ?? '');
$gauge_number  = trim($_POST['gauge_number'] ?? filter_input(INPUT_POST, 'gauge_number', FILTER_DEFAULT) ?? '');
$variant_name  = trim($_POST['variant_name'] ?? filter_input(INPUT_POST, 'variant_name', FILTER_DEFAULT) ?? '');
$quantity_raw  = filter_var($_POST['quantity'] ?? filter_input(INPUT_POST, 'quantity', FILTER_DEFAULT), FILTER_VALIDATE_INT);
$price_basis   = trim($_POST['price_basis'] ?? filter_input(INPUT_POST, 'price_basis', FILTER_DEFAULT) ?? 'April 2026 Price List Per 10 Pcs');
$message       = trim($_POST['message'] ?? filter_input(INPUT_POST, 'message', FILTER_DEFAULT) ?? '');
$product_family= 'HSS Parallel Shank Twist Drills — Jobber Series';

// 3. Validation
$errors = [];

if (empty($customer_name) || mb_strlen($customer_name) < 2) {
    $errors['customer_name'] = 'Full Name is required (minimum 2 characters).';
}

if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = 'A valid email address is required.';
}

// Phone validation (digits, plus, hyphen, parentheses, min 7 digits)
$clean_phone = preg_replace('/[^\d]/', '', $phone);
if (empty($phone) || strlen($clean_phone) < 7 || strlen($clean_phone) > 15) {
    $errors['phone'] = 'A valid phone number is required (7 to 15 digits).';
}

if (empty($metric_dia)) {
    $errors['metric_dia'] = 'Please select a drill diameter specification.';
}

if (empty($variant_name)) {
    $errors['variant_name'] = 'Please select a drill variant (e.g. ITM STD., PANTHER, etc.).';
}

if ($quantity_raw === false || $quantity_raw === null || $quantity_raw <= 0) {
    $errors['quantity'] = 'Quantity must be a valid positive whole number.';
}

if (!empty($errors)) {
    http_response_code(422);
    echo json_encode([
        'status' => 'error',
        'message' => 'Please correct the validation errors below.',
        'errors' => $errors
    ]);
    exit;
}

// 4. Packaging status
$moq_status = 'Standard Packaging Order';

// 5. Generate Reference ID
$enquiry_ref = 'BPTL-' . date('Ymd') . '-' . strtoupper(substr(uniqid(), -6));
$ip_address = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

// 6. Database Storage with mysqli prepared statement
$db_saved = false;
$mysqli = get_db_connection();

// Combine address with message for robust DB storage
$db_message = ($address ? "Address: " . $address . ($message ? "\n\nRemarks: " . $message : "") : $message);

if ($mysqli) {
    $stmt = $mysqli->prepare("
        INSERT INTO enquiries 
        (enquiry_ref, product_family, metric_dia, inch_equiv, gauge_number, variant_name, quantity, price_basis, customer_name, company_name, email, phone, message, ip_address, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    
    if ($stmt) {
        $status = 'New';
        $stmt->bind_param(
            'ssssssissssssss',
            $enquiry_ref,
            $product_family,
            $metric_dia,
            $inch_equiv,
            $gauge_number,
            $variant_name,
            $quantity_raw,
            $price_basis,
            $customer_name,
            $company_name,
            $email,
            $phone,
            $db_message,
            $ip_address,
            $status
        );
        
        if ($stmt->execute()) {
            $db_saved = true;
        }
        $stmt->close();
    }
}

// Fallback audit log (ensures zero data loss even in offline mode)
$enquiry_record = [
    'enquiry_ref' => $enquiry_ref,
    'timestamp' => date('c'),
    'product_family' => $product_family,
    'metric_dia' => $metric_dia,
    'inch_equiv' => $inch_equiv,
    'gauge_number' => $gauge_number,
    'variant_name' => $variant_name,
    'quantity' => $quantity_raw,
    'moq_status' => $moq_status,
    'price_basis' => $price_basis,
    'customer_name' => $customer_name,
    'company_name' => $company_name,
    'email' => $email,
    'phone' => $phone,
    'address' => $address,
    'message' => $message,
    'ip_address' => $ip_address,
    'db_saved' => $db_saved
];

$log_file = __DIR__ . '/enquiries_log.json';
$existing = file_exists($log_file) ? json_decode(file_get_contents($log_file), true) : [];
if (!is_array($existing)) $existing = [];
$existing[] = $enquiry_record;
@file_put_contents($log_file, json_encode($existing, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

// 7. Successful Response
echo json_encode([
    'status' => 'success',
    'message' => 'Enquiry submitted successfully! A technical tooling specialist from Birla Precision will contact you with an official quotation.',
    'reference_number' => $enquiry_ref,
    'details' => [
        'customer' => htmlspecialchars($customer_name, ENT_QUOTES, 'UTF-8'),
        'company' => htmlspecialchars($company_name, ENT_QUOTES, 'UTF-8'),
        'product' => $product_family,
        'diameter' => $metric_dia . ' mm' . ($inch_equiv ? ' (' . $inch_equiv . '")' : ''),
        'variant' => htmlspecialchars($variant_name, ENT_QUOTES, 'UTF-8'),
        'quantity' => $quantity_raw . ' pcs',
        'moq_note' => $moq_status,
        'price_basis' => $price_basis,
        'new_csrf_token' => $new_csrf_token
    ]
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
