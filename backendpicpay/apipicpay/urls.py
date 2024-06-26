from django.urls import path
from rest_framework.routers import SimpleRouter
from .views_v1 import *

# router = SimpleRouter()
# router.register('usuarios', UsuarioAutorizacaoListCreate)

urlpatterns = [
    path('usuarios/', UsuarioListCreate.as_view(), name='usuario-list-create'),
    path('usuarios/<int:pk>/', UsuarioDetail.as_view(), name='usuario-detail'),
    path('usuarios/<int:pk>/chavepix/', ChavePixDetail.as_view(), name='chavepix-detail'),
    # path('auth/', include('rest_framework.urls')),
]