# Friendemic Coding Challenge

## Installation
```
git clone git@github.com:wkubenka/friendemic.git
cd friendemic
composer install
php artisan serve
```



## Design Decisions
I have decided to keep this as simple, but scalable as possible. 
There is a route to a view with a react application, and an api route to upload a csv file which goes to the FileController.

I like to keep controllers as small as possible, so I pass the file to a service class to be processed. 
The service constructor assumes the first line of the csv file contains headers.
These headers are pulled to build an associative array for the rest of the lines.
These arrays are turned in to Transaction models.

Two things to note here: 
1. If this application needs to scale, Laravel's queue functionality could be leveraged by turning the service class into a Job class.
Then simply dispatch a job and return a response rather than waiting for the CSV to be processed.
2. My Transaction class is extending Model almost purely for the magic methods provided by the Model class. 
However, this would probably be useful if this program got built out and connected to storage. 

The CSV is then processed for 3 things. 
1. Is there an older record for the same customer number?
2. Is this record older than 7 days?
3. Should we send the invitation to their phone or email?

## Testing
Run frontend tests with `npm test`

Run backend test with `phpunit` or `vendor/bin/phpunit`
