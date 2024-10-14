DOCKER_COMPOSE=docker compose -f ./docker-compose-dev.yml
## ----------------------
## Docker composer management
## ----------------------
.PHONY: build
build: ## Build the stack
	$(DOCKER_COMPOSE) build

.PHONY: build-no-cache
build-no-cache: ## build-no-cache the stack
	$(DOCKER_COMPOSE) build --no-cache

.PHONY: up
up: ## Environment up!
	$(DOCKER_COMPOSE) up -d --force-recreate --renew-anon-volumes


.PHONY: exec-app
exec-app: ## Environment up!
	$(DOCKER_COMPOSE) exec -it app bash


.PHONY: destroy
destroy:
	$(DOCKER_COMPOSE) down --remove-orphans --volumes
	$(DOCKER_COMPOSE) rm --stop --volumes --force

## ----------------------
## Laravel commands
## ----------------------
.PHONY: migrate
migrate:
	$(DOCKER_COMPOSE) exec app bash -c "php artisan migrate --force"

.PHONY: migrate-fresh
migrate-fresh:
	$(DOCKER_COMPOSE) exec app bash -c "php artisan migrate:fresh --seed --force"

# .PHONY: test
# test:
# 	$(DOCKER_COMPOSE) run --rm test php artisan test

# .PHONY: queue-restart
# queue-restart: 
# 	$(DOCKER_COMPOSE) run --rm worker php artisan queue:restart