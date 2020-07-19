type = patch
comment = Release $(type)
filter= ""

ifeq ($(user),)
HOST_USER ?= $(strip $(if $(USER),$(USER),order))
HOST_UID ?= $(strip $(if $(shell id -u),$(shell id -u),1001))
else
HOST_USER = $(user)
HOST_UID = $(strip $(if $(uid),$(uid),0))
endif

THIS_FILE := $(lastword $(MAKEFILE_LIST))
CMD_ARGUMENTS ?= $(cmd)

export HOST_USER
export HOST_UID

.PHONY: up
up:
	docker-compose up -d

.PHONY: build
build:
	docker-compose build --force

.PHONY: attach
attach: up
	docker-compose exec app bash

.PHONY: install
install: up
	docker-compose exec app composer install

.PHONY: stop
stop:
	docker-compose stop

.PHONY: tests
tests: up
	docker-compose exec app vendor/bin/phpunit --filter $(filter)

.PHONY: unit-tests
unit-tests: up
	docker-compose exec app vendor/bin/phpunit  --testsuite Unit --filter $(filter)

.PHONY: acceptance-tests
acceptance-tests: up
	docker-compose exec app vendor/bin/phpunit  --testsuite Acceptance

.PHONY: check-test-coverage
check-test-coverage: tests
	docker-compose exec app php artisan tests:check-coverage

.PHONY: migrate
migrate: up
	docker-compose exec app php artisan migrate

.PHONY: mysql-client
mysql-client: up
	docker-compose exec app mysql -u root -h database -psecret --database supra

.PHONY: style-check
style-check: up
	docker-compose exec app php-cs-fixer fix --dry-run --verbose --diff

.PHONY: style-fix
style-fix: up
	docker-compose exec app php-cs-fixer fix --verbose

.PHONY: code-quality
code-quality: up
	docker-compose exec app ./vendor/bin/phpinsights analyse --config-path="./config/insights.php"

.PHONY: server-tests-coverage
server-tests-coverage:
	php -S localhost:8081 --docroot=tests/_reports/coverage/