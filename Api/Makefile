
# HELP
# This will output the help for each task
# thanks to https://marmelab.com/blog/2016/02/29/auto-documented-makefile.html
.PHONY: help

help: ## This help.
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

.DEFAULT_GOAL := help

composer-update: ## Composer update
	@cd ../docker/dev ; docker-compose -f docker-compose.yml run --rm api-dev composer update

composer-install: ## Composer install
	@cd ../docker/dev ; docker-compose -f docker-compose.yml run --rm api-dev composer install

run: ## Run
	@cd ../docker/dev ; docker-compose -f docker-compose.yml up -d api-dev

build: ## Build docker image
	@cd ../docker/dev ; docker-compose -f docker-compose.yml build api-dev

install: build composer-install run ## Install docker and start api

