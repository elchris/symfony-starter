mv -f symfony.lock lock.symfony && git pull && composer install --no-dev --optimize-autoloader && composer dump-env prod;
