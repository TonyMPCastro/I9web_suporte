CREATE TABLE arquivo_chamado( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `name` text   NOT NULL  , 
      `chamado_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE atendente( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `system_user_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE categoria( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
      `email` text   NOT NULL  , 
      `descricao` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE chamado( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `solicitante_id` int   NOT NULL  , 
      `status_id` int   NOT NULL  , 
      `prioridade_id` int   NOT NULL  , 
      `produto_id` int   NOT NULL  , 
      `categoria_id` int   NOT NULL  , 
      `dt_abertura` datetime   NOT NULL  , 
      `observacao_abertura` text   NOT NULL  , 
      `atendente_id` int   , 
      `tipo_problema_id` int   , 
      `tipo_solucao_id` int   , 
      `dt_fechamento` datetime   , 
      `observacao_finalizacao` text   , 
      `tempo_trabalho` time   , 
      `recorente` char  (1)     DEFAULT 'F', 
      `mes_abertura` text   , 
      `ano_abertura` text   , 
      `anomes_abertura` text   , 
      `ano_fechamento` text   , 
      `mes_fechamento` text   , 
      `anomes_fechamento` int   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE cliente( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `segmento_id` int   NOT NULL  , 
      `system_user_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE cliente_produto( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `produto_id` int   NOT NULL  , 
      `cliente_id` int   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE nota( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `observacao` text   NOT NULL  , 
      `dt_nota` datetime   NOT NULL  , 
      `chamado_id` int   NOT NULL  , 
      `cliente_id` int   , 
      `atendente_id` int   , 
      `anexo` text   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE prioridade( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
      `cor` text   NOT NULL  , 
      `ordem` int   , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE produto( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
      `ativo` char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE segmento( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE status( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
      `cor` text   NOT NULL  , 
      `estado_inicial` char  (1)   NOT NULL    DEFAULT 'F', 
      `estado_final` char  (1)   NOT NULL    DEFAULT 'F', 
      `ativo` char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE template( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `chave` varchar  (255)   NOT NULL  , 
      `template` text   NOT NULL  , 
      `titulo` text   NOT NULL  , 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_problema( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
      `ativo` char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

CREATE TABLE tipo_solucao( 
      `id`  INT  AUTO_INCREMENT    NOT NULL  , 
      `nome` text   NOT NULL  , 
      `ativo` char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci; 

 
 ALTER TABLE template ADD UNIQUE (chave);
  
 ALTER TABLE arquivo_chamado ADD CONSTRAINT fk_arquivo_chamado_1 FOREIGN KEY (chamado_id) references chamado(id); 
ALTER TABLE chamado ADD CONSTRAINT fk_chamado_1 FOREIGN KEY (solicitante_id) references cliente(id); 
ALTER TABLE chamado ADD CONSTRAINT fk_chamado_2 FOREIGN KEY (atendente_id) references atendente(id); 
ALTER TABLE chamado ADD CONSTRAINT fk_chamado_3 FOREIGN KEY (status_id) references status(id); 
ALTER TABLE chamado ADD CONSTRAINT fk_chamado_4 FOREIGN KEY (tipo_problema_id) references tipo_problema(id); 
ALTER TABLE chamado ADD CONSTRAINT fk_chamado_5 FOREIGN KEY (tipo_solucao_id) references tipo_solucao(id); 
ALTER TABLE chamado ADD CONSTRAINT fk_chamado_6 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE chamado ADD CONSTRAINT fk_chamado_7 FOREIGN KEY (categoria_id) references categoria(id); 
ALTER TABLE chamado ADD CONSTRAINT fk_chamado_8 FOREIGN KEY (prioridade_id) references prioridade(id); 
ALTER TABLE cliente ADD CONSTRAINT fk_cliente_1 FOREIGN KEY (segmento_id) references segmento(id); 
ALTER TABLE cliente_produto ADD CONSTRAINT fk_cliente_produto_1 FOREIGN KEY (produto_id) references produto(id); 
ALTER TABLE cliente_produto ADD CONSTRAINT fk_cliente_produto_2 FOREIGN KEY (cliente_id) references cliente(id); 
ALTER TABLE nota ADD CONSTRAINT fk_nota_1 FOREIGN KEY (chamado_id) references chamado(id); 
ALTER TABLE nota ADD CONSTRAINT fk_nota_2 FOREIGN KEY (cliente_id) references cliente(id); 
ALTER TABLE nota ADD CONSTRAINT fk_nota_3 FOREIGN KEY (atendente_id) references atendente(id); 
