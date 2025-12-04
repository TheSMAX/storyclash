PHP Copy Tool

A PHP CLI tool to copy a feed entry (and associated sources and posts) from a production-like database to a local dev database for debugging purposes.

## Features

* Copy a feed entry by ID
* Optionally include only specific sources (Instagram or TikTok)
* Optionally include a number of posts
* Uses PDO for database access
* Supports transactions

## Requirements

* PHP 8+
* Composer
* MySQL or SQLite for testing
* PHPUnit for running tests

## Installation

1. Clone the repository

git clone https://github.com/TheSMAX/storyclash.git
cd <repo-folder>
```

2. Install dependencies

```bash
composer install
```

3. Configure database connection in database.php

DB_HOST=127.0.0.1
DB_PORT=3306
DB_NAME=storyclash
DB_USER=root
DB_PASS=''


## Usage

```bash
# Basic copy
php bin/copy 123

# Copy feed with only Instagram source
php bin/copy --only=instagram 123

# Copy feed with Instagram source and 5 posts
php bin/copy --only=instagram --include-posts=5 123
```

## Project Structure

```
bin/copy                  # CLI entrypoint
src/Repository/            # Repositories for feeds, Instagram, TikTok, posts
src/Service/CopyService.php # Service that handles the copy logic
tests/                     # PHPUnit tests
```

## Database

Tables:

* `feeds`
* `instagram_sources`
* `tiktok_sources`
* `posts`

Installation of DB in create_database.sql with sampledata

## Running Tests

```bash
vendor/bin/phpunit tests/
```

## Notes / Enhancements

* Could support copying multiple feeds at once
* Could include more complex relations or cascading data
* Currently works for MySQL and SQLite; could extend for other DBs
* Logging and dry-run mode could be added
