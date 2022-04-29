FROM ubuntu:20.04
LABEL name="Chellapandi S" email="chellapandi.soundarapandian@amnet-systems.com"
ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update
RUN apt-get install -y php7.4-common php7.4-mysql
RUN apt-get install -y apache2
RUN apt-get install -y libapache2-mod-php
RUN a2enmod rewrite
RUN a2enmod headers
RUN mkdir /log /data -p
EXPOSE 80
