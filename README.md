# Event Planner

## Requirements

To run this project, you need to have the following installed:

- Docker Desktop
- PHP 8.5
  - Make sure `extension=pdo_mysql` is configured in your php.ini

## How to run the project

1. Clone the repository
2. Run `docker-compose up -d`
3. Run `php -S localhost:8000`
4. Open http://localhost:8000 in your browser

## Database Setup

Create the database schema:

```bash
docker exec mysql mysql -uroot -proot -e "source /sql/schema.sql"
```

Seed the database with test data (optional):

```bash
docker exec mysql mysql -uroot -proot -e "source /sql/seeder.sql"
```

### Database Access

| Service    | URL/Host              | Credentials |
| ---------- | --------------------- | ----------- |
| MySQL      | `localhost:3306`      | root / root |
| phpMyAdmin | http://localhost:8080 | dev / dev   |
