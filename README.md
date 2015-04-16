# Hack Bot

[![License](https://poser.pugx.org/tomzx/hack-bot/license.svg)](https://packagist.org/packages/tomzx/hack-bot)
[![Latest Stable Version](https://poser.pugx.org/tomzx/hack-bot/v/stable.svg)](https://packagist.org/packages/tomzx/hack-bot)
[![Latest Unstable Version](https://poser.pugx.org/tomzx/hack-bot/v/unstable.svg)](https://packagist.org/packages/tomzx/hack-bot)
[![Build Status](https://img.shields.io/travis/tomzx/hack-bot.svg)](https://travis-ci.org/tomzx/hack-bot)
[![Total Downloads](https://img.shields.io/packagist/dt/tomzx/hack-bot.svg)](https://packagist.org/packages/tomzx/hack-bot)

A simple bot written in [Hack](http://hacklang.org/)/[PHP](http://php.net/).

## Requirements

* hhvm 3.3.0 <=
* readline extension (if you want to use the Shell adapter)

## Getting started

1. Clone the repository to your computer.
2. Configure the adapter (if necessary) by editing its file bootstrap file in the bin folder.
3. Start the bot by running an adapter bootstrap file. For instance `hhvm bin/hack-bot.php` will start the bot using the `Shell` adapter.

## License

The code is licensed under the [MIT license](http://choosealicense.com/licenses/mit/). See [LICENSE](LICENSE).