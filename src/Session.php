<?php

class Session {
    public static function start() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    public static function set($key, $value) {
        self::start();
        $_SESSION[$key] = $value;
    }
    
    public static function get($key, $default = null) {
        self::start();
        return $_SESSION[$key] ?? $default;
    }
    
    public static function has($key) {
        self::start();
        return isset($_SESSION[$key]);
    }
    
    public static function remove($key) {
        self::start();
        unset($_SESSION[$key]);
    }
    
    public static function destroy() {
        self::start();
        session_destroy();
        $_SESSION = [];
    }
    
    public static function isAuthenticated() {
        return self::has('ticketapp_session') && self::has('user');
    }
    
    public static function requireAuth() {
        if (!self::isAuthenticated()) {
            header('Location: /login');
            exit;
        }
    }
    
    public static function setFlash($type, $message) {
        self::set('flash', ['type' => $type, 'message' => $message]);
    }
    
    public static function getFlash() {
        $flash = self::get('flash');
        self::remove('flash');
        return $flash;
    }
}
