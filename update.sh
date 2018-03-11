#!/bin/bash

GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

function success {
    printf "${GREEN}DONE!${NC}\n"
}

printf "Building client..."
npm run build
success

printf "Copying WP content files to remote..."
rsync -ruv --exclude wordpress/wp-content/uploads/ wordpress/wp-content/* mt:~/domains/jeffersonrise.christophersmoak.me/html/wp-content/
success

# printf "Dumping Wordpress DB..."
# mysqldump --compatible=mysql4 -P 9001 -h 127.0.0.1 -u wordpress -pwordpress wordpress > db_dump.sql
# success
#
# printf "Swapping Out Docker URL in Dump...."
# sed -i "" "s|http://localhost:9000|http://jeffersonrise.christophersmoak.me|g" db_dump.sql
# success
#
# printf "Copying DB Dump to remote...."
# scp -q db_dump.sql mt:~/domains/jeffersonrise.christophersmoak.me/
# success
#
# printf "Backing up Remote DB..."
# today=`date '+%Y_%m_%d_%H_%M_%S'`
# ssh mt "cd ~/domains/jeffersonrise.christophersmoak.me/db_dumps; mysqldump --compatible=mysql4 -h internal-db.s87759.gridserver.com -u 1clk_wp_gHX23aD -psEFJ73Ek db87759_wp > \"db_bak_$today.sql\""
# success
#
# printf "Loading From Dump...."
# ssh mt "mysql -h internal-db.s87759.gridserver.com -u 1clk_wp_gHX23aD -psEFJ73Ek db87759_wp < ~/domains/jeffersonrise.christophersmoak.me/db_dump.sql"
# success
#
# printf "Removing db_dump...."
# ssh mt "rm ~/domains/jeffersonrise.christophersmoak.me/db_dump.sql"
# success
#
# printf "Removing Local Dump...."
# rm db_dump.sql
# success
