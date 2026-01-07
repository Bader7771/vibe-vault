# Vibe Vault

A minimal Pinterest-like web application built with PHP and MySQL, focusing on core functionality for sharing and discovering images.

## Features

- User authentication (register, login, logout)
- Image upload with title and description
- Responsive grid layout for browsing images
- Individual image view pages
- Secure file uploads and database interactions
- Mobile-friendly design

## Requirements

- PHP 7.4 or higher
- MySQL 5.7 or higher
- Web server (Apache/Nginx) with mod_rewrite enabled
- Composer (for development)

## Installation

1. Clone the repository to your web server's document root:
   ```bash
   git clone https://github.com/yourusername/vibe-vault.git
   cd vibe-vault
   ```

2. Import the database schema:
   ```bash
   mysql -u your_username -p vibe_vault < database.sql
   ```
   Or use phpMyAdmin to import the `database.sql` file.

3. Configure the database connection in `config/db.php`:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'your_username');
   define('DB_PASS', 'your_password');
   define('DB_NAME', 'vibe_vault');
   ```

4. Make sure the `uploads` directory is writable by the web server:
   ```bash
   chmod -R 755 uploads/
   chown -R www-data:www-data uploads/  # For Apache
   ```

5. Access the application in your web browser:
   ```
   http://localhost/vibe-vault
   ```

## Usage

1. Register a new account or log in with existing credentials
2. Click "Upload Vibe" to share a new image
3. Add a title and optional description
4. Browse the feed to see all shared vibes
5. Click on any vibe to view it in detail

## Security

- Passwords are hashed using PHP's `password_hash()`
- Prepared statements are used for all database queries
- File uploads are validated for type and size
- Session management with proper security headers

## Contributing

1. Fork the repository
2. Create a new branch for your feature
3. Commit your changes
4. Push to the branch
5. Create a new Pull Request

## License

This project is open-source and available under the MIT License.
