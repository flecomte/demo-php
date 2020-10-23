YST
===

[Schemas](./doc/Schema/schema.md)

Installation
------------

[Installation prerequisites](./doc/installation/Installation.md)

*This command builds the dockers, update composer, run the tests and launch all services (Except the Producer).*
```shell
make install
```

then, to launch the producer like this:
```shell
make fetch date=2015-01-01-12
```
Wait a moment, then try to access the URL https://localhost/commits/2015-01-01?tag=gitignore

*You can view the progress here: http://localhost:15672/#/queues/%2F/commit (guest/guest)*