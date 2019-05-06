#!/bin/bash

/usr/bin/rsync -a -v -u "/var/www/scm/supreme/upload/" "/var/www/eproc/public_html/supreme/upload/"
/usr/bin/rsync -a -v -u "/var/www/eproc/public_html/supreme/upload/" "/var/www/scm/supreme/upload/"
