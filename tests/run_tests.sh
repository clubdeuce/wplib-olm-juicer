#!/usr/bin/env bash

svn checkout http://develop.svn.wordpress.org/tags/${WP_VERSION} ${WP_TESTS_DIR}
mysql -e "CREATE DATABASE IF NOT EXISTS test_db;"
cp ${WP_TESTS_DIR}/wp-tests-config-sample.php ${WP_TESTS_DIR}/wp-tests-config.php
sed -i 's/youremptytestdbnamehere/'${DB_NAME}'/' ${WP_TESTS_DIR}/wp-tests-config.php
sed -i 's/yourusernamehere/'${DB_USER}'/' ${WP_TESTS_DIR}/wp-tests-config.php
sed -i 's/yourpasswordhere/'${DB_PASS}'/' ${WP_TESTS_DIR}/wp-tests-config.php
sed -i 's/localhost/'${DB_HOST}'/' ${WP_TESTS_DIR}/wp-tests-config.php
./vendor/bin/phpunit -c ${TESTS_DIR}/phpunit.xml.dist
