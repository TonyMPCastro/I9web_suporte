CREATE TABLE arquivo_chamado( 
      id  SERIAL    NOT NULL  , 
      name text   NOT NULL  , 
      chamado_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE atendente( 
      id  SERIAL    NOT NULL  , 
      system_user_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      email text   NOT NULL  , 
      descricao text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE chamado( 
      id  SERIAL    NOT NULL  , 
      solicitante_id integer   NOT NULL  , 
      status_id integer   NOT NULL  , 
      prioridade_id integer   NOT NULL  , 
      produto_id integer   NOT NULL  , 
      categoria_id integer   NOT NULL  , 
      dt_abertura timestamp   NOT NULL  , 
      observacao_abertura text   NOT NULL  , 
      atendente_id integer   , 
      tipo_problema_id integer   , 
      tipo_solucao_id integer   , 
      dt_fechamento timestamp   , 
      observacao_finalizacao text   , 
      tempo_trabalho time   , 
      recorente char  (1)     DEFAULT 'F', 
      mes_abertura text   , 
      ano_abertura text   , 
      anomes_abertura text   , 
      ano_fechamento text   , 
      mes_fechamento text   , 
      anomes_fechamento integer   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente( 
      id  SERIAL    NOT NULL  , 
      segmento_id integer   NOT NULL  , 
      system_user_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente_produto( 
      id  SERIAL    NOT NULL  , 
      produto_id integer   NOT NULL  , 
      cliente_id integer   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE nota( 
      id  SERIAL    NOT NULL  , 
      observacao text   NOT NULL  , 
      dt_nota timestamp   NOT NULL  , 
      chamado_id integer   NOT NULL  , 
      cliente_id integer   , 
      atendente_id integer   , 
      anexo text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE prioridade( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      cor text   NOT NULL  , 
      ordem integer   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE segmento( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      cor text   NOT NULL  , 
      estado_inicial char  (1)   NOT NULL    DEFAULT 'F', 
      estado_final char  (1)   NOT NULL    DEFAULT 'F', 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE template( 
      id  SERIAL    NOT NULL  , 
      chave varchar  (255)   NOT NULL  , 
      template text   NOT NULL  , 
      titulo text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_problema( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_solucao( 
      id  SERIAL    NOT NULL  , 
      nome text   NOT NULL  , 
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
 
 CREATE index idx_arquivo_chamado_chamado_id on arquivo_chamado(chamado_id); 
CREATE index idx_chamado_solicitante_id on chamado(solicitante_id); 
CREATE index idx_chamado_atendente_id on chamado(atendente_id); 
CREATE index idx_chamado_status_id on chamado(status_id); 
CREATE index idx_chamado_tipo_problema_id on chamado(tipo_problema_id); 
CREATE index idx_chamado_tipo_solucao_id on chamado(tipo_solucao_id); 
CREATE index idx_chamado_produto_id on chamado(produto_id); 
CREATE index idx_chamado_categoria_id on chamado(categoria_id); 
CREATE index idx_chamado_prioridade_id on chamado(prioridade_id); 
CREATE index idx_cliente_segmento_id on cliente(segmento_id); 
CREATE index idx_cliente_produto_produto_id on cliente_produto(produto_id); 
CREATE index idx_cliente_produto_cliente_id on cliente_produto(cliente_id); 
CREATE index idx_nota_chamado_id on nota(chamado_id); 
CREATE index idx_nota_cliente_id on nota(cliente_id); 
CREATE index idx_nota_atendente_id on nota(atendente_id); 
