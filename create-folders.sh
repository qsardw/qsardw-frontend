#!/bin/bash
sudo mkdir -p /qsardw/data/images
sudo mkdir -p /qsardw/data/uploads
sudo mkdir -p /var/cache/qsardw
sudo mkdir -p /var/log/qsardw
chown -R www-data.www-data /qsardw/data/uploads
chown -R www-data.www-data /var/cache/qsardw
chown -R www-data.www-data /var/log/qsardw
