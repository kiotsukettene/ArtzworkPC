# PC Components E-commerce Platform

A comprehensive e-commerce platform built specifically for PC components and computer hardware, featuring a custom PC builder tool, dual authentication system, and complete order management.

## 🚀 Features

### Customer Features
- **🏠 Product Browsing**: Browse products by categories with advanced filtering
- **🔧 PC Builder Tool**: Interactive tool to build custom PC configurations with component compatibility
- **🛒 Shopping Cart**: Full-featured cart with quantity management and item selection
- **❤️ Wishlist**: Save products for later purchase
- **⚖️ Product Comparison**: Compare multiple products side by side
- **📦 Order Management**: Track orders, view history, and download invoices
- **👤 User Authentication**: Secure registration, login, and email verification
- **📧 Email Verification**: Secure email verification system
- **📋 Customer Profile**: Manage personal information and addresses

### Admin Features
- **📊 Dashboard**: Comprehensive analytics and overview
- **📦 Product Management**: Create, edit, and manage products with specifications
- **🏷️ Category Management**: Organize products into categories
- **🏢 Brand Management**: Manage product brands
- **👥 Customer Management**: View customer details and order history
- **📋 Order Management**: Process orders and update status
- **👨‍💼 Employee Management**: Manage admin users and employees
- **💰 Transaction Tracking**: Monitor sales and revenue

### Technical Features
- **🔐 Dual Authentication**: Separate auth systems for customers and administrators
- **📱 Responsive Design**: Mobile-first design with Tailwind CSS
- **⚡ SPA Experience**: Seamless single-page application using Inertia.js
- **📊 Charts & Analytics**: Interactive charts using Chart.js
- **📄 PDF Generation**: Generate and download invoices
- **🎨 Modern UI**: Beautiful interface using Headless UI components
- **🔍 Search & Filter**: Advanced product search and filtering capabilities

## 🛠️ Technology Stack

### Backend
- **Laravel 11** - PHP Framework
- **PHP 8.2+** - Programming Language
- **MySQL/SQLite** - Database
- **Laravel Sanctum** - API Authentication
- **DomPDF** - PDF Generation

### Frontend
- **Vue.js 3** - JavaScript Framework
- **Inertia.js** - Modern Monolith
- **Tailwind CSS** - Utility-first CSS Framework
- **Headless UI** - Unstyled UI Components
- **Chart.js** - Data Visualization
- **Lucide Icons** - Beautiful Icons
- **Vue Datepicker** - Date Selection

### Build Tools
- **Vite** - Fast Build Tool
- **PostCSS** - CSS Processing
- **Autoprefixer** - CSS Vendor Prefixes

## 📋 Requirements

- **PHP** >= 8.2
- **Node.js** >= 16.0
- **NPM** or **Yarn**
- **Composer** - PHP Dependency Manager
- **MySQL** >= 8.0 or **SQLite** >= 3.35
- **Git** - Version Control

## ⚡ Quick Start

### 1. Clone the Repository
```bash
git clone <repository-url>
cd pc-components-ecommerce
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node.js Dependencies
```bash
npm install
```

### 4. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 5. Database Configuration
Edit `.env` file with your database credentials:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pc_store
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

For SQLite (simpler setup):
```env
DB_CONNECTION=sqlite
DB_DATABASE=/absolute/path/to/database/database.sqlite
```

### 6. Create Database
```bash
# For SQLite
touch database/database.sqlite

# For MySQL, create database manually in your MySQL client
```

### 7. Run Migrations
```bash
php artisan migrate
```

### 8. Seed Database (Optional)
```bash
php artisan db:seed
```

### 9. Build Assets
```bash
npm run build
```

### 10. Start Development Server
```bash
# Option 1: Laravel built-in server
php artisan serve

# Option 2: Full development environment with queue workers and hot reload
composer run dev

# Option 3: Manual setup (separate terminals)
php artisan serve           # Backend server
npm run dev                 # Frontend hot reload
php artisan queue:work       # Queue worker
```

The application will be available at `http://localhost:8000`

## 🔧 Development

### Frontend Development
```bash
# Start Vite development server with hot reload
npm run dev

# Build for production
npm run build
```

### Backend Development
```bash
# Run migrations
php artisan migrate

# Fresh migration with seeding
php artisan migrate:fresh --seed

# Generate model/controller/migration
php artisan make:model Product -mcr

# Clear caches
php artisan optimize:clear
```

### Queue Workers
The application uses queues for email sending and other background tasks:
```bash
# Start queue worker
php artisan queue:work

# Process failed jobs
php artisan queue:retry all
```

## 🗄️ Database Structure

### Core Tables
- **users** - Admin/Employee accounts
- **customers** - Customer accounts
- **customer_addresses** - Customer shipping addresses
- **categories** - Product categories
- **brands** - Product brands
- **products** - Product catalog
- **specifications** - Product specifications
- **product_specifications** - Product-specification relationships
- **cart_items** - Shopping cart items
- **wishlist_items** - Wishlist items
- **orders** - Customer orders
- **order_items** - Order line items

## 🔐 Authentication System

### Customer Authentication
- **Registration**: `/customer/register`
- **Login**: `/customer/login`
- **Email Verification**: Required for full account access
- **Profile Management**: `/customer/profile`

### Admin Authentication
- **Login**: `/admin/login`
- **Dashboard**: `/admin/dashboard`
- **Role-based Access**: Separate guard for admin users

## 🛣️ API Routes

### Customer Routes
- `GET /` - Homepage
- `GET /product-list` - Product listing
- `GET /category-products/{slug}` - Category products
- `GET /product-list/{slug}` - Product details
- `GET /pc-builder` - PC Builder tool
- `GET /cart` - Shopping cart
- `GET /customer/checkout` - Checkout process
- `GET /customer/my-orders` - Order history

### Admin Routes (Auth Required)
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/products` - Product management
- `GET /admin/categories` - Category management
- `GET /admin/brands` - Brand management
- `GET /admin/customers` - Customer management
- `GET /admin/orders` - Order management

## 🎨 Customization

### Styling
The application uses Tailwind CSS. Customize styles in:
- `tailwind.config.js` - Tailwind configuration
- `resources/css/app.css` - Global styles
- Component-specific styles within Vue files

### Components
Vue components are organized in:
- `resources/js/Components/` - Reusable components
- `resources/js/Pages/ClientSide/` - Customer pages
- `resources/js/Pages/AdminSide/` - Admin pages

## 📦 Deployment

### Production Build
```bash
# Install dependencies
composer install --optimize-autoloader --no-dev
npm ci

# Build assets
npm run build

# Optimize Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Environment Variables
Configure production environment variables:
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-domain.com

# Database
DB_CONNECTION=mysql
DB_HOST=your-host
DB_DATABASE=your-database
DB_USERNAME=your-username
DB_PASSWORD=your-password

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-email
MAIL_PASSWORD=your-password
```

## 🧪 Testing

```bash
# Run PHPUnit tests
php artisan test

# Run specific test
php artisan test --filter ProductTest

# Generate test coverage
php artisan test --coverage
```

## 🚀 Performance Optimization

### Caching
```bash
# Cache configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache views
php artisan view:cache

# Clear all caches
php artisan optimize:clear
```

### Database Optimization
- Use database indexing for frequently queried columns
- Implement eager loading for relationships
- Consider query optimization for large datasets

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📝 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🆘 Support

For support and questions:
- Create an issue in the repository
- Check the Laravel documentation: https://laravel.com/docs
- Vue.js documentation: https://vuejs.org/guide/
- Inertia.js documentation: https://inertiajs.com/

## 🔄 Changelog

See [CHANGELOG.md](CHANGELOG.md) for a list of changes and updates.

---

**Built with ❤️ using Laravel and Vue.js**
