#!/usr/bin/env bash
docker-compose up -d nginx php-fpm mongo elasticsearch workspace

# docker-compose up -d nginx php-fpm mongo elasticsearch influxdb grafana workspace