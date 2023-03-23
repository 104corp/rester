#!/usr/bin/make -f

PROCESSORS_NUM := $(shell getconf _NPROCESSORS_ONLN)
GLOBAL_CONFIG := -dmemory_limit=-1

.PHONY: all
all: test

.PHONY: clean
clean:
	rm -rf ./build

.PHONY: clean-all
clean-all: clean
	rm -rf ./vendor

.PHONY: check
check:
	php ${GLOBAL_CONFIG} vendor/bin/phpcs --parallel=${PROCESSORS_NUM}

.PHONY: test
test: check
	php vendor/bin/phpunit

.PHONY: coverage
coverage: test
	@if [ "`uname`" = "Darwin" ]; then open build/coverage/index.html; fi
