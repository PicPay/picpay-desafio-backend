from rest_framework import viewsets
from .models import *
from .serializer import *

class TipoUsuarioViewSet(viewsets.ModelViewSet):
    queryset = TipoUsuario.objects.all()
    serializer_class = TipoUsuarioSerializer

class AutorizacaoViewSet(viewsets.ModelViewSet):
    queryset = Autorizacao.objects.all()
    serializer_class = AutorizacaoSerializer

class UsuarioViewSet(viewsets.ModelViewSet):
    queryset = Usuario.objects.all()
    serializer_class = UsuarioSerializer

class UsuarioAutorizacaoViewSet(viewsets.ModelViewSet):
    queryset = UsuarioAutorizacao.objects.all()
    serializer_class = UsuarioAutorizacaoSerializer
