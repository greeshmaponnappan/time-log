# clone the repo
git clone https://greeshmaponnappan@bitbucket.org/greeshmatech/time-log.git
cd time-log

# install PHP dependencies
composer install

# create .env
cp .env.example .env
# update DB credentials in .env

# generate app key
php artisan key:generate

# run migrations & seeders
php artisan migrate --seed

# run local server
php artisan serve
# or use Valet / Sail / Docker as preferred

