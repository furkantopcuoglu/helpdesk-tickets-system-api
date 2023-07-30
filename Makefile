run-phpstan:
	vendor/bin/phpstan analyse -c phpstan.neon --memory-limit 512M
composer-install:
	composer install --prefer-dist --no-ansi --no-interaction --no-progress --ignore-platform-reqs
run-cs-fixer:
	php vendor/bin/php-cs-fixer fix --dry-run --diff -n --verbose
run-cs-fixer-fixed:
	php vendor/bin/php-cs-fixer fix src/
generate-jwt:
	php bin/console lexik:jwt:generate-keypair
update-sql:
	php bin/console d:s:u --force --dump-sql --complete
event-request-list:
	php bin/console debug:event-dispatcher kernel.request
messenger:
	php bin/console messenger:consume async -vv	
clear-cache:
	php bin/console cache:clear
	php bin/console doctrine:cache:clear-metadata
	php bin/console doctrine:cache:clear-query
	php bin/console doctrine:cache:clear-result
migration-create:
	php bin/console make:migration
migration-update:
	php bin/console doctrine:migrations:migrate
