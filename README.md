# Fecipan

Este sistema foi implementado com Laravel 5.3 e roda com PHP 7.1 e MySQL. 

Antes de executar o sistema, abra o PhpMyAdmin e crie um banco de dados vazio, com o nome "fecipan_2018" usando agrupamento (collation) "utf8_general_ci"). A estrutura e os dados iniciais do banco de dados serão gerados ao executar o arquivo "migration.bat"

Para trabalhar no sistema, execute o arquivo "inicia.bat". Este arquivo prepara o servidor PHP para dar suporte ao sistema. O endereço inicial do sistema é "localhost:2018"

Na primeira execução, o sistema fará o cadastro do Usuário Administrador. Use este usuário para cadastrar os outros usuários do sistema. Os perfis mais importantes são:
  1 - Organizador - Este usuário cria e gerencia Eventos e seus Quesitos de Avaliação, cadastra Áreas (Ciências Exatas, Ciências Biológicas, etc), Categorias (Ensino Fundamental, Ensino Médio) e Tipos de Trabalhos (Pesquisa Científica, etc). Além disso, este usuário é capaz de cadastrar Trabalhos, Orientadores, Estudantes e Avaliadores. Eventualmente este usuário pode ser utilizado para lançar as Notas dos Trabalhos e gerenciar as Avaliações.
  2 - Auxiliar de Avaliação - Este usuário visualiza os Trabalhos em um Evento e pode ser utilizado para lançar Notas e gerenciar as Avaliações.
