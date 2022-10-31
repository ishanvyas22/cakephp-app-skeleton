# CakePHP Application Skeleton

A skeleton for creating applications with [CakePHP](https://cakephp.org) & Docker.

## Features
- Traditional Nginx + PHP FPM combo to serve the application
- PHP version 8.1
- CakePHP version 4.4
- MariaDB v10.9 as database
- Redis v6.2 for superfast in-memory caching
- Helpful tools for ease of development
- Built for scalability in mind:
    - Leverages `docker compose` to spin up & talk containers of each services
    - All services are configured to write logs to stdout/stderr so it is easily configured to send logs to external services like New Relic, Logstash, ELK, etc.

## Requirements

- [Docker](https://docs.docker.com/get-docker/) v20 or newer

## Installation

```bash
docker run -it --rm \
    --volume /var/run/docker.sock:/var/run/docker.sock \
    --volume "$(pwd)"/my-app:/var/www/html:rw \
    --entrypoint="bin/cake install" \
    cakephp-app-skeleton-app
```

Note:
- Replace "my-app" with your application name.

Please note that these instructions are to run the app in **development environment** only.

```bash
git clone git@github.com:ishanvyas22/cakephp-app-skeleton.git my-cakephp-app
cd my-cakephp-app
docker compose up -d --remove-orphans
```

Then visit http://localhost:8765/ to see the landing page.

## Development

### Copy app config from docker container to host system

```bash
docker cp cakephp-app-skeleton-app:/var/www/config/app_local.php ./config/app_local.php
```

### Viewing logs

Use below command to watch application logs:
```bash
docker logs <container-name> --follow
```

**Example:**
```bash
docker logs cakephp-app-skeleton-app --follow
```

### Code completion

You need to install composer dependencies in order to get code completion for your IDE:
```bash
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  composer install --ignore-platform-reqs
```

### Require a new package via composer

```bash
docker run --rm --interactive --tty \
  --volume $PWD:/app \
  composer require <org>/<package-name> --ignore-platform-reqs
```
