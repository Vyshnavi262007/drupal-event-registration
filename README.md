# Event Registration Module – Drupal 10

Custom Drupal 10 module for managing event registrations with admin configuration, AJAX filters, email notifications, and CSV export.

---

## 📦 Features

### Admin Event Configuration
- Event registration start date
- Event registration end date
- Event date
- Event name
- Event category

### Event Registration Form
- Full Name
- Email
- College
- Department
- Category (AJAX)
- Event Date (AJAX)
- Event Name (AJAX)

Registration is allowed only between start and end date.

---

## ✅ Validations
- Email format validation
- Text fields allow only letters
- Prevents duplicate registration (Email + Event Date)

---

## 🗄 Database Tables

### event_config
| id | start_date | end_date | event_date | event_name | category |

### event_registration
| id | full_name | email | college | department | event_date | event_name | category | created |

---

## 📧 Email Notifications
- User receives confirmation mail
- Admin receives notification (configurable)

---

## 📊 Admin Pages

### Event Configuration Form
