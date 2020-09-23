# New Applicants Skill Test Dashboard (N.A.S.T.Y Dash)

Make a sales dashboard as a very simple and straightfoward PHP application to show SQL/PHP/JS skills. There is no need to implement all features. more time should be spent on code rather than completeing all the tasks.

## Quick-start guide
Once you've got Docker running on the local machine, you should simply start `./deploy.sh` (or `./deploy_dev.sh` if in dev).

If everything goes according to plan, you can visit `http://localhost:8080/` in your browser (or other applicable url).

You can find default environment variables in the `.env` file, and any overrides can be made via a new file `.env.local`.

# Directions

## Requirements PHP
- PHP application should be based on MVC structure
- Have at least on abstract class and one interface
- Use namespaces
- [PSR-4](http://www.php-fig.org/psr/psr-4/) standard
- No PHP framework should be used
- Use Bootstrap as layout framework
- Use any JS library/framework if needed (e.g. JQuery, AngularJS)

## Create a database structure
- Order - purchase date, country, device
- Order items - EAN, quantity, price
- Customer - first name, last name, email
- Customer has 1 to many connection with Order
- Order has 1 to many connection with Order items

## Create a simple dashboard that shows statistics for
- Total number of orders
- Total number of revenue
- Total number of customers
- Statistics by defaut should be based on last month, with an option to change to any time period (to & from).
- Create 1 month timeframe chart with customers and orders (something like this - (high charts can be used)):

## API Specification

```
[GET] /api/stats/total

aggregate = hour|day|month|year (day)
dateFrom = timestamp (-30 days)
dateTo = timestamp (now)
```
