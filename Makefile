install:
	composer install

lint:
	composer exec phpcs -v -- --standard=PSR12 -np src tests

lint-fix:
	composer exec phpcs -v -- --standard=PSR12 -np src tests

test:
	composer exec --verbose phpunit tests

test-coverage:
	composer exec --verbose phpunit tests -- --coverage-clover build/logs/clover.xml