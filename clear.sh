#!/bin/sh
sudo docker rmi -f $(sudo docker images -q)
sudo docker rm -f $(sudo docker ps -a -q)
#sudo docker-compose rm -f -v -s
