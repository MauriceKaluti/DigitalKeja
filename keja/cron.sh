#!/bin/bash
while true; do
    begin=`date +%s`
    php artisan schedule:run
    end=`date +%s`
    if [ $(($end - $begin)) -lt 86400 ]; then
        sleep $(($begin + 86400 - $end))
    fi
done
