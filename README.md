# APIs and Callbacks

## commands to run for running the server after cloning

- composer install
- cp example.env .env
- php artisan key:generate
- php artisan migrate
- php artisan serve

## Note
- Run ``php artisan migrate`` only if you have not imported the sql file provided in my email.
- Run ``php artisan route:list`` for displaying the api routes in the application.
- POSTMAN is used to test the APIs
- teknasyon.sql is added to this directory. Import if you do not want to use ``php artisan migrate``
- Had only weekend to work on it due to office work on weekdays.
- Event and listeners are created for callbacks in the application with APIs which eventually send POST request to 3rd party API for change in subscription status. But the request is being commented because ``php artisan serve`` does not support guzzlehttp commands. Please uncomment if using vhost instead of ``php artisan serve``.
- Was not able to understand the cron part as they are done on server but I have made a api which can be called via cron job.
- Reporting is not done because I could not get what exactly was needed. A simple few SQL queries or api for those reports. It was a little confusing.

## Register a device

- Request URL - http://localhost:8000/api/device/register
- Type - POST
- Body - {'uID':'11242','appID':'345','language':'HN','os':'android'}

## Subscription Purchase

- Request URL - http://localhost:8000/api/subscription/purchase
- Type - POST
- Headers (not used as credentials are not verified from google) - {'username':'username','password':'password'}
- Body - {'receipt':'jsjasdadasdsdad21231231sjsjsjsjs1','client-token':<token_from_frontend>}

## Check a subscription

- Request URL - http://localhost:8000/api/subscription/checksubscription?client-token=<token_from_frontend>
- Type - GET
