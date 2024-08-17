from django.contrib import admin
from django.urls import path, include
from apipicpay.urls import urlpatterns as api_urls

urlpatterns = [
    path('admin/', admin.site.urls),
    path('api/v1/', include(api_urls)),
]
