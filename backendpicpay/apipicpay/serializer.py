from rest_framework import serializers
from .models import *

class TipoUsuarioSerializer(serializers.ModelSerializer):
    class Meta:
        model = TipoUsuario
        fields = '__all__'

class AutorizacaoSerializer(serializers.ModelSerializer):
    class Meta:
        model = Autorizacao
        fields = '__all__'

class UsuarioSerializer(serializers.ModelSerializer):
    class Meta:
        model = Usuario
        fields = ['id', 'nome', 'cpf_cnpj', 'email', 'tipo_usuario']
        read_only_fields = ['is_active']

class UsuarioAutorizacaoSerializer(serializers.ModelSerializer):
    class Meta:
        model = UsuarioAutorizacao
        fields = '__all__'
