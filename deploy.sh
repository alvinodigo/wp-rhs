#!/bin/bash

cd /home/migracao.redehumanizasus.net/integracao/wp-rhs/
git pull

if [ $1 = 'dev' ]
then
    composer install
else
    composer install --no-dev
fi

sh compile-sass.sh
cd public
wp rewrite flush
wp language core update
cd migration-scripts
php rhs_migrations.php all
