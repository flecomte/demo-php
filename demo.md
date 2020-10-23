Interesting points
====

- Tests
  - [Unit Tests](./Producer/tests/ArchiveIteratorTest.php)
  - [SQL Tests](./Migration/tests/sql/commit.sql)
  - [Functional Tests](./Api/tests/Controller/CommitControllerTest.php)
- Microservice
  - [Use Docker for microservice](./docker/dev/docker-compose.yml)
  - [Microservice without Symfony Framework](./Consumer/src)
  - [Use RabbitMQ to async long tasks](./Producer/src/HistoryService.php)
  - [Use UML to improve the understanding](./doc/Schema/schema.md)
- SQL without ORM
  - [Migrations](./Migration/src/Migrations/2020-10)
  - [Queries as functions](./Migration/src/Functions/commit)
  - [Use JSON to save data](./Migration/src/Functions/commit/insert.sql)
  - [Usage query](./Api/src/Repository/CommitRepository.php)
  - [Table partitioning for large data](./Migration/src/Migrations/2020-10/2020-10-22_17-29-47.up.sql)
