#!/usr/bin/make

.SILENT: clean
.PHONY: all artisan composer php
.DEFAULT_GOAL := help
.DEFAULT:
	@: # Do nothing for unknown targets

RUN = docker-compose run --rm -v $(PWD):/app -w /app --user $(id -u $USER):$(id -g $USER) --entrypoint
PHP = docker run --rm -v $(PWD):/app -w /app --user $(id -u $USER):$(id -g $USER) php:8.4-fpm php
APP = $(RUN) bash app
APP_COMPOSER = $(RUN) composer app
APP_PHP = $(RUN) php app
APP_NPM = $(RUN) npm app

##@ Development resources

setup: ## Setup the project
	@make check-docker
	@rm -rf ./storage/logs/*.log ./bootstrap/cache/*.php
	@cp .env.example .env
	docker compose down --remove-orphans
	docker-compose build
	$(APP_COMPOSER) install --no-interaction --no-plugins --no-scripts
	$(APP_NPM) install && $(APP_NPM) run build
	$(APP_PHP) artisan key:generate
	@make setup-database
	docker-compose up -d --force-recreate
	$(APP_PHP) artisan optimize:clear
	@echo "\033[1;32mSetup concluído com sucesso.\033[0m"
	@echo "\033[1;34mAcesse a aplicação em ===> http://localhost:8080\033[0m"


setup-database: ## Setup the database
	echo '' > ./storage/database.sqlite
	$(APP_PHP) artisan migrate --force

stop: ## Stop the Docker containers
	docker-compose down --remove-orphans

php: ## Run a PHP command inside the application container. Usage: make php <command>
	$(APP_PHP) $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

container: ## Access the application container
	docker-compose exec -it  app bash

ci: ## Run continuous integration tests
	$(APP_COMPOSER) ci

test: ## Run the test suite
	$(APP_COMPOSER) test

artisan: ## Run an Artisan command inside the application container. Usage: make artisan <command>
	$(APP_PHP) artisan $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

php: ## Run a PHP command inside the application container. Usage: make php <command>
	$(APP_PHP) $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

composer: ## Run an composer command inside the application container. Usage: make composer <command>
	$(APP_COMPOSER) $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))

fix: ## Run code style fixer
	$(APP_COMPOSER) fix

update-dependencies: ## Update project dependencies
	$(APP_COMPOSER) update
	$(APP_COMPOSER) upgrade
	$(APP_NPM) update
	$(APP_NPM) upgrade
	$(APP_NPM) run build

check-docker: ## Check if Docker is installed
	@docker --version > /dev/null 2>&1 || (echo "Docker is not installed. Please install Docker and try again." && exit 1)

help: ## Show this help message
	@echo "Usage: make [command]"
	@echo ""
	@echo "Commands available:"
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-20s %s\n", $$1, $$2}' $(MAKEFILE_LIST)
