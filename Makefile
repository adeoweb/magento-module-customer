.SILENT:

IMAGE := gitlab.adeoweb.biz:8443/adeoweb/devops/magento-docker/php:7.4-dev
USER_NAME = $${SUDO_USER:-$$USER}
HOST_USER_ID = $$(id -u $(USER_NAME))
HOST_GROUP_ID = $$(id -g $(USER_NAME))
ENV = --env HOST_USER_ID=$(HOST_USER_ID) --env HOST_GROUP_ID=$(HOST_GROUP_ID)
VOLUME = -v `pwd`:/var/www/
DOCKER_RUN = docker run --rm -it $(ENV) $(VOLUME) $(IMAGE)

ci-unit-test:
	@php -dxdebug.mode=off vendor/bin/phpunit -c phpunit.xml --no-coverage

ci-check-style:
	@vendor/bin/phpcs --report=checkstyle

ci-composer-dev:
	@php -dmemory_limit=3G /usr/local/bin/composer install --prefer-dist

docker-unit-test:
	$(DOCKER_RUN) \
		php -dxdebug.mode=off vendor/bin/phpunit -c phpunit.xml --no-coverage

docker-check-style:
	$(DOCKER_RUN) \
		php vendor/bin/phpcs --report=checkstyle

docker-fix-style:
	$(DOCKER_RUN) \
		php vendor/bin/phpcbf --parallel=10

docker-composer-dev:
	$(DOCKER_RUN) \
		php -dmemory_limit=3G /usr/local/bin/composer install --prefer-dist
