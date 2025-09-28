
# Rin2

An application that allows users to see special posts as a one-time notification.


## Deployment

To deploy this project run

First clone project
```bash
https://github.com/shubhamkanchar/rin2.git
```
Install all backend dependency
```bash
composer install
```
Then install all frontend dependency
```bash
npm install
```
Setup .env file add Database connection
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rin2
DB_USERNAME=root
DB_PASSWORD=
```
Add twilio credentials in .env file
```bash
TWILIO_SID=
TWILIO_TOKEN=
```

Then run migration
```bash
php artisan migrate
```

Run seeder for test Data
```bash
php artisan db:seed
```

Run below command to compile js files
```bash
npm run dev
```

Run development server
```bash
php artisan serve
```


## Demo

http://127.0.0.1:8000/


## API Reference

#### Get User list

```http
http://127.0.0.1:8000
```

| Description                |
| :------------------------- |
| This view show list of all user and it's accessible without login and user can access this by clicking header application name|
| By clicking impersonate button user can impersonate in specific account |

#### Send notification

```http
http://127.0.0.1:8000/notifications/form
```

| Description                |
| :------------------------- |
| This form  is used send notifications to user,User can send notification without auth |

#### Dashboard

```http
http://127.0.0.1:8000/home
```
| Description                |
| :------------------------- |
| This is basic user Dashboard page |
| On click of header bell icon user able to see notification in dropdown and option to mark all as read|

#### User's unexpired notification list 

```http
http://127.0.0.1:8000/notifications
```
| Description                |
| :------------------------- |
| This is view which show unexpired notification list|


#### Settings form

```http
http://127.0.0.1:8000/setting
```
| Description                |
| :------------------------- |
| From this form user can enable/disable notification or update email and phone |
