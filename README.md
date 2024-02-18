# Task: Implement Modular Payment Gateway Integration

##  Usage

### Installation
1. Clone Project From Github
``` bash
git clone git@github.com:Emanmahmoud21/gateway_task.git
```
2. Copy .env.example as new file with name .env

3. Run Install Command:
``` bash
composer install --ignore-platform-reqs
```
4. Run Install Node Modules
``` bash
npm install
```
5. You can create the transactions & gateway_settings tables by running the migrations:
``` bash
php artisan migrate
```
6. run command to insert required data
``` bash
php artisan db:seed
```
## Paypal Tested Account
- ```Personal Account```
```dotenv
  Sandbox URL: https://sandbox.paypal.com
  Email: sb-ygw1o29585182@personal.example.com
  Password: SF6q-l-z
```
- ```Business Account```
```dotenv
  Sandbox URL: https://sandbox.paypal.com
  Email: sb-5lhey29129518@business.example.com
  Password: 7l|x4=D+
```


## Stripe Tested Card
- Payment succeeds
``` bash
4242 4242 4242 4242 
```
- Payment requires authentication
``` bash
4000 0025 0000 3155
```
- Payment is declined
``` bash
4000 0000 0000 9995
```

``` bash
When testing interactively, use a card number, such as 4242 4242 4242 4242. 
Enter the card number in the Dashboard or in any payment form.

Use a valid future date, such as 12/34.
Use any three-digit CVC (four digits for American Express cards).
Use any value you like for other form fields.
```

```
### credentials i added as gateway setups in database just run seeder
```
