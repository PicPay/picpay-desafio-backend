from django.db import models
from django.dispatch import receiver
from django.db.models.signals import post_save, pre_save

class TipoUsuario(models.Model):
    tipo = models.CharField(max_length=50, unique=True)

    def __str__(self):
        return self.tipo

#============================================
    
class Autorizacao(models.Model):
    TIPO_AUTORIZACAO_CHOICES = [
        ('transicao', 'Transição'),
    ]

    autorizacao = models.CharField(max_length=50, choices=TIPO_AUTORIZACAO_CHOICES, default='transicao')
    tipo_usuario = models.ForeignKey(TipoUsuario, on_delete=models.CASCADE)
    autorizado = models.BooleanField(default=False)

    def __str__(self):
        return f"{self.autorizado} - Autorizado: {self.autorizado}"

#============================================

class Usuario(models.Model):
    nome = models.CharField(max_length=100)
    cpf_cnpj = models.CharField(max_length=14, unique=True)
    email = models.EmailField(max_length=100)
    tipo_usuario = models.ForeignKey(TipoUsuario, on_delete=models.SET_NULL, null=True, blank=True)

    is_active = models.BooleanField(default=True)

    def __str__(self):
        return self.nome

    def has_perm(self, perm, obj=None):
        return True

    def has_module_perms(self, app_label):
        return True

#============================================
    
class UsuarioAutorizacao(models.Model):
    usuario = models.OneToOneField(Usuario, on_delete=models.CASCADE)
    tipo_usuario = models.ForeignKey(TipoUsuario, on_delete=models.CASCADE)
    autorizado = models.BooleanField(default=False)

    def __str__(self):
        return f"{self.usuario.nome} - {self.tipo_usuario.tipo}"
    
# gerencia todas as autorizações da qual o usuario tem
@receiver(post_save, sender=Usuario)
def criar_usuario_autorizacao(sender, instance, created, **kwargs):
    if created:
        tipo_usuario = instance.tipo_usuario
        autorizacao = Autorizacao.objects.get(tipo_usuario=tipo_usuario)
        UsuarioAutorizacao.objects.create(usuario=instance, tipo_usuario=tipo_usuario, autorizado=autorizacao.autorizado)

#============================================

class ChavePix(models.Model):
    id_user = models.ForeignKey(Usuario, on_delete=models.CASCADE)
    cpf = models.CharField(max_length=14, unique=True)
    numero = models.CharField(max_length=50, unique=True)
    email = models.EmailField(max_length=100, unique=True)
    chave_aleatoria = models.CharField(max_length=50, unique=True)

    def __str__(self):
        return f"ChavePix de {self.email}"
    
# ao ser criada uma nova pix ele é associada ao usúario da qual criou ela
@receiver(post_save, sender=ChavePix)
def atualizar_chave_pix_id(sender, instance, created, **kwargs):
    if created:
        SaldoUser.objects.filter(usuario=instance.id_user).update(chave_pix=instance)

#============================================

class SaldoUser(models.Model):
    usuario = models.ForeignKey(Usuario, on_delete=models.CASCADE)
    saldo = models.DecimalField(max_digits=12, decimal_places=2, default=0.00)
    ativo = models.BooleanField()
    autorizado = models.ForeignKey(UsuarioAutorizacao, on_delete=models.SET_NULL, null=True, blank=True)
    chave_pix = models.ForeignKey(ChavePix, on_delete=models.SET_NULL, null=True, blank=True)

    def __str__(self):
        return f"Saldo de {self.usuario.nome}: {self.saldo}" 

@receiver(post_save, sender=Usuario)
def create_saldo_user(sender, instance, created, **kwargs):
    if created:
        # Verifica se existe uma instancia de UsuarioAutorizacao associada
        usuario_autorizacao = instance.usuarioautorizacao if hasattr(instance, 'usuarioautorizacao') else None

        # Cria um registro SaldoUser para o novo usuário
        SaldoUser.objects.create(
            usuario=instance,
            saldo=0.00,
            ativo=instance.is_active,
            autorizado=usuario_autorizacao,
        )

# Adicona sempre um valor a mais em relação ao saldo atual
@receiver(pre_save, sender=SaldoUser)
def atualizar_saldo(sender, instance, **kwargs):
    if instance.pk:
        saldo_anterior = SaldoUser.objects.get(pk=instance.pk).saldo
        instance.saldo = saldo_anterior + instance.saldo