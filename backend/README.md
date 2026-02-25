# Money Tracker API (Laravel)

Simple Money Tracker API built with **Laravel Framework 12.53.0**.  
This is a backend-only assessment. An existing frontend consumes these endpoints.  
**Note:** the `wallets` table includes a `balance` column that the application keeps updated; it is not merely computed lazily. This avoids misleading zero values when inspecting the database manually.

The system allows each user to manage multiple wallets, and each wallet can have income and expense transactions. Balances are calculated dynamically and the current total is also stored in the `wallets.balance` column so it stays in sync with the API responses.

---

## Features

- Create users (no authentication required).
- Create multiple wallets per user.
- Add income and expense transactions to wallets.
- View a user profile:
  - All wallets.
  - Each wallet’s balance.
  - Total balance across all wallets.
- View a single wallet:
  - Wallet balance.
  - All transactions for that wallet.
- Basic validation:
  - Required fields.
  - Positive amounts.
  - Transaction type must be `income` or `expense`.

---

## Tech Stack

- PHP
- Laravel 12.x
- MySQL

---

## Setup

From the project root, go into the backend:

```bash
cd backend
1. Install dependencies
bash
composer install
2. Environment configuration
Copy .env.example to .env if needed:

bash
cp .env.example .env
Edit .env:

text
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=money_tracker
DB_USERNAME=root
DB_PASSWORD=
Create the money_tracker database in MySQL (e.g. via Laragon / phpMyAdmin).

3. Generate app key
bash
php artisan key:generate
4. Run migrations
bash
php artisan migrate
# or, if you want a clean DB:
# php artisan migrate:fresh
5. Start the server
bash
php artisan serve
# → http://127.0.0.1:8000
Base API URL: http://127.0.0.1:8000/api

API Endpoints
1. Create User (no authentication)
POST /api/users

Body:

json
{
  "name": "Beth Kimani"
}
Response 201 Created (example):

json
{
  "id": 1,
  "name": "Beth Kimani",
  "wallets": [],
  "created_at": "...",
  "updated_at": "..."
}
Validation:

name – required, string, max 255.

2. Create Wallet for a User
POST /api/users/{user}/wallets
Example: POST /api/users/1/wallets

Body:

json
{
  "name": "Savings"
}
Response 201 Created:

json
{
  "id": 1,
  "user_id": 1,
  "name": "Savings",
  "transactions": [],
  "created_at": "...",
  "updated_at": "..."
}
Validation:

name – required, string, max 255.

A user can have multiple wallets (e.g. “Savings”, “Business”, etc.).

3. Add Transaction to a Wallet
POST /api/wallets/{wallet}/transactions
Example: POST /api/wallets/1/transactions

Income example:

json
{
  "type": "income",
  "amount": 5000,
  "description": "Salary"
}
Expense example:

json
{
  "type": "expense",
  "amount": 2000,
  "description": "Shopping"
}
Response 201 Created:

json
{
  "id": 1,
  "wallet_id": 1,
  "type": "income",
  "amount": "5000.00",
  "description": "Salary",
  "created_at": "...",
  "updated_at": "..."
}
Validation:

type – required, must be income or expense.

amount – required, numeric, min 0.01.

description – optional, string, max 1000.

Balance rules:

income adds to balance.

expense subtracts from balance.

The API logic now updates the `balance` field on the wallet record whenever a transaction is created, ensuring database queries on that column return the correct amount.

4. View User Profile (All Wallets + Balances)
GET /api/users/{user}
Example: GET /api/users/1

Response (example after one income 5000 and one expense 2000 on wallet 1):

json
{
  "id": 1,
  "name": "Beth Kimani",
  "total_balance": 3000,
  "wallets": [
    {
      "id": 1,
      "name": "Savings",
      "balance": 3000
    }
  ]
}
total_balance – sum of all wallet balances for the user.

Each wallet’s balance is calculated from its transactions.

5. View Single Wallet (Balance + Transactions)
GET /api/wallets/{wallet}
Example: GET /api/wallets/1

Response:

json
{
  "id": 1,
  "name": "Savings",
  "balance": 3000,
  "transactions": [
    {
      "id": 1,
      "type": "income",
      "amount": "5000.00",
      "description": "Salary",
      "created_at": "...",
      "updated_at": "..."
    },
    {
      "id": 2,
      "type": "expense",
      "amount": "2000.00",
      "description": "Shopping",
      "created_at": "...",
      "updated_at": "..."
    }
  ]
}
Models & Relationships
User
hasMany(Wallet::class)

Accessor total_balance sums all wallet balances.

Wallet
belongsTo(User::class)

hasMany(Transaction::class)

Accessor balance calculates:

Sum of income amounts.

Minus sum of expense amounts.

Transaction
belongsTo(Wallet::class)

Validation Summary
User
name – required, string, max 255.

Wallet
name – required, string, max 255.

Transaction
type – required, income or expense.

amount – required, numeric, positive.

description – optional.

Testing with Postman (Quick Flow)
Create User

text
POST /api/users
Body:

json
{ "name": "Beth Kimani" }
Create Wallet

text
POST /api/users/1/wallets
Body:

json
{ "name": "Savings" }
Add Income

text
POST /api/wallets/1/transactions
Body:

json
{ "type": "income", "amount": 5000, "description": "Salary" }
Add Expense

text
POST /api/wallets/1/transactions
Body:

json
{ "type": "expense", "amount": 2000, "description": "Shopping" }
View Profile

text
GET /api/users/1
→ total_balance should be 3000.

View Wallet

text
GET /api/wallets/1
→ balance should be 3000.