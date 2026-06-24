# FanTrade 2026 - Project Structure

## Overview
FanTrade 2026 is a Football Fans Marketplace for FIFA World Cup 2026. This project has been refactored into separate frontend and backend files for better organization and security.

## Project Structure

```
FanTrade2026 HTML/
├── FanTrade2026.html       # Main HTML page (forms & product display)
├── FanTrade2026.js         # JavaScript (validation & API calls)
├── FanTrade2026.css        # Styling
└── backend/
    ├── config.php          # Database connection & configuration
    ├── register.php        # User registration endpoint
    ├── login.php           # User login endpoint
    ├── products.php        # Products management (fetch & add)
    └── setup.php           # Database setup script (run once)
```

## Setup Instructions

### 1. Database Setup
- Start your PHP server and XAMPP/WAMP
- Navigate to `http://localhost/FanTrade2026%20HTML/backend/setup.php`
- This will create the database and required tables automatically
- **Delete or move setup.php to a secure location after running it**

### 2. Update Database Credentials (Optional)
If your database uses different credentials, edit [backend/config.php](backend/config.php):
```php
define('DB_HOST', 'localhost');    // Your host
define('DB_USER', 'root');         // Your username
define('DB_PASSWORD', '');         // Your password
define('DB_NAME', 'fantrade2026'); // Your database name
```

### 3. Access the Application
- Open `http://localhost/FanTrade2026%20HTML/FanTrade2026.html`
- Register a user account
- Log in to access the full marketplace
- Add and view football products

## Security Improvements Made

✅ **Prepared Statements** - Prevents SQL injection  
✅ **Password Hashing** - Uses bcrypt (PASSWORD_BCRYPT)  
✅ **Input Validation** - Email format & field validation  
✅ **Duplicate Prevention** - Prevents duplicate email registration  
✅ **XSS Protection** - HTML escaping in JavaScript  
✅ **Session Management** - Secure session handling  

## Features

### User Management
- **Registration** - Create new user accounts with validation
- **Login** - Secure authentication with hashed passwords
- **Session** - User sessions stored server-side

### Product Management
- **Add Products** - Upload football merchandise/collectibles
- **Browse Products** - View all available products with prices
- **Buy Now** - Placeholder for checkout functionality

### Frontend
- Clean, responsive UI with CSS styling
- Real-time form validation
- AJAX requests for seamless interaction
- Error/success message display

## API Endpoints

### POST `/backend/register.php`
Register new user
```
Parameters: name, email, password
```

### POST `/backend/login.php`
User login
```
Parameters: email, password
```

### GET `/backend/products.php?action=fetch`
Fetch all products
```
Response: JSON with product list
```

### POST `/backend/products.php`
Add new product
```
Parameters: action=add, product_name, price, description
```

## Database Schema

### users table
```sql
id, name, email, password, role, created_at
```

### products table
```sql
id, product_name, price, description, created_at
```

### orders table (for future expansion)
```sql
id, user_id, product_id, quantity, total_price, status, created_at
```

## Troubleshooting

**Database Connection Failed?**
- Check if XAMPP/WAMP is running
- Verify database credentials in `config.php`
- Run `setup.php` again to create tables

**Forms Not Working?**
- Check browser console for JavaScript errors (F12)
- Verify backend PHP files are in the correct `backend/` folder
- Ensure PHP server is running

**Images Not Loading?**
- Add an `uploads/` folder for product images (future feature)

## Next Steps

1. Implement image upload for products
2. Add shopping cart functionality
3. Create checkout & payment integration
4. Add admin dashboard
5. Implement order tracking
6. Add email notifications

---

**Version:** 2.0 (Refactored)  
**Last Updated:** 2026-06-06
