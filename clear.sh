#!/bin/sh
sudo docker rmi -f $(sudo docker images -q)
sudo docker rm -fv $(sudo docker ps -a -q)
#sudo docker-compose rm -f -v -s
