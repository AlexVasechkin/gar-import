#!/usr/bin/env bash

# ./db_test_loc.sh

#php vendor/bin/phpunit \
# --no-configuration \
# -c phpunit-lc.xml

#php vendor/bin/phpunit \
# --testsuite Unit \
# --no-configuration \
#  -c phpunit-lc.xml

php vendor/bin/phpunit \
 --no-configuration \
 -c phpunit-lc.xml \
  ./tests/Unit/Services/AddressAnalyzerServiceTest.php
