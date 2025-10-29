<?php
// Load dependencies
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/src/Router.php';
require_once __DIR__ . '/src/Session.php';
require_once __DIR__ . '/src/TicketManager.php';

// Start session
Session::start();

// Setup Twig
$loader = new \Twig\Loader\FilesystemLoader(__DIR__ . '/templates');
$twig = new \Twig\Environment($loader, [
    'cache' => false,
    'debug' => true,
]);

// Add global variables
$twig->addGlobal('session', [
    'isAuthenticated' => Session::isAuthenticated(),
    'user' => Session::get('user'),
    'flash' => Session::getFlash()
]);

// Initialize services
$router = new Router($twig);
$ticketManager = new TicketManager();

// Routes

// Landing Page
$router->get('/', function() use ($twig) {
    echo $twig->render('landing.twig');
});

// Login Page
$router->get('/login', function() use ($twig) {
    if (Session::isAuthenticated()) {
        header('Location: /dashboard');
        exit;
    }
    echo $twig->render('auth/login.twig');
});

$router->post('/login', function() use ($twig) {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Simple authentication (demo users)
    $users = [
        ['email' => 'admin@ticketapp.com', 'password' => 'admin123', 'name' => 'Admin User'],
        ['email' => 'user@ticketapp.com', 'password' => 'user123', 'name' => 'Demo User']
    ];
    
    $authenticated = false;
    foreach ($users as $user) {
        if ($user['email'] === $email && $user['password'] === $password) {
            $token = bin2hex(random_bytes(32));
            Session::set('ticketapp_session', $token);
            Session::set('user', [
                'email' => $user['email'],
                'name' => $user['name']
            ]);
            $authenticated = true;
            break;
        }
    }
    
    if ($authenticated) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'redirect' => '/dashboard']);
    } else {
        header('Content-Type: application/json');
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'errors' => ['Invalid email or password. Please try again.']
        ]);
    }
});

// Signup Page
$router->get('/signup', function() use ($twig) {
    if (Session::isAuthenticated()) {
        header('Location: /dashboard');
        exit;
    }
    echo $twig->render('auth/signup.twig');
});

$router->post('/signup', function() use ($twig) {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    $errors = [];
    
    if (empty($name)) {
        $errors['name'] = 'Name is required';
    }
    
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password must be at least 6 characters';
    }
    
    if ($password !== $confirmPassword) {
        $errors['confirm_password'] = 'Passwords do not match';
    }
    
    if (empty($errors)) {
        // Create account (in production, save to database)
        $token = bin2hex(random_bytes(32));
        Session::set('ticketapp_session', $token);
        Session::set('user', [
            'email' => $email,
            'name' => $name
        ]);
        
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'redirect' => '/dashboard']);
    } else {
        header('Content-Type: application/json');
        http_response_code(400);
        echo json_encode(['success' => false, 'errors' => $errors]);
    }
});

// Logout
$router->get('/logout', function() {
    Session::destroy();
    header('Location: /');
    exit;
});

// Dashboard
$router->get('/dashboard', function() use ($twig, $ticketManager) {
    Session::requireAuth();
    
    $stats = $ticketManager->getStats();
    echo $twig->render('dashboard.twig', [
        'stats' => $stats
    ]);
});

// Tickets Page
$router->get('/tickets', function() use ($twig, $ticketManager) {
    Session::requireAuth();
    
    $tickets = $ticketManager->getAll();
    echo $twig->render('tickets/list.twig', [
        'tickets' => $tickets
    ]);
});

// Create Ticket Page
$router->get('/tickets/create', function() use ($twig) {
    Session::requireAuth();
    echo $twig->render('tickets/create.twig');
});

// Create Ticket (POST)
$router->post('/tickets/create', function() use ($ticketManager) {
    Session::requireAuth();
    
    $data = [
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'status' => $_POST['status'] ?? 'open',
        'priority' => $_POST['priority'] ?? 'medium',
    ];
    
    $result = $ticketManager->create($data);
    
    header('Content-Type: application/json');
    if ($result['success']) {
        echo json_encode(['success' => true, 'redirect' => '/tickets']);
    } else {
        http_response_code(400);
        echo json_encode($result);
    }
});

// Edit Ticket Page
$router->get('/tickets/{id}/edit', function($id) use ($twig, $ticketManager) {
    Session::requireAuth();
    
    $ticket = $ticketManager->getById($id);
    if (!$ticket) {
        http_response_code(404);
        echo $twig->render('404.twig');
        return;
    }
    
    echo $twig->render('tickets/edit.twig', ['ticket' => $ticket]);
});

// Update Ticket (POST)
$router->post('/tickets/{id}/update', function($id) use ($ticketManager) {
    Session::requireAuth();
    
    $data = [
        'title' => $_POST['title'] ?? '',
        'description' => $_POST['description'] ?? '',
        'status' => $_POST['status'] ?? 'open',
        'priority' => $_POST['priority'] ?? 'medium',
    ];
    
    $result = $ticketManager->update($id, $data);
    
    header('Content-Type: application/json');
    if ($result['success']) {
        echo json_encode(['success' => true, 'redirect' => '/tickets']);
    } else {
        http_response_code(400);
        echo json_encode($result);
    }
});

// Delete Ticket (POST)
$router->post('/tickets/{id}/delete', function($id) use ($ticketManager) {
    Session::requireAuth();
    
    $result = $ticketManager->delete($id);
    
    header('Content-Type: application/json');
    if ($result['success']) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(400);
        echo json_encode($result);
    }
});

// API Routes for AJAX
$router->get('/api/tickets', function() use ($ticketManager) {
    Session::requireAuth();
    header('Content-Type: application/json');
    echo json_encode($ticketManager->getAll());
});

$router->get('/api/stats', function() use ($ticketManager) {
    Session::requireAuth();
    header('Content-Type: application/json');
    echo json_encode($ticketManager->getStats());
});

// Run the router
$router->run();
