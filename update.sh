#!/bin/bash

GREEN='\033[0;32m'
RED='\033[0;31m'
NC='\033[0m'

function success {
    printf "${GREEN}DONE!${NC}\n"
}

ENV="$1"
if [ "${ENV}" = "sandbox" ]
then
  DOMAIN="sandbox.hipurefiltration.com"
  DB_USER="wordpress_hf8M1A"
  DB_PASSWORD="OKWKUJmQ"
  DB_DATABASE="db87759_1clk_wordpress_iixdJdFIw5XpV4Am7"
else  
  DOMAIN="hipurefiltration.com"
  DB_USER="wordpress_GX1LZe"
  DB_PASSWORD="mMeBEPpo"
  DB_DATABASE="db87759_1clk_wordpress_1knPNy7SC1k25JLfU"
fi 

# printf "Building client..."
# npm run build
# success

# printf "Copying WP content files to remote..."
# # rsync -ruv --exclude wordpress/wp-content/uploads/ wordpress/wp-content/* mt:~/domains/${DOMAIN}/html/wp-content/
# rsync -ruv wordpress/wp-content/* mt:~/domains/${DOMAIN}/html/wp-content/
# success

# printf "Dumping Wordpress DB..."
# mysqldump --compatible=mysql4 -P 9001 -h 127.0.0.1 -u wordpress -pwordpress wordpress > db_dump.sql
# success

# printf "Swapping Out Docker URL in Dump...."
# sed -i "" "s|http://localhost:9000|http://${DOMAIN}|g" db_dump.sql
# success

# printf "Copying DB Dump to remote...."
# scp -q db_dump.sql mt:~/domains/${DOMAIN}/
# success

# printf "Backing up Remote DB..."
# today=`date '+%Y_%m_%d_%H_%M_%S'`
# ssh mt "mkdir -p ~/domains/${DOMAIN}/db_dumps; cd ~/domains/${DOMAIN}/db_dumps; mysqldump --compatible=mysql4 -h internal-db.s87759.gridserver.com -u ${DB_USER} -p${DB_PASSWORD} ${DB_DATABASE} > \"db_bak_$today.sql\""
# success

# printf "Loading From Dump...."
# ssh mt "mysql -h internal-db.s87759.gridserver.com -u ${DB_USER} -p${DB_PASSWORD} ${DB_DATABASE} < ~/domains/${DOMAIN}/db_dump.sql"
# success

# printf "Removing db_dump...."
# ssh mt "rm ~/domains/${DOMAIN}/db_dump.sql"
# success

# printf "Removing Local Dump...."
# rm db_dump.sql
# success

printf "Updating HTACCESS..."
scp -q .htaccess mt:~/domains/${DOMAIN}/html/
success
