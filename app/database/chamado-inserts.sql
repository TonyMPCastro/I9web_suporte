INSERT INTO atendente (id,system_user_id) VALUES (1,1); 

INSERT INTO categoria (id,nome,email,descricao) VALUES (1,'Software','software@teste.com.br',''); 

INSERT INTO categoria (id,nome,email,descricao) VALUES (2,'Hardware','hardware@teste.com.br',''); 

INSERT INTO categoria (id,nome,email,descricao) VALUES (3,'Rede','rede@teste.com.br',''); 

INSERT INTO chamado (id,solicitante_id,status_id,prioridade_id,produto_id,categoria_id,dt_abertura,observacao_abertura,atendente_id,tipo_problema_id,tipo_solucao_id,dt_fechamento,observacao_finalizacao,tempo_trabalho,recorente,mes_abertura,ano_abertura,anomes_abertura,ano_fechamento,mes_fechamento,anomes_fechamento) VALUES (1,1,6,1,1,1,'2022-07-01 10:00','Problemas teste',1,1,1,'2022-07-01 16:00','Resolvido!','01:00','F','07','2022','202207','07','2022',202207); 

INSERT INTO cliente (id,segmento_id,system_user_id) VALUES (1,1,2); 

INSERT INTO cliente (id,segmento_id,system_user_id) VALUES (2,5,1); 

INSERT INTO cliente_produto (id,produto_id,cliente_id) VALUES (1,1,1); 

INSERT INTO cliente_produto (id,produto_id,cliente_id) VALUES (2,2,1); 

INSERT INTO cliente_produto (id,produto_id,cliente_id) VALUES (3,3,1); 

INSERT INTO cliente_produto (id,produto_id,cliente_id) VALUES (4,4,1); 

INSERT INTO cliente_produto (id,produto_id,cliente_id) VALUES (5,4,2); 

INSERT INTO prioridade (id,nome,cor,ordem) VALUES (1,'Alta','#f44336',1); 

INSERT INTO prioridade (id,nome,cor,ordem) VALUES (2,'Média','#2196f3',2); 

INSERT INTO prioridade (id,nome,cor,ordem) VALUES (3,'Baixa','#4caf50',3); 

INSERT INTO produto (id,nome,ativo) VALUES (1,'I9Sellz','T'); 

INSERT INTO produto (id,nome,ativo) VALUES (2,'ProtocoloWeb','T'); 

INSERT INTO produto (id,nome,ativo) VALUES (3,'Site Oficial','T'); 

INSERT INTO produto (id,nome,ativo) VALUES (4,'Tributos','T'); 

INSERT INTO segmento (id,nome) VALUES (1,'Setor público'); 

INSERT INTO segmento (id,nome) VALUES (2,'Serviços'); 

INSERT INTO segmento (id,nome) VALUES (3,'Agro'); 

INSERT INTO segmento (id,nome) VALUES (4,'Alimentação'); 

INSERT INTO segmento (id,nome) VALUES (5,'Metal mecânico'); 

INSERT INTO segmento (id,nome) VALUES (6,'Químico'); 

INSERT INTO segmento (id,nome) VALUES (7,'Construção civil'); 

INSERT INTO status (id,nome,cor,estado_inicial,estado_final,ativo) VALUES (1,'Aberto','#009688','T','F','T'); 

INSERT INTO status (id,nome,cor,estado_inicial,estado_final,ativo) VALUES (2,'Em atendimento','#4caf50','F','F','T'); 

INSERT INTO status (id,nome,cor,estado_inicial,estado_final,ativo) VALUES (3,'Aguardando','#2196f3','F','F','T'); 

INSERT INTO status (id,nome,cor,estado_inicial,estado_final,ativo) VALUES (4,'Aguardando cliente','#cddc39','F','F','T'); 

INSERT INTO status (id,nome,cor,estado_inicial,estado_final,ativo) VALUES (5,'Rejeitado','#f44336','F','T','T'); 

INSERT INTO status (id,nome,cor,estado_inicial,estado_final,ativo) VALUES (6,'Fechado','#607d8b','F','T','T'); 

INSERT INTO template (id,chave,template,titulo) VALUES (1,'EMAIL_ABERTURA_CHAMADO','Novo chamado aberto para a categoria {$categoria_nome}<br/> <br/> <br/> ID: <b>{$id}</b><br/> Solicitante: <b>{$solicitante}</b><br/> <br/> {$observacao_abertura}<br/> <br/> <br/>','Novo chamado'); 

INSERT INTO template (id,chave,template,titulo) VALUES (2,'EMAIL_FECHAMENTO_CHAMADO','Chamado finalizado<br/> <br/> <br/> ID: <b>{$id}</b><br/> Situação: <b>{$estado}</b><br/> <br/> {$observacao_finalizacao}<br/> <br/> <br/>','Chamado finalizado'); 

INSERT INTO template (id,chave,template,titulo) VALUES (3,'NOTIFICACAO_NOVA_NOTA',' Nova nota',' Nova nota'); 

INSERT INTO template (id,chave,template,titulo) VALUES (4,'EMAIL_NOVA_NOTA',' Nova nota',' Nova nota'); 

INSERT INTO tipo_problema (id,nome,ativo) VALUES (1,'Software indisponivel','T'); 

INSERT INTO tipo_problema (id,nome,ativo) VALUES (2,'Regra de negócio falha','T'); 

INSERT INTO tipo_problema (id,nome,ativo) VALUES (3,'Bug','T'); 

INSERT INTO tipo_problema (id,nome,ativo) VALUES (4,'Erro em Tela','T'); 

INSERT INTO tipo_problema (id,nome,ativo) VALUES (5,'Computador não liga','T'); 

INSERT INTO tipo_problema (id,nome,ativo) VALUES (6,'Relatório errado','T'); 

INSERT INTO tipo_problema (id,nome,ativo) VALUES (7,'Problemas de rede','T'); 

INSERT INTO tipo_solucao (id,nome,ativo) VALUES (1,'Instruções ao usuário','T'); 

INSERT INTO tipo_solucao (id,nome,ativo) VALUES (2,'Corrigido com patch','T'); 

INSERT INTO tipo_solucao (id,nome,ativo) VALUES (3,'Adicionado ao roadmap','T'); 

INSERT INTO tipo_solucao (id,nome,ativo) VALUES (4,'Serviços reiniciados','T'); 

INSERT INTO tipo_solucao (id,nome,ativo) VALUES (5,'Manutenção em equipamento','T'); 

INSERT INTO tipo_solucao (id,nome,ativo) VALUES (6,'Substituição de equipamento','T'); 
