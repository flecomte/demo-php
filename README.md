YST
===

[Schemas](./doc/Schema/schema.md)

Installation
------------

*This command builds the dockers, update composer, run the tests and launch all services (Except the Producer).*
```shell
make install
```

then, to launch the producer like this:
```shell
make fetch date=2015-01-01-12
```

then, go to the URL https://localhost/history/2015-01-01?tag=love