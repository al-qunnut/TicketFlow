# TicketFlow - Modern Ticket Management System (PHP + Twig)

A complete, production-ready ticket management system built with PHP and Twig templating engine. This application demonstrates full CRUD functionality, authentication, responsive design, and modern UI/UX practices.

## 🚀 Features

### Core Functionality
- ✅ **Landing Page** with wavy SVG background and decorative elements
- ✅ **Authentication System** (Login & Signup) with form validation
- ✅ **Dashboard** with real-time statistics
- ✅ **Complete CRUD Operations** for ticket management
- ✅ **Form Validation** with inline errors and toast notifications
- ✅ **Session Management** with protected routes
- ✅ **Responsive Design** (Mobile, Tablet, Desktop)
- ✅ **Accessibility Features** (ARIA labels, keyboard navigation, focus states)

### Design Requirements Met
- 🎨 Max-width: 1440px centered layout
- 🌊 Wavy SVG background in hero section
- ⭕ Decorative circles throughout the site
- 📦 Card-based boxes with shadows and rounded corners
- 🎯 Status-based color coding (Open: Green, In Progress: Amber, Closed: Gray)
- 📱 Fully responsive across all devices

## 🛠️ Tech Stack

- **Backend**: PHP 7.4+
- **Templating**: Twig 3.x
- **Dependency Management**: Composer
- **Session Handling**: PHP Sessions
- **Data Storage**: JSON file-based (easily upgradeable to database)
- **Styling**: Pure CSS with CSS Variables
- **JavaScript**: Vanilla JS (no frameworks)

## 📋 Prerequisites

- PHP 7.4 or higher
- Composer
- Web server (Apache/Nginx) or PHP built-in server

## 🔧 Installation & Setup

### 1. Clone or Download the Project

```bash
cd c:\Users\User\Desktop\HNG_TEST2\Twig
```

### 2. Install Dependencies

```bash
composer install
```

If dependencies are already installed, you can skip this step.

### 3. Set Proper Permissions

Ensure the `data` directory is writable:

```bash
# On Unix/Linux/Mac
chmod -R 777 data/

# On Windows (PowerShell)
icacls data /grant Users:F /T
```

### 4. Start the Development Server

#### Option A: PHP Built-in Server (Recommended for Development)

```bash
php -S localhost:8000
```

Then open your browser to: **http://localhost:8000**

#### Option B: Apache/Nginx

Configure your web server to point to the project directory and ensure mod_rewrite is enabled.

## 👤 Demo User Credentials

Use these credentials to test the authentication:

**Admin User:**
- Email: `admin@ticketapp.com`
- Password: `admin123`

**Regular User:**
- Email: `user@ticketapp.com`
- Password: `user123`

Or create your own account via the signup page!

## 📁 Project Structure

```
Twig/
├── index.php              # Main application entry point & routing
├── composer.json          # Composer dependencies
├── .htaccess             # Apache URL rewriting
├── src/
│   ├── Router.php        # Routing logic
│   ├── Session.php       # Session management & auth
│   └── TicketManager.php # CRUD operations for tickets
├── templates/
│   ├── layout.twig       # Base layout template
│   ├── landing.twig      # Landing page
│   ├── dashboard.twig    # Dashboard
│   ├── 404.twig         # 404 error page
│   ├── auth/
│   │   ├── login.twig   # Login page
│   │   └── signup.twig  # Signup page
│   ├── tickets/
│   │   ├── list.twig    # Ticket list
│   │   ├── create.twig  # Create ticket form
│   │   └── edit.twig    # Edit ticket form
│   └── partials/
│       ├── navbar.twig  # Navigation bar
│       └── footer.twig  # Footer
├── public/
│   ├── css/
│   │   └── styles.css   # All styling
│   └── js/
│       └── main.js      # Client-side JavaScript
└── data/
    └── tickets.json     # Ticket data storage
```

## 🎯 Usage Guide

### 1. Landing Page
- Visit the homepage to see the application overview
- Click "Get Started" to create an account
- Click "Login" if you already have an account

### 2. Authentication
- **Sign Up**: Create a new account with name, email, and password
- **Login**: Use existing credentials to access the dashboard
- **Validation**: All forms include real-time validation with helpful error messages

### 3. Dashboard
- View ticket statistics (Total, Open, In Progress, Resolved)
- Quick access to all ticket management features
- Logout functionality

### 4. Ticket Management

#### Create Ticket
- Click "Create Ticket" or "New Ticket"
- Fill in required fields:
  - **Title** (required, 3-200 characters)
  - **Status** (required: open, in_progress, closed)
  - Description (optional, max 1000 characters)
  - Priority (optional: low, medium, high)
- Submit the form to create the ticket

#### View Tickets
- See all tickets in a card-based layout
- Each ticket displays:
  - Title and description
  - Status badge (color-coded)
  - Priority badge
  - Created and updated timestamps
  - Edit and Delete buttons

#### Edit Ticket
- Click "Edit" on any ticket
- Modify any field
- Submit to update the ticket

#### Delete Ticket
- Click "Delete" on any ticket
- Confirm deletion in the modal
- Ticket is permanently removed

## 🎨 Design System

### Color Scheme
- **Primary**: #4F46E5 (Indigo)
- **Success/Open**: #10B981 (Green)
- **Warning/In Progress**: #F59E0B (Amber)
- **Danger/Closed**: #6B7280 (Gray)

### Status Colors
- **Open**: Green (#10B981)
- **In Progress**: Amber (#F59E0B)
- **Closed**: Gray (#6B7280)

### Layout
- **Max Width**: 1440px (centered on larger screens)
- **Responsive Breakpoints**: 768px (tablet), 480px (mobile)

## ♿ Accessibility Features

- Semantic HTML5 elements
- ARIA labels and roles
- Keyboard navigation support
- Focus visible states
- Sufficient color contrast (WCAG AA compliant)
- Screen reader friendly
- Skip to main content link

## 🔒 Security Features

- Session-based authentication
- Protected routes (Dashboard, Tickets require login)
- Form validation (client-side and server-side)
- XSS protection via Twig auto-escaping
- CSRF protection ready (can be implemented)

## ✅ Validation Rules

### Ticket Fields
- **Title**: Required, 3-200 characters
- **Status**: Required, must be one of: `open`, `in_progress`, `closed`
- **Description**: Optional, max 1000 characters
- **Priority**: Optional, must be one of: `low`, `medium`, `high`

### Authentication
- **Name**: Required (signup only)
- **Email**: Required, valid email format
- **Password**: Required, minimum 6 characters
- **Confirm Password**: Must match password (signup only)

## 📝 Error Handling

### Inline Errors
- Displayed beneath form fields
- Red border on invalid inputs
- Clear, actionable error messages

### Toast Notifications
- Success messages (green)
- Error messages (red)
- Warning messages (amber)
- Auto-dismiss after 4 seconds

### Authorization Errors
- Unauthorized access redirects to login
- Session expiry handling
- Clear error messages

## 🚀 Deployment

### Production Checklist
1. Enable Twig caching in `index.php`:
   ```php
   'cache' => __DIR__ . '/cache',
   ```
2. Create a `cache` directory and set permissions
3. Set secure session configuration
4. Use a real database instead of JSON files
5. Implement CSRF protection
6. Enable HTTPS
7. Set proper error reporting levels
8. Implement rate limiting for authentication

## 🧪 Testing

### Manual Testing
- Test all authentication flows (login, signup, logout)
- Create, read, update, delete tickets
- Test form validation with invalid data
- Test responsive design on different devices
- Test keyboard navigation
- Test with screen readers

### Test Scenarios
1. **Unauthorized Access**: Try accessing `/dashboard` without login
2. **Invalid Login**: Use wrong credentials
3. **Form Validation**: Submit empty forms
4. **Status Validation**: Try invalid status values
5. **Session Management**: Logout and try to access protected routes

## 🐛 Known Issues & Limitations

- Data is stored in JSON files (use a database for production)
- No email verification for signup
- No password reset functionality
- No real-time updates (requires WebSockets)
- Basic authentication (consider OAuth/JWT for production)

## 🔄 Future Enhancements

- [ ] Database integration (MySQL/PostgreSQL)
- [ ] Email notifications
- [ ] File attachments for tickets
- [ ] Comment system
- [ ] User roles and permissions
- [ ] Advanced search and filtering
- [ ] Export tickets (CSV, PDF)
- [ ] Dark mode
- [ ] Multi-language support

## 📚 API Endpoints

### Public Routes
- `GET /` - Landing page
- `GET /login` - Login page
- `POST /login` - Login submission
- `GET /signup` - Signup page
- `POST /signup` - Signup submission

### Protected Routes (Require Authentication)
- `GET /dashboard` - Dashboard
- `GET /tickets` - Ticket list
- `GET /tickets/create` - Create ticket form
- `POST /tickets/create` - Create ticket submission
- `GET /tickets/{id}/edit` - Edit ticket form
- `POST /tickets/{id}/update` - Update ticket submission
- `POST /tickets/{id}/delete` - Delete ticket
- `GET /logout` - Logout

### API Routes (JSON)
- `GET /api/tickets` - Get all tickets (JSON)
- `GET /api/stats` - Get ticket statistics (JSON)

## 🤝 Contributing

This is a demo project for HNG. Contributions are welcome!

## 📄 License

This project is open source and available under the MIT License.

## 👨‍💻 Developer Notes

### Extending the Application

#### Adding a New Field to Tickets
1. Update the form in `templates/tickets/create.twig` and `edit.twig`
2. Add validation in `src/TicketManager.php::validate()`
3. Update the data structure in `create()` and `update()` methods

#### Adding a New Route
1. Add route in `index.php` using `$router->get()` or `$router->post()`
2. Create corresponding Twig template
3. Add navigation link if needed

#### Customizing the Design
- All styles are in `public/css/styles.css`
- CSS variables for easy theme customization
- Responsive breakpoints defined in media queries

## 🎓 Learning Resources

- [Twig Documentation](https://twig.symfony.com/doc/)
- [PHP Manual](https://www.php.net/manual/)
- [Web Accessibility](https://www.w3.org/WAI/)

## 📞 Support

For issues or questions related to HNG Test:
- Review the code and documentation
- Check console for JavaScript errors
- Verify PHP error logs

---

**Built with ❤️ for HNG Test**

*TicketFlow - Making ticket management simple and efficient.*
