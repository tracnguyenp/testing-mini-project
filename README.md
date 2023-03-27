## Installation
- Copy the sample environment variables file to the `.env` one
```
cp .env.example .env
cp .env.example .env.testing
```
- Start the docker
```
docker-compose up -d
```
- Init the app
```
docker-compose exec web composer install --ignore-platform-reqs
docker-compose exec web php artisan migrate
```
- Generate Laravel Passport keys
```
docker-compose exec web php artisan passport:keys --force
```
then copy the content of `storage/oauth-private.key` to `PASSPORT_PRIVATE_KEY` and `storage/oauth-public.key` to `PASSPORT_PUBLIC_KEY` in the `.env` file
- Install Passport client
```
docker-compose exec web php artisan passport:install --force
docker-compose exec web php artisan passport:client --personal
```

## Workflow
### Prepare Postman
- Import `dev-postman/Testing Aspire.postman_collection.json` as the Collection
- Import `dev-postman/TestingAspire - Trac Nguyen Local.postman_environment.json` as the Environment and update the `api_base_url` to the API URL of your local

Then:
1. Use console command to create Admin user
```
docker-compose exec web php artisan users:create-admin-user admin03@yahoo.com 123456
```
2. Use `/customers/register` (Customers/Register) to register a customer
3. Use `/customers/login` (Customers/Login) to login as a customer
4. Use `/customers/loans/submit-loan` (Customers/Loans/Submit Loan) to submit a loan, request_date must be a future date
5. Use `/customers/loans` (Customers/Loans/List Loans) to view the loan list of current user
6. Use `/customers/loans/:loan_id` (Customers/Loans/View Loan) to view load details
7. Use `/admins/login` (Admin/Login) to login as an Admin
8. Use `/admins/loans/:loan_id/approve` (Admin/Loans/Approve) to approve a loan (from it's loan_id)
9. Use `/customers/login` (Customers/Login) to login as a customer
10. Use `/customers/repayments/:repayment_id/pay` (Customers/Repayments/Pay Repayment) to pay for a repayment, amount must be equal to or bigger than the repayment amount. Do this for all Repayments of a loan, loan would be automatically marked PAID.

## Running Tests
```
docker-compose exec web php artisan test
```

## Process
How I work on the project
- Start to put the docker stuffs to `dev-docker`, the reason to use `dev-docker` name is to easily delete development stuffs with needed by using `rm -rf dev-*`
- Reorganize Laravel app using DDD (similar to this article https://bitloops.com/docs/bitloops-language/learning/domain-driven-design)
- Create the migration rule for Admin and Customer and create a console command to create the Admin user
- Create basic API endpoints for Customers and Admin: register, login ...
  - Good practice is to store public_key and secret_key for user and create another enpoint that is similar to login to generate access token but using public_key and secret_key instead (will do this if I have more time).
- Create other endpoints
- Apply phpcs to keep the codestyle
```
docker-compose exec web ./vendor/bin/phpcs
```
- Add UnitTest and FeatureTest for the application. I can only write Unit Test for 1 method `LoanService` and Feature Test for register and login of customer
