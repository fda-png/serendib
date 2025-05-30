# serendib

# Serendib Trails - Tourism Web Application

## Development Team
- Fadhil Fazil (KIC-BACM-231-P-006)
- Layan Ranaweera (KIC-BACM-231-P-010)
- Thejan Seneviratne (KIC-BACM-231-P-001)

## Setup Instructions
1. Install XAMPP: https://www.apachefriends.org
2. Clone repository to `htdocs` folder
3. Start Apache and MySQL in XAMPP Control Panel
4. Create database:
   ```bash
   mysql -u root -p
   CREATE DATABASE serendib_trails;
   USE serendib_trails;
   SOURCE sql/serendib_trails_schema.sql;
   ```
5. Access site at: http://localhost/serendib-trails

## Test Accounts
**Admin:**
- Email: admin@serendib.lk
- Password: Admin@123

**User:**
- Email: traveler@example.com
- Password: Password123

## Features Implemented
- User authentication system
- Tour package booking
- Gallery with image uploads
- Admin approval system
- Contact form with email notifications
- Responsive dark-themed UI
- Dashboard analytics

## Group Contribution
- Fadhil Fazil: Backend architecture, database design
- Layan Ranaweera: Frontend implementation, UI design
- Thejan Seneviratne: Gallery system, booking functionality
