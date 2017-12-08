FROM prestashop/prestashop:1.6

RUN rm -f -r install

RUN rm -f -r admin

COPY przedlando/ .

RUN chmod -R 777 .

EXPOSE 80
