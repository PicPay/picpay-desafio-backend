#!/bin/bash
python manage.py migrate
gunicorn backendpicpay.wsgi:application --bind 0.0.0.0:8000
