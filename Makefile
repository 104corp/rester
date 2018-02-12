.PHONY: all tests

all: tests

tests:
	php vendor/bin/phpcs
	php vendor/bin/phpunit

coverage:
	php vendor/bin/phpunit --coverage-html build
