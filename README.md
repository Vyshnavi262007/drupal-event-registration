Event Registration Module – Drupal 10

This is a custom Drupal 10 module that allows users to register for events and helps admins manage events easily. It includes event configuration, dynamic forms using AJAX, validations, email notifications, and CSV export.

What this module does
Admin can:

• Add event details (start date, end date, event date, name, category)
• Control when registration is open
• View all registrations
• Filter registrations
• Download registrations as CSV

Users can:

• Register for events
• Select category → date → event name dynamically (AJAX)
• Receive confirmation email after registering

Validations included

• Proper email format check
• Only letters allowed in name, college, department
• Prevents duplicate registration for same event

Database tables used
event_config

Stores event details set by admin

Fields:
id, start_date, end_date, event_date, event_name, category

event_registration

Stores user registrations

Fields:
id, full_name, email, college, department, event_date, event_name, category, created

Email feature

• User gets confirmation mail
• Admin gets notification mail

How to install

Place module in:

modules/custom/event_registration

Enable it from:

Admin → Extend

Import database file:

event_registration.sql

Clear cache

Tech used

Drupal 10
PHP
MySQL
AJAX

Created by

Vyshnavi Ponapati
