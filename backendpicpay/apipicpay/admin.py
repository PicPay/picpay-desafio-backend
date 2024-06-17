from django.contrib import admin
from .models import *

@admin.register(TipoUsuario)
class TipoUsuarioAdmin(admin.ModelAdmin):
    list_display = ['id', 'tipo']

@admin.register(Autorizacao)
class AutorizacaoAdmin(admin.ModelAdmin):
    list_display = ['id', 'autorizacao', 'tipo_usuario', 'autorizado']
    list_filter = ['tipo_usuario']
    search_fields = ['autorizacao']

@admin.register(Usuario)
class UsuarioAdmin(admin.ModelAdmin):
    list_display = ['id', 'nome', 'cpf_cnpj', 'email', 'tipo_usuario', 'is_active']
    list_filter = ['tipo_usuario', 'is_active']
    search_fields = ['nome', 'cpf_cnpj', 'email']

@admin.register(UsuarioAutorizacao)
class UsuarioAutorizacaoAdmin(admin.ModelAdmin):
    list_display = ['id', 'usuario', 'tipo_usuario', 'autorizado']
    list_filter = ['tipo_usuario', 'autorizado']
    search_fields = ['usuario__nome']

@admin.register(SaldoUser)
class SaldoUserAdmin(admin.ModelAdmin):
    list_display = ['usuario', 'saldo', 'ativo', 'autorizado', 'chave_pix']
