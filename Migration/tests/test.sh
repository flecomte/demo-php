#!/bin/bash
options=("RESET DB" "All" "history" "Quit")
if [ -z "$1" ]; then
  PS3='Please enter your choice: '
  select ch in "${options[@]}"
  do
    opt=$ch
    break
  done
else
  opt=${options[${1}-1]}
fi

case $opt in
  "RESET DB")
      ls -1r ../src/Migrations/*/*.down.sql | xargs awk 'FNR==1{print "--------------------"}1' > ./allSQL.sql
      awk 'FNR==1{print "--------------------"}1' ../src/Migrations/*/*.up.sql >> ./allSQL.sql
      docker exec -i yst_postgresql-dev psql test test -q -b -v "ON_ERROR_STOP=1" < ./allSQL.sql
      rm ./allSQL.sql
      echo -e "\e[92mReset DB done\e[0m"
      ;;
  "All")
      echo "Start ALL tests"
      awk 'FNR==1{print ";--------------------"}1' \
        ../src/Functions/*/*.sql \
        ./sql/*.sql > ./allSQL.sql
      docker exec -i yst_postgresql-dev psql test test -q -b -v "ON_ERROR_STOP=1" < ./allSQL.sql
      rm ./allSQL.sql
      echo -e "\e[92mAll tests done\e[0m"
      ;;
  "Quit")
      ;;
  *)
    echo "Start tests $opt"
    awk 'FNR==1{print ";--------------------"}1' \
        ../src/Functions/*/*.sql \
        ./sql/*.sql > ./allSQL.sql
    docker exec -i yst_postgresql-dev psql test test -q -b -v "ON_ERROR_STOP=1" < ./allSQL.sql
    rm ./allSQL.sql
    echo -e "\e[92mTest \"$opt\" done\e[0m"
    ;;
esac