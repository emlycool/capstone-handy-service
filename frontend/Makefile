# docker build -t handy-service-build .
# docker run --rm -it -p 3000:3000 --env-file .env.local --name handy-service-frontend handy-service-build

DOCKER_COMPOSE=docker compose -f ./docker-compose.dev.yml
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