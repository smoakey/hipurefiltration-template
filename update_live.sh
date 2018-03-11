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
rsync -ruv wordpress/wp-content/themes/jeffersonrise/ jeffrise:~/public_html/wp-content/themes/jeffersonrise/
success

# printf "Copying WP content files from dev to local..."
# rsync -ruv mt:~/domains/jeffersonrise.christophersmoak.me/html/wp-content/* ~/Desktop/wp-content
# success
#
# printf "Copying WP content files from local to remote..."
# rsync -ruv ~/Desktop/wp-content jeffrise:~/public_html/wp-content/
# success

# printf "Dumping Wordpress DB..."
# ssh mt "mysqldump --compatible=mysql4 -h internal-db.s87759.gridserver.com -u 1clk_wp_gHX23aD -psEFJ73Ek db87759_wp > \"db_dump.sql\""
# success
#
# printf "Swapping Out DEV URL in Dump...."
# ssh mt "sed -i 's|http://jeffersonrise.christophersmoak.me|http://jeffersonrise.org|g' db_dump.sql"
# success
#
# printf "Copying DB Dump from dev to local...."
# scp -q mt:~/db_dump.sql ~/
# success
#
# printf "Copying DB Dump from local to remote...."
# scp -q ~/db_dump.sql jeffrise:~
# success
#
# printf "Loading From Dump...."
# ssh jeffrise "mysql -h 127.0.0.01 -u csmoak -pLaX12345 i451401_wp1 < ~/db_dump.sql"
# success
#
# printf "Removing Remote dump...."
# ssh jeffrise "rm ~/db_dump.sql"
# success
#
# printf "Removing DEV dump...."
# ssh mt "rm ~/db_dump.sql"
# success
#
# printf "Removing Local Dump...."
# rm ~/db_dump.sql
# success
