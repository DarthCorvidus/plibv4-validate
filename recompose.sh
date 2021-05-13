#!/bin/bash
rm composer.lock
rm vendor -rf
composer clearcache
composer install
