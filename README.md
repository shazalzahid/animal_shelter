Furry Friends Animal Shelter – Project Overview
A small, full‑stack PHP/MySQL web app for managing an animal shelter, built to be easy to review and run locally.
Stack & Key Features
Tech stack
PHP (procedural, no framework) on Ampps/XAMPP
MySQL (animal_shelter DB)
Vanilla HTML/CSS (responsive layout, single shared stylesheet)
Public site
index.php – marketing homepage with hero, CTAs
animals.php – grid of adoptable animals
application.php → applicationsaved.php – adoption application flow
story.php, help.php – static content and contact details
Admin
Auth with hashed passwords (admin_users table)
admin/index.php – dashboard with basic metrics
admin/animals.php + add/edit screens – CRUD for animals
admin/applications.php – review and approve/reject applications
Images
Stored in MySQL (image_data LONGBLOB + image_mime), served via animal_image.php?id=…
Admin UI handles upload and replacement; public site never touches the filesystem directly.
Running Locally (Ampps / XAMPP)
Place files in the web root (e.g. /Applications/AMPPS/www).
Update config.php DB credentials if needed.
Hit setup_database.php in a browser to create tables:
http://localhost/setup_database.php
Optionally seed sample animals:
seed_animals.php → http://localhost/seed_animals.php
Visit:
Public: http://localhost/
Admin: http://localhost/admin/login.php (default admin / admin123, resettable via reset_admin.php).
What this project demonstrates
Basic auth, CRUD, and form handling without a framework.
DB‑backed file storage with proper MIME handling.
Separation of public vs. admin concerns and simple, consistent UI design.
Clean, employer‑friendly codebase that’s small enough to review in one sitting.
