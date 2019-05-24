# Friendemic Coding Challenge

## Installation
```
git clone git@github.com:wkubenka/friendemic.git
cd friendemic
composer install
cp .env.example .env
php artisan key:generate
npm install
php artisan serve
```



## Design Decisions
I have decided to keep this as simple, but scalable as possible. 

The sync driver is currently being used to handle queues, and returning the transactions as JSON from FileController
 is only possible because the dispatched job is being ran synchronously. If this application needed to scale, I would 
 switch to using Redis to run jobs asynchronously. This would require storing the transactions from the job in a newly 
 created DB table (or file), and pushing the transactions to the React application using Echo and Pusher when the job 
 is complete.


### Controllers

#### FileController
The FileController upload method accepts a CSVImportRequest.
It only dispatches a ParseCSVJob and returns the transactions built by the job.

### Jobs

#### ParseCSVJob 
The constructor assumes the first line of the csv file contains headers.
These headers are pulled to build an associative array for the rest of the lines.
These arrays are turned in to Transaction models.

When the job is handled, the CSV is checked for 3 things. 
1. Is there an older record for the same customer number?
2. Is this record older than 7 days?
3. Should we send the invitation to their phone or email?

### Models

#### Transaction
In youngerThanDays(int), the date is being set to March 5th, 2018.

### Requests

#### CSVImportRequest
Authorized: true

Rules:
- file: required, file

### Routes
 - `/` is a route to a view with a React application.  
 - `/api/upload/` is an api route to upload a csv file to the FileController upload method.

## Testing
Run frontend tests with `npm test`

Run backend tests with `phpunit` or `vendor/bin/phpunit`
