# Elite Estates – PHP + MySQL Web App

Short real-estate listing system demonstrating CRUD, authentication, search, and secure coding with PHP + MySQL.

# Login credentials
- Demo account 

  - Username: `sahilshrestha8551@gmail.com`  
  - Password: `999999`

- Username: `sahilshrestha777@gmail.com`  
  - Password: `999999`


- Or register a new account via the Register page (`/auth/register.php`) and use those credentials to log in.

#Setup instructions
- 1. Database
  - Create a MySQL database named `realestate`.
  - Import `database.sql` into that database (this creates `users` and `properties` tables).
- 2. Configuration
  - Update `config/db.php` with your MySQL username/password if they differ from the defaults.
- 3. Run the site
  - Place the project folder in your web server’s document root.  
  - Access `public/index.php` through the browser.

 #Features implemented
- Authentication: User registration, login, logout with password hashing.
- CRUD for properties: Add, list, edit, and delete property records with optional image upload.
- Advanced search + Ajax: Filter by location, type, and price range; results load via Fetch API without page reload.
- Security: Prepared statements for all DB operations, escaped output with `htmlspecialchars`, and session-based access control.
- UI: Responsive Bootstrap 5 layout with a modern card-based property grid and filter sidebar.

