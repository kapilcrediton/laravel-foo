## Post setup

Clone into local machine via `git`. Once you are set up:

- You should be able to run `composer install` from project root.
- You can run `php artisan serve` from the project root, open http://localhost:8000, and access laravel splash page.
- You should be able to run `php artisan migrate` to create tables in the db.

## Setup

- Install PHP and MySQL via [wampserver](http://www.wampserver.com/en/).
- Fix missing DLLs using [this link](https://stackoverflow.com/questions/34215395/wamp-wont-turn-green-and-the-vcruntime140-dll-error).
- Use [this](https://www.forevolve.com/en/articles/2016/10/27/how-to-add-your-php-runtime-directory-to-your-windows-10-path-environment-variable/) as a reference for adding wampserver's installation of php and mysql to `Path` on Windows.
- Install composer from [here](https://getcomposer.org/download/).