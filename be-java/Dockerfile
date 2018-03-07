FROM java:8

COPY Recommendation /usr/src/biznes

WORKDIR /usr/src/biznes

RUN sh mvnw dependency:resolve

COPY wait.sh .

RUN chmod 777 wait.sh

RUN apt-get update

RUN apt-get install -y mysql-client

CMD sh wait.sh && sh mvnw package && java -jar target/biznesss-0.0.1-SNAPSHOT.jar

EXPOSE 8080
