FROM elasticsearch:8.5.1

COPY ./elasticsearch.yml /usr/share/elasticsearch/config/elasticsearch.yml

WORKDIR /usr/share/elasticsearch

USER root

RUN chown -R 1000:1000 /usr/share/elasticsearch
RUN chmod -R 777 /usr/share/elasticsearch

USER elasticsearch
