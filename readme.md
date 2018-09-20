# Tests when consuming external API using Codeception and Webserver mocking

Often when you're developing an application that consumes a third-party HTTP API, you need to test and prove your application would handle http 404 errors as expected. 

This example code demonstrates how you can do that with codeception/codeception and donatj/mock-webserver packages.

### To test

Clone repository

```
git clone git@github.com:cliffordchan/external_api_testing_with_codeception.git demo 
```

Change Directory

```angular2html
cd demo
```

Composer install

```angular2html
composer install
```


Run Codeception

```
./vendor/bin/codecept build
./vendor/bin/codecept run
```

## License

This example, codeception, mock-webserver and Lumen framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
