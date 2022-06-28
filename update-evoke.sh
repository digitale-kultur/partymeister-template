#!/usr/bin/env bash
COMPOSER=composer-evoke.json php -d memory_limit=8096M ./composer.phar update $1
