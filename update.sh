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
# rsync -ruv --exclude wordpress/wp-content/uploads/ wordpress/wp-content/* mt:~/domains/sandbox.hipurefiltration.com/html/wp-content/
rsync -ruv wordpress/wp-content/* mt:~/domains/sandbox.hipurefiltration.com/html/wp-content/
success

printf "Dumping Wordpress DB..."
mysqldump --compatible=mysql4 -P 9001 -h 127.0.0.1 -u wordpress -pwordpress wordpress > db_dump.sql
success

printf "Swapping Out Docker URL in Dump...."
sed -i "" "s|http://localhost:9000|http://sandbox.hipurefiltration.com|g" db_dump.sql
success

printf "Copying DB Dump to remote...."
scp -q db_dump.sql mt:~/domains/sandbox.hipurefiltration.com/
success

printf "Backing up Remote DB..."
today=`date '+%Y_%m_%d_%H_%M_%S'`
ssh mt "mkdir -p ~/domains/sandbox.hipurefiltration.com/db_dumps; cd ~/domains/sandbox.hipurefiltration.com/db_dumps; mysqldump --compatible=mysql4 -h internal-db.s87759.gridserver.com -u wordpress_hf8M1A -pOKWKUJmQ db87759_1clk_wordpress_iixdJdFIw5XpV4Am7 > \"db_bak_$today.sql\""
success

printf "Loading From Dump...."
ssh mt "mysql -h internal-db.s87759.gridserver.com -u wordpress_hf8M1A -pOKWKUJmQ db87759_1clk_wordpress_iixdJdFIw5XpV4Am7 < ~/domains/sandbox.hipurefiltration.com/db_dump.sql"
success

printf "Removing db_dump...."
ssh mt "rm ~/domains/sandbox.hipurefiltration.com/db_dump.sql"
success

printf "Removing Local Dump...."
rm db_dump.sql
success
