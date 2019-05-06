#!/bin/bash

$(/usr/bin/mysql -h localhost -u root < /var/www/eproc-dev/public_html/dev_user/app12/sync_sql/SQL_CRON.sql)
