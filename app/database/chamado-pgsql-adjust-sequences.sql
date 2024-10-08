SELECT setval('arquivo_chamado_id_seq', coalesce(max(id),0) + 1, false) FROM arquivo_chamado;
SELECT setval('atendente_id_seq', coalesce(max(id),0) + 1, false) FROM atendente;
SELECT setval('categoria_id_seq', coalesce(max(id),0) + 1, false) FROM categoria;
SELECT setval('chamado_id_seq', coalesce(max(id),0) + 1, false) FROM chamado;
SELECT setval('cliente_id_seq', coalesce(max(id),0) + 1, false) FROM cliente;
SELECT setval('cliente_produto_id_seq', coalesce(max(id),0) + 1, false) FROM cliente_produto;
SELECT setval('nota_id_seq', coalesce(max(id),0) + 1, false) FROM nota;
SELECT setval('prioridade_id_seq', coalesce(max(id),0) + 1, false) FROM prioridade;
SELECT setval('produto_id_seq', coalesce(max(id),0) + 1, false) FROM produto;
SELECT setval('segmento_id_seq', coalesce(max(id),0) + 1, false) FROM segmento;
SELECT setval('status_id_seq', coalesce(max(id),0) + 1, false) FROM status;
SELECT setval('template_id_seq', coalesce(max(id),0) + 1, false) FROM template;
SELECT setval('tipo_problema_id_seq', coalesce(max(id),0) + 1, false) FROM tipo_problema;
SELECT setval('tipo_solucao_id_seq', coalesce(max(id),0) + 1, false) FROM tipo_solucao;