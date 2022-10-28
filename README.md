# CakePHP Application Skeleton

A skeleton for creating applications with [CakePHP](https://cakephp.org) 4.x.

## Features
- Traditional Nginx + PHP FPM combo to serve the application
- MySQL as database
- Redis for caching
- Helpful tools for ease of development
- Built for scalability in mind:
    - Leverages `docker compose` to spin up & talk containers of each services
    - Writes logs to stderr so it is easily configured to send logs to external services like New Relic, Logstash, ELK, etc.

## Requirements

- [Docker](https://docs.docker.com/get-docker/) v20 or newer

## Installation

1. Get project into your local system
    ```bash
    git clone git@github.com:ishanvyas22/cakephp-app-skeleton.git my-cakephp-app
    cd my-cakephp-app
    ```

1. Start docker containers:
    ```bash
    docker compose up -d --remove-orphans
    ```

All set! Navigate to http://localhost:8765/ to see the webpage.
