# Form Builder (PDO revisado)

Este pacote atualiza o projeto para **PDO** com *prepared statements* e adiciona:
- Ativar/Desativar **formulários** e **campos**
- **Excluir** formulário (com deleção em cascata de respostas e campos)
- Página **gerenciar_formularios.php** para administração

## Passos

1. Importe/atualize o banco e **rode** `migrations.sql` para criar as colunas `ativo`/`criado_em` caso não existam.
2. Ajuste credenciais no `config.php` (host, db, user, pass).
3. Acesse `dashboard.php` ou `gerenciar_formularios.php` para administrar.
4. Para gerar link público de um formulário: `gerar_formulario.php?id=ID_DO_FORM`.

**Segurança**: todas as operações de escrita usam *prepared statements*. O front continua em Bootstrap 5.

Backup dos arquivos originais está em `_backup_original/`.
