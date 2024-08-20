CREATE TABLE arquivo_chamado( 
      id  INT IDENTITY    NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      chamado_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE atendente( 
      id  INT IDENTITY    NOT NULL  , 
      system_user_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      email nvarchar(max)   NOT NULL  , 
      descricao nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE chamado( 
      id  INT IDENTITY    NOT NULL  , 
      solicitante_id int   NOT NULL  , 
      status_id int   NOT NULL  , 
      prioridade_id int   NOT NULL  , 
      produto_id int   NOT NULL  , 
      categoria_id int   NOT NULL  , 
      dt_abertura datetime2   NOT NULL  , 
      observacao_abertura nvarchar(max)   NOT NULL  , 
      atendente_id int   , 
      tipo_problema_id int   , 
      tipo_solucao_id int   , 
      dt_fechamento datetime2   , 
      observacao_finalizacao nvarchar(max)   , 
      tempo_trabalho time   , 
      recorente char  (1)     DEFAULT 'F', 
      mes_abertura nvarchar(max)   , 
      ano_abertura nvarchar(max)   , 
      anomes_abertura nvarchar(max)   , 
      ano_fechamento nvarchar(max)   , 
      mes_fechamento nvarchar(max)   , 
      anomes_fechamento int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente( 
      id  INT IDENTITY    NOT NULL  , 
      segmento_id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente_produto( 
      id  INT IDENTITY    NOT NULL  , 
      produto_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE nota( 
      id  INT IDENTITY    NOT NULL  , 
      observacao nvarchar(max)   NOT NULL  , 
      dt_nota datetime2   NOT NULL  , 
      chamado_id int   NOT NULL  , 
      cliente_id int   , 
      atendente_id int   , 
      anexo nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE prioridade( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      cor nvarchar(max)   NOT NULL  , 
      ordem int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE segmento( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      cor nvarchar(max)   NOT NULL  , 
      estado_inicial char  (1)   NOT NULL    DEFAULT 'F', 
      estado_final char  (1)   NOT NULL    DEFAULT 'F', 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE template( 
      id  INT IDENTITY    NOT NULL  , 
      chave varchar  (255)   NOT NULL  , 
      template nvarchar(max)   NOT NULL  , 
      titulo nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_problema( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_solucao( 
      id  INT IDENTITY    NOT NULL  , 
      nome nvarchar(max)   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

 
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
