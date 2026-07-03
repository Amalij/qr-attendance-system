# QR Attendance System

A modern, full-stack attendance management system that leverages QR code technology for quick and reliable student attendance tracking. Built with Laravel, Vue.js, and Tailwind CSS for a seamless user experience.

## 🎯 Features

- **QR Code Scanning**: Students can quickly mark attendance by scanning dynamically generated QR codes
- **Role-Based Access Control**: Separate dashboards and features for admins, lecturers, and students
- **Course Management**: Organize courses, assign students, and track attendance by session
- **Session Management**: Lecturers can create and manage class sessions with unique QR codes
- **Attendance Reports**: Comprehensive analytics and reporting for administrators and lecturers
- **Real-time Synchronization**: Instant QR code validation and attendance marking
- **Database Integration**: Dual backend support with Laravel (PHP) and Node.js (Express)

## 🛠️ Tech Stack

### Backend
- **PHP 8.2+** with **Laravel 12** - Web framework and API
- **Node.js + Express** - Real-time attendance API server
- **MySQL 8.0+** - Primary database
- **sqlite** - Development/testing support

### Frontend
- **Blade Templating** (71.8% of codebase) - Server-side views
- **Tailwind CSS 4** - Utility-first CSS framework
- **Vite** - Lightning-fast build tool
- **Axios** - HTTP client

### Key Dependencies
- `laravel/framework` ^12.0 - Core framework
- `simplesoftwareio/simple-qrcode` ^4.2 - QR code generation
- `intervention/image` ^3.11 - Image processing
- `mysql2` - MySQL database driver
- `express` ^5.1.0 - REST API server

## 📁 Project Structure

```
qr-attendance-system/
├── app/
│   ├── Http/
│   │   ├── Controllers/     # Request handlers: Admin, Lecturer, Student, Auth, QR
│   │   ├── Middleware/      # Custom middleware (authentication, roles)
│   │   └── Kernel.php       # HTTP middleware stack
│   ├── Models/              # Eloquent models (Attendance, User, Course, Session)
│   └── Providers/           # Service providers
├── routes/
│   ├── web.php              # Web routes (auth, dashboards, QR scanning)
│   ├── api.php              # API routes (attendance endpoints)
│   └── console.php          # Artisan commands
├── resources/
│   ├── views/               # Blade templates
│   │   ├── auth/            # Login, registration
│   │   ├── admin/           # Admin dashboard & management
│   │   ├── lecturer/        # Lecturer dashboard & session management
│   │   ├── student/         # Student dashboard & QR scanner
│   │   └── layouts/         # Master layouts
│   ├── css/                 # Tailwind CSS files
│   └── js/                  # JavaScript components
├── database/
│   ├── migrations/          # Schema definitions
│   ├── factories/           # Test data factories
│   └── seeders/             # Database seeders
├── config/                  # Configuration files
├── storage/                 # Logs, uploads, caches
├── server.js                # Node.js Express backend (alternative)
├── composer.json            # PHP dependencies
├── package.json             # Node.js dependencies
├── vite.config.js           # Vite build configuration
├── phpunit.xml              # PHPUnit testing configuration
└── qr_attendance.sql        # Database schema & test data
```

### How It Fits Together

1. **Authentication Flow**: Users log in via the centralized login route (`/login`), authenticated by Laravel
2. **Dashboard Access**: Authenticated users are redirected to role-specific dashboards (admin, lecturer, or student)
3. **QR Code Generation**: Lecturers create sessions which generate unique QR tokens
4. **Attendance Marking**: Students scan QR codes via the student dashboard, triggering:
   - Token validation against `qr_codes` table
   - Attendance record insertion into `attendance` table
   - Token marked as used to prevent duplicate scans
5. **Reporting**: Admins and lecturers can view attendance analytics and generate reports

## 🚀 Getting Started

### Prerequisites
- PHP 8.2 or higher
- Node.js 18+ and npm
- MySQL 8.0 or higher
- Composer

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/Amalij/qr-attendance-system.git
   cd qr-attendance-system
   ```

2. **Run the automated setup** (recommended)
   ```bash
   composer setup
   ```
   
   Or **manual setup**:
   ```bash
   # Install PHP dependencies
   composer install
   
   # Copy environment configuration
   cp .env.example .env
   
   # Generate application key
   php artisan key:generate
   
   # Run database migrations
   php artisan migrate --force
   
   # Install Node.js dependencies
   npm install
   
   # Build frontend assets
   npm run build
   ```

3. **Set up the MySQL database** (if not using migrations)
   ```bash
   mysql -u root -p < qr_attendance.sql
   ```

### Running the Application

**Development Mode** (runs all services concurrently):
```bash
composer dev
```

This command starts:
- Laravel development server (port 8000)
- Queue listener
- Log viewer (Pail)
- Vite dev server (with HMR)

**Individual Servers**:
```bash
# Laravel server
php artisan serve

# Node.js Express backend (alternative)
node server.js

# Frontend build watcher
npm run dev

# Queue processor
php artisan queue:listen --tries=1
```

### Testing

Run the test suite:
```bash
composer test
```

Or directly with PHPUnit:
```bash
php artisan test
```

## 📊 Database Schema

### Key Tables

**qr_codes**
- Stores generated QR code tokens
- Tracks usage status (`is_used` flag)
- Links to students

**attendance**
- Records each attendance marking
- Stores student ID, QR token, and scan timestamp
- Enables attendance history and reporting

**users**
- Stores user accounts with roles (admin, lecturer, student)

**courses**
- Course information managed by admins
- Links to lecturers and students

**sessions**
- Class sessions created by lecturers
- Contains unique `attendance_token` for QR generation

## 🔐 Authentication & Authorization

- **Auth Controller** handles login/logout and session management
- Middleware protects routes by role (admin, lecturer, student)
- Session-based authentication with database session driver

## 🎨 Frontend

The UI uses **Blade templates** with **Tailwind CSS** for responsive design:
- **Admin Dashboard**: Student/lecturer management, course setup, attendance reports
- **Lecturer Dashboard**: Session creation, QR generation, attendance tracking
- **Student Dashboard**: View enrolled courses, scan QR codes, check attendance records
- **QR Scanner**: Real-time camera integration for QR scanning

## 📱 QR Scanning Workflow

1. Lecturer initiates a class session and generates a QR code
2. Students navigate to the scanner page
3. Camera captures the QR code
4. Token is validated on the backend
5. Attendance is recorded with timestamp
6. QR code is marked as used (prevents duplicate scans)
7. Success confirmation displayed to student

## 🛠️ API Endpoints

### Attendance Routes
- `POST /attendance/scan/{token}` - Mark attendance via QR token
- `GET /attendance/scan/{qrCode}` - QR scanner view

### Admin Routes
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/students` - Student list
- `GET /admin/lecturers` - Lecturer list
- `GET /admin/courses` - Course management
- `GET /admin/reports/attendance` - Attendance reports

### Lecturer Routes
- `GET /lecturer/dashboard` - Lecturer dashboard
- `GET /lecturer/courses` - Course list
- `POST /lecturer/courses/{course}/sessions` - Create session
- `GET /lecturer/reports/attendance` - Attendance reports

### Student Routes
- `GET /student/dashboard` - Student dashboard
- `GET /student/courses` - Enrolled courses
- `GET /student/scan` - QR scanner interface
- `POST /student/process-qr` - Process scanned QR code
- `GET /student/attendance` - Attendance records

## 🐛 Troubleshooting

### Database Connection Issues
Check `.env` file database configuration:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=attendance_system
DB_USERNAME=root
DB_PASSWORD=
```

### QR Scanning Not Working
- Verify table `qr_codes` exists: `/check-tables`
- Test database connection: `/test-attendance`
- Check token validity and usage status

### CORS Issues (Node.js Server)
The Express server expects requests from `http://127.0.0.1:8000`:
```javascript
app.use(cors({
    origin: "http://127.0.0.1:8000",
    credentials: true
}));
```

## 📝 Development Notes

- **Logging**: Check `/storage/logs/laravel.log` for server errors
- **Queue System**: Uses database queue driver for background jobs
- **Sessions**: Database-driven sessions for reliable state management
- **Migrations**: Use Laravel migrations for schema changes

## 📄 License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## 📞 Support

For issues or questions, please open an issue on GitHub or contact the project maintainer.

---

**Created**: February 2026  
**Repository**: [Amalij/qr-attendance-system](https://github.com/Amalij/qr-attendance-system)
