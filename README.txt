Teste realizado por Gabriel Longhi para a Finnet

Por questões pessoais não consegui terminar o projeto, portanto tentei deixar de um jeito que conseguisse demonstrar o que eu queria fazer e o quanto eu conheço do assunto, espero que eu tenha conseguido. Esse projeto foi feito do zero à partir do dia que foi pedido.

E o que também aconteceu foi que na entrevista eu acabei me expressando mal, na minha faculdade só é usado Java, onde eu criei CRUDs com MVC, e como eu não tenho o costume para fazer com PHP, acabou me atrapalhando um pouco.

Foi usado o VSCode e o MySQL como banco de dados, para rostear o server php usei a extensão "PHP Server", criada por brapifra, usando a porta 3000. Nesta extensão foi necessário para mim especificar onde o PHP.exe e o PHP.ini estavam em meu projeto, inclusive, é necessário tirar o ';' da extensão pdo_mysql no php.ini para rodar o projeto

Quanto ao banco de dados, é necessário criar um database chamado 'projeto_mvc' e uma tabela chamada 'tb_curso', segue especificações da tabela:

-id (primary key, not null e auto increment)
-nome_curso (not null)
-descricao (sem especificações)

Também será necessário trocar o arquivo .env e .env.example, basta recolocar os itens com suas especificações (não mude-os de lugar, apenas reescreva).

O arquivo do composer ja possui os dois requires que eu baixei.

O layout está visualmente do jeito que eu planejo que ficaria no fim do projeto.

Caso apareça "URL não encontrada" ao abrir o index.php, coloque uma '/' no final, o meu ficou assim:
http://localhost:3000/index.php/

E sempre abra o projeto pelo index.php.