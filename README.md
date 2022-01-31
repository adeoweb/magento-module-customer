# Customer

### Prerequisites

PHP

```
^7.1
```

Magento

```
2.3.*|2.4.*
```

### Installing

Install with composer

```
composer require adeoweb/module-customer
```

Enable module

```
php bin/magento module:enable AdeoWeb_Customer
```

Run install scripts

```
php bin/magento setup:upgrade
```

Run compile scripts

```
php bin/magento setup:di:compile
```

## Development

```shell
git clone git@gitlab-ssh.adeoweb.biz:adeoweb/modules/m2-modules/customer.git src/vendor/adeoweb/module-customer
composer config repositories.0 path vendor/adeoweb/module-customer
composer require adeoweb/module-customer
```

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/your/project/tags).

