# Student-Portal
Student Portal of Group 2
After Migration, dont forget to seed the Departments!!


php artisan db:seed --class=DepartmentSeeder



**insert in .env (OTP)** if missing

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=email
MAIL_PASSWORD=APP Password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=email
MAIL_FROM_NAME="School-portal"
smtp.gmail.com



**Excel File Location**
School-portal\storage\app



**Loading Screen**
School-portal\public\storage\ibsmalogo.png

**New installation**
composer update
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate
php artisan db:seed --class=DepartmentSeeder
php artisan db:seed --class=OtherSubjectsSeeder
php artisan db:seed --class=InstructorSeeder

**LAN SERVE**
php artisan serve --host=0.0.0.0


**instructor profile  no pf**
GitBash
rm -rf public/storage
php artisan storage:link




**pag naga inarte and DB settings**
UPDATE `school_portal`.`settings`
SET `current_school_year` = '2025';


**route**
php artisan route:clear
php artisan route:cache
php artisan optimize:clear

**install niyo ito para sa updating qoutes everyday**
composer require guzzlehttp/guzzle

**To create a services folder**
mkdir app/Services
the after creating services manually create a service file

**To clean the attempts**
php artisan app:clean-old-login-attempts

