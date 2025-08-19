-- Execute estes comandos no MySQL para habilitar os recursos de ativar/desativar
ALTER TABLE formularios ADD COLUMN IF NOT EXISTS ativo TINYINT(1) NOT NULL DEFAULT 1;
ALTER TABLE campos ADD COLUMN IF NOT EXISTS ativo TINYINT(1) NOT NULL DEFAULT 1;
ALTER TABLE respostas ADD COLUMN IF NOT EXISTS criado_em DATETIME NULL;
