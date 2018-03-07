#!/bin/bash
RES=`mysqladmin -s -h be-mysql --password=pussyeater ping`
while [ "$RES" != "mysqld is alive" ]; do
  echo "Wait for mysqld"
  sleep 1
  RES=`mysqladmin -s -h be-mysql --password=pussyeater ping`
done
echo "Mysqld ready"
