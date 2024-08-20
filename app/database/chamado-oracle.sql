CREATE TABLE arquivo_chamado( 
      id number(10)    NOT NULL , 
      name varchar(3000)    NOT NULL , 
      chamado_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE atendente( 
      id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE categoria( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      email varchar(3000)    NOT NULL , 
      descricao varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE chamado( 
      id number(10)    NOT NULL , 
      solicitante_id number(10)    NOT NULL , 
      status_id number(10)    NOT NULL , 
      prioridade_id number(10)    NOT NULL , 
      produto_id number(10)    NOT NULL , 
      categoria_id number(10)    NOT NULL , 
      dt_abertura timestamp(0)    NOT NULL , 
      observacao_abertura varchar(3000)    NOT NULL , 
      atendente_id number(10)   , 
      tipo_problema_id number(10)   , 
      tipo_solucao_id number(10)   , 
      dt_fechamento timestamp(0)   , 
      observacao_finalizacao varchar(3000)   , 
      tempo_trabalho time   , 
      recorente char  (1)    DEFAULT 'F' , 
      mes_abertura varchar(3000)   , 
      ano_abertura varchar(3000)   , 
      anomes_abertura varchar(3000)   , 
      ano_fechamento varchar(3000)   , 
      mes_fechamento varchar(3000)   , 
      anomes_fechamento number(10)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente( 
      id number(10)    NOT NULL , 
      segmento_id number(10)    NOT NULL , 
      system_user_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente_produto( 
      id number(10)    NOT NULL , 
      produto_id number(10)    NOT NULL , 
      cliente_id number(10)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE nota( 
      id number(10)    NOT NULL , 
      observacao varchar(3000)    NOT NULL , 
      dt_nota timestamp(0)    NOT NULL , 
      chamado_id number(10)    NOT NULL , 
      cliente_id number(10)   , 
      atendente_id number(10)   , 
      anexo varchar(3000)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE prioridade( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      cor varchar(3000)    NOT NULL , 
      ordem number(10)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE produto( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      ativo char  (1)    DEFAULT 'T'  NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE segmento( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      cor varchar(3000)    NOT NULL , 
      estado_inicial char  (1)    DEFAULT 'F'  NOT NULL , 
      estado_final char  (1)    DEFAULT 'F'  NOT NULL , 
      ativo char  (1)    DEFAULT 'T'  NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE template( 
      id number(10)    NOT NULL , 
      chave varchar  (255)    NOT NULL , 
      template varchar(3000)    NOT NULL , 
      titulo varchar(3000)    NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_problema( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      ativo char  (1)    DEFAULT 'T'  NOT NULL , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipo_solucao( 
      id number(10)    NOT NULL , 
      nome varchar(3000)    NOT NULL , 
      ativo char  (1)    DEFAULT 'T'  NOT NULL , 
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
 CREATE SEQUENCE arquivo_chamado_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER arquivo_chamado_id_seq_tr 

BEFORE INSERT ON arquivo_chamado FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT arquivo_chamado_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE atendente_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER atendente_id_seq_tr 

BEFORE INSERT ON atendente FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT atendente_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE categoria_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER categoria_id_seq_tr 

BEFORE INSERT ON categoria FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT categoria_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE chamado_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER chamado_id_seq_tr 

BEFORE INSERT ON chamado FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT chamado_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE cliente_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER cliente_id_seq_tr 

BEFORE INSERT ON cliente FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT cliente_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE cliente_produto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER cliente_produto_id_seq_tr 

BEFORE INSERT ON cliente_produto FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT cliente_produto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE nota_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER nota_id_seq_tr 

BEFORE INSERT ON nota FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT nota_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE prioridade_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER prioridade_id_seq_tr 

BEFORE INSERT ON prioridade FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT prioridade_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE produto_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER produto_id_seq_tr 

BEFORE INSERT ON produto FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT produto_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE segmento_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER segmento_id_seq_tr 

BEFORE INSERT ON segmento FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT segmento_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE status_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER status_id_seq_tr 

BEFORE INSERT ON status FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT status_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE template_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER template_id_seq_tr 

BEFORE INSERT ON template FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT template_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_problema_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_problema_id_seq_tr 

BEFORE INSERT ON tipo_problema FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_problema_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
CREATE SEQUENCE tipo_solucao_id_seq START WITH 1 INCREMENT BY 1; 

CREATE OR REPLACE TRIGGER tipo_solucao_id_seq_tr 

BEFORE INSERT ON tipo_solucao FOR EACH ROW 

    WHEN 

        (NEW.id IS NULL) 

    BEGIN 

        SELECT tipo_solucao_id_seq.NEXTVAL INTO :NEW.id FROM DUAL; 

END;
 