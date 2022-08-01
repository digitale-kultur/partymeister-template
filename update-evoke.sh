#!/usr/bin/env bash
git pull
COMPOSER=composer-evoke.json php -d memory_limit=8096M ./composer.phar update $1
