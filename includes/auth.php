<?php
// ============================================================
// includes/auth.php — Session-based auth helpers
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function isLoggedIn(): bool {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function requireLogin(): void {
    if (!isLoggedIn()) {
        header('Location: ../pages/login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
        exit;
    }
}

function requireAdmin(): void {
    requireLogin();
    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: ../pages/catalogue.php');
        exit;
    }
}

function currentUser(): array {
    return [
        'id'       => $_SESSION['user_id']       ?? null,
        'username' => $_SESSION['user_username']  ?? '',
        'email'    => $_SESSION['user_email']     ?? '',
        'role'     => $_SESSION['user_role']      ?? 'utilisateur',
    ];
}

function loginUser(array $user): void {
    session_regenerate_id(true);
    $_SESSION['user_id']       = $user['id'];
    $_SESSION['user_username'] = $user['username'];
    $_SESSION['user_email']    = $user['email'];
    $_SESSION['user_role']     = $user['role'];
}

function logoutUser(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}

function flashSet(string $key, string $msg): void {
    $_SESSION['flash'][$key] = $msg;
}

function flashGet(string $key): ?string {
    $msg = $_SESSION['flash'][$key] ?? null;
    unset($_SESSION['flash'][$key]);
    return $msg;
}

function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfVerify(string $token): bool {
    return hash_equals($_SESSION['csrf_token'] ?? '', $token);
}
