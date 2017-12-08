#!/bin/sh
sudo docker rmi -f be-mysql
sudo docker rmi -f be-prestashop
sudo docker rm -f be-mysql
sudo docker rm -f be-prestashop

#cd be-prestashop
#rm -r -f przedlando
#git clone --depth=1 https://github.com/tomaszkononowicz/przedlando
#cd przedlando
#rm -f -r .git
#rm -f -r .gitignore
#mv backup.sql ../../be-mysql/backup.sql
#Powinien byc zrzut bazy danych z prestashopa
#cd ../../
#sudo docker build -t be-mysql be-mysql/
#sudo docker build -t be-prestashop be-prestashop/

sudo docker-compose up
