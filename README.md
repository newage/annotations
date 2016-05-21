# generators

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

A map of entity generator from annotations on console for Zend Framework 2.
Project uses [PSR-2](http://www.php-fig.org/psr/psr-2/) coding style and [PSR-4](http://www.php-fig.org/psr/psr-4/) autoloading standard.

## Install

Via Composer

``` bash
$ composer require newage/annotations
```

## Usage

1. Copy configuration file.
``` bash
copy vendor/newage/annotations/config/annotations.global.php.dist config/autoload/annotations.global.php
```
2. Change a path and a namespace to your Entity for `AnnotationBuilder`.
3. Change a path for `MapperBuilder` to generating a file of map.
4. Add a module `Newage\Annotations` to your config.
4. Set annotations to your Entity. You can see examples [User](User) and [Role](Role) entities.
5. You need to start a console command:
``` bash
zf mapper generate
```

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CONDUCT](CONDUCT.md) for details.

## Security

If you discover any security related issues, please email vadim.leontiev@gmail.com instead of using the issue tracker.

## Credits

- [Vadim Leontiev][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/newage/annotations.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/newage/annotations/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/newage/annotations.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/newage/annotations.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/newage/annotations.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/newage/annotations
[link-travis]: https://travis-ci.org/newage/annotations
[link-scrutinizer]: https://scrutinizer-ci.com/g/newage/annotations/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/newage/annotations
[link-downloads]: https://packagist.org/packages/newage/annotations
[link-author]: https://github.com/newage
[link-contributors]: ../../contributors
