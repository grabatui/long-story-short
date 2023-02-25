up: docker-up
init: docker-down-clear docker-pull docker-build docker-up project-init
test: project-test project-behat
migrations: project-migrations project-test-migrations

project-init: project-composer-install project-generate-keys project-create-test-db

project-composer-install:
	docker-compose run --rm php-cli composer install

project-generate-keys:
	docker-compose run --rm php-cli php bin/console lexik:jwt:generate-keypair --skip-if-exists

project-create-test-db:
	docker-compose run --rm php-cli php bin/console doctrine:database:create --env=test --if-not-exists

project-test:
	docker-compose run --rm php-cli php bin/phpunit

project-behat:
	docker-compose run --rm php-cli vendor/bin/behat

project-migrations:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:migrate --quiet

project-test-migrations:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:migrate --env=test --quiet

project-make-migrations:
	docker-compose run --rm php-cli php bin/console doctrine:migrations:diff

docker-up:
	docker-compose up -d

docker-down:
	docker-compose down --remove-orphans

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build

docker-exec:
	docker-compose run --rm php-cli /bin/bash

phpstan:
	docker-compose run --rm php-cli ./vendor/bin/phpstan analyse src

cs-fixer:
	docker-compose run --rm php-cli ./vendor/bin/php-cs-fixer fix