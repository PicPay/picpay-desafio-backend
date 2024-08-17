#!/bin/bash
python manage.py makemigrations
python manage.py migrate --no-input
python manage.py collectstatic --noinput
gunicorn backendpicpay.wsgi:application --bind 0.0.0.0:8000
