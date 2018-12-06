.PHONY: all test

all: test

test:
	php vendor/bin/phpcs
	phpdbg -qrr vendor/bin/phpunit

coverage: test
	@if [ "`uname`" = "Darwin" ]; then open build/coverage/index.html; fi
