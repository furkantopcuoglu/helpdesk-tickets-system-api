## Symfony 6.3 RESTful API - Helpdesk Tickets Project

Help Desk Ticket project as a simple RESTful API.

Hexagonal Architecture & CQRS

- > API_URL=https://helpdesk-api.furkantopcuoglu.dev
- > Swagger API Document =https://helpdesk-docs.furkantopcuoglu.dev

## Setup Project
- git clone https://github.com/furkantopcuoglu/helpdesk-tickets-system-api
- > make composer-install
- > make generate-jwt
- > edit .env
  - > **JWT_PASSPHRASE**= the password you created for jwt
  - > **DATABASE_URL**="mysql://MYSQL_USER:MYSQL_PASSWORD@db:3306/MYSQL_DATABASE?serverVersion=8&charset=utf8mb4"
  - > **MESSENGER_TRANSPORT_DSN**=amqp://RABBITMQ_DEFAULT_USER:RABBITMQ_DEFAULT_PASS@rabbitmq3:5672/%2f/messages
- > docker-compose up -d
- > make update-sql
- > make run-fixture
- > make messenger

## Branching strategy:
Feature branch name prefix: "HD-{number} (Ticket Title)"
- master: Production environment
- development: Development environment

> master -> HD-xx -> development (MR) -> master (MR)

# [Database Schema](https://drawsql.app/teams/furkantopcuoglu/diagrams/helpdesk-tickets-system-api/embed)

![Database Schema](https://furkantopcuoglu.com/heldesk-database-schema.png)