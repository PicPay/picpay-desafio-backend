from rest_framework import serializers
from .models import *

class SaldoUserSerializer(serializers.ModelSerializer):
    class Meta:
        model = SaldoUser
        fields = fields = '__all__'

class UsuarioSerializer(serializers.ModelSerializer):
    saldoUser = SaldoUserSerializer(many=True, read_only=True, source='saldouser_set')

    class Meta:
        model = Usuario
        fields = ['id', 'nome', 'cpf_cnpj', 'email', 'tipo_usuario', 'saldoUser']
        read_only_fields = ['is_active']

class TipoUsuarioSerializer(serializers.ModelSerializer):
    class Meta:
        model = TipoUsuario
        fields = '__all__'

class AutorizacaoSerializer(serializers.ModelSerializer):
    class Meta:
        model = Autorizacao
        fields = '__all__'

class UsuarioAutorizacaoSerializer(serializers.ModelSerializer):
    class Meta:
        model = UsuarioAutorizacao
        fields = '__all__'
