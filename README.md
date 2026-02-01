 Drupal 10 Event Registration Module

A custom Drupal 10 module that allows administrators to configure events and users to register through a dynamic AJAX-based form with validations, email notifications, admin management, and CSV export.

 Features
Event Configuration (Admin)

Admins can configure events with:

Registration Start Date

Registration End Date

Event Date

Event Name

Event Category

Online Workshop

Hackathon

Conference

One-day Workshop

Event Registration Form (Users)

Users can register with:

Full Name

Email Address

College Name

Department

Category (AJAX dropdown)

Event Date (AJAX based on category)

Event Name (AJAX based on date & category)

Registration is allowed only between configured start and end dates.

Validations

Prevents duplicate registrations (Email + Event Date)

Email format validation

Text fields allow only letters

User-friendly error messages

🗄 Database Tables
event_config

| id | start_date | end_date | event_date | event_name | category |

event_registration

| id | full_name | email | college | department | event_date | event_name | category | created |

📧 Email Notifications

Confirmation email to user

Notification email to admin (configurable)

Email includes:

User Name

Event Date

Event Name

Category

Admin Features
Admin Listing Page

View all registrations

Filter by:

Event Date (AJAX)

Event Name (AJAX)

Shows total participants

Export all data as CSV

Accessible only with custom permission.

⚙ Configuration Page

Admin can:

Set admin notification email

Enable/disable admin email alerts

Built using Drupal Config API (no hard-coded values).

Installation Steps

Copy module to:

/modules/custom/event_registration


Enable module:

Admin → Extend → Enable Event Registration Module


Import database tables:

Open phpMyAdmin → select database → Import
Upload:

event_registration.sql


Clear cache:

Admin → Configuration → Performance → Clear cache

Important URLs
Feature	URL
Event Config Form	/admin/event-config
Registration Form	/event-register
Admin Registrations	/admin/event-registrations

(Adjust if routes differ in your setup)

Technologies Used

Drupal 10.x

PHP

MySQL

AJAX (Drupal Form API)

Drupal Mail API

Project Structure
event_registration/
 ├── src/
 │   ├── Form/
 │   └── Controller/
 ├── event_registration.info.yml
 ├── event_registration.routing.yml
 ├── event_registration.permissions.yml
 └── README.md

Highlights

✔ No contrib modules used
✔ Clean Drupal architecture
✔ AJAX dependent dropdowns
✔ Real-world validations
✔ Admin management tools
✔ CSV export

Author

Vyshnavi Ponapati
Custom Drupal 10 Module Project


