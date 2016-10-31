#!/bin/bash -ex

#########################################
# INIT
#########################################

SCRIPT_URL="http://oak.cs.ucla.edu/classes/cs143/project/p1c_test"
ZIP_NAME="P1C.zip"
REQUIRED_FILES=( \
        team.txt \
        readme.txt \
        sql \
        www \
        testcase \
        )

function cleanup {
    rm -rf 904280752
    echo "Finished deploy script"
}

trap cleanup EXIT

#########################################
# MAIN
#########################################

echo "Running deploy script..."

### Reseting db
echo "DROP TABLE IF EXISTS MovieDirector, MovieGenre, Review, MovieActor, MaxPersonID, MaxMovieID, Movie, Actor, Director"  | mysql TEST
mysql TEST < ./sql/create.sql
mysql TEST < ./sql/load.sql

### Deploying up webpages
rsync -a ./www/* ~/www/

if [[ "$1" == '--submit' ]]; then
    mkdir 904280752
    cp -r ${REQUIRED_FILES[@]} 904280752
    zip -r ${ZIP_NAME} 904280752/
    rm -rf 904280752
    bash <(curl -sL ${SCRIPT_URL}) 904280752
    if [[ $? -eq 0 ]]; then
        mv ${ZIP_NAME} ~/www/ 
    fi
fi
