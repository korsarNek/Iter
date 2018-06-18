#!/usr/bin/env bash

composer exec 'phpunit --bootstrap vendor/autoload.php --test-suffix=.php --testdox tests'