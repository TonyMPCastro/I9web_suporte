PRAGMA foreign_keys=OFF; 

CREATE TABLE arquivo_chamado( 
      id  INTEGER    NOT NULL  , 
      name text   NOT NULL  , 
      chamado_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(chamado_id) REFERENCES chamado(id)) ; 

CREATE TABLE atendente( 
      id  INTEGER    NOT NULL  , 
      system_user_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      email text   NOT NULL  , 
      descricao text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE chamado( 
      id  INTEGER    NOT NULL  , 
      solicitante_id int   NOT NULL  , 
      status_id int   NOT NULL  , 
      prioridade_id int   NOT NULL  , 
      produto_id int   NOT NULL  , 
      categoria_id int   NOT NULL  , 
      dt_abertura datetime   NOT NULL  , 
      observacao_abertura text   NOT NULL  , 
      atendente_id int   , 
      tipo_problema_id int   , 
      tipo_solucao_id int   , 
      dt_fechamento datetime   , 
      observacao_finalizacao text   , 
      tempo_trabalho text   , 
      recorente char  (1)     DEFAULT 'F', 
      mes_abertura text   , 
      ano_abertura text   , 
      anomes_abertura text   , 
      ano_fechamento text   , 
      mes_fechamento text   , 
      anomes_fechamento int   , 
 PRIMARY KEY (id),
FOREIGN KEY(solicitante_id) REFERENCES cliente(id),
FOREIGN KEY(atendente_id) REFERENCES atendente(id),
FOREIGN KEY(status_id) REFERENCES status(id),
FOREIGN KEY(tipo_problema_id) REFERENCES tipo_problema(id),
FOREIGN KEY(tipo_solucao_id) REFERENCES tipo_solucao(id),
FOREIGN KEY(produto_id) REFERENCES produto(id),
FOREIGN KEY(categoria_id) REFERENCES categoria(id),
FOREIGN KEY(prioridade_id) REFERENCES prioridade(id)) ; 

CREATE TABLE cliente( 
      id  INTEGER    NOT NULL  , 
      segmento_id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(segmento_id) REFERENCES segmento(id)) ; 

CREATE TABLE cliente_produto( 
      id  INTEGER    NOT NULL  , 
      produto_id int   NOT NULL  , 
      cliente_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(produto_id) REFERENCES produto(id),
FOREIGN KEY(cliente_id) REFERENCES cliente(id)) ; 

CREATE TABLE nota( 
      id  INTEGER    NOT NULL  , 
      observacao text   NOT NULL  , 
      dt_nota datetime   NOT NULL  , 
      chamado_id int   NOT NULL  , 
      cliente_id int   , 
      atendente_id int   , 
      anexo text   , 
 PRIMARY KEY (id),
FOREIGN KEY(chamado_id) REFERENCES chamado(id),
FOREIGN KEY(cliente_id) REFERENCES cliente(id),
FOREIGN KEY(atendente_id) REFERENCES atendente(id)) ; 

CREATE TABLE prioridade( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      cor text   NOT NULL  , 
      ordem int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE segmento( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      cor text   NOT NULL  , 
      estado_inicial char  (1)   NOT NULL    DEFAULT 'F', 
      estado_final char  (1)   NOT NULL    DEFAULT 'F', 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE template( 
      id  INTEGER    NOT NULL  , 
      chave varchar  (255)   NOT NULL  , 
      template text   NOT NULL  , 
      titulo text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_problema( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_solucao( 
      id  INTEGER    NOT NULL  , 
      nome text   NOT NULL  , 
      ativo char  (1)   NOT NULL    DEFAULT 'T', 
 PRIMARY KEY (id)) ; 

 
 CREATE UNIQUE INDEX unique_idx_template_chave ON template(chave);
 