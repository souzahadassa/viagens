API de Usuários


1. Identificação
Nome completo do aluno: Hadassa Maria Souza
Curso: 2 Técnico em Informática
Unidade Curricular: Desenvolver Serviços Web


3. Como instalar as dependências
Requisitos
PHP não instalado no computador;
Composer instalado;
Postman para testar as requisições da API.
Passos para instalação
Baixe ou clone o repositório do projeto para o computador.
Abra o terminal na pasta raiz do projeto, onde está localizado o arquivo composer.json.
Execute o comando abaixo para instalar as dependências:
Caso as dependências do Slim ainda não estejam instaladas, execute:
Inicie o servidor PHP usando o arquivo principal da API. Ajuste o caminho conforme a localização do arquivo no projeto.
Abra o Postman e envie uma requisição GET para:
http://localhost:8080/status
Se a instalação e a execução forem corretas, a API retornará uma mensagem informando que está funcionando.


4. Decisões Técnicas
Uma API foi desenvolvida utilizando PHP e Slim Framework 4, permitindo a criação de rotas para realização de operações relacionadas ao gerenciamento de usuários por meio de requisições HTTP.
Os dados são retornados no formato JSON, facilitando a comunicação entre a API e ferramentas de teste, como o Postman.
Nesta versão, os usuários são armazenados temporariamente em um array PHP, sem conexão com um banco de dados. Dessa forma, as alterações realizadas durante a execução não são mantidas após o encerramento ou reinício da aplicação.
As funcionalidades inovadoras são:
GET /status: verifica se a API está funcionando.
GET /usuários: lista todos os usuários cadastrados.
GET /usuários/{id}: consulta um usuário específico pelo identificador.
POST /usuários: cadastrar um novo usuário.
PUT /usuarios/{id}: atualiza os dados de um usuário.
DELETE /usuarios/{id}: remove um usuário.
POST /login: verifica as credenciais informadas para autenticação.
PUT /usuarios/{id}/senha: permite alterar a senha de um usuário após a validação da senha atual.
O projeto também realiza validações dos campos obrigatórios e utiliza códigos de status HTTP para indicar o resultado das operações, como 200 para sucesso, 201 para criação, 400 para requisições inválidas, 401 para falhas de autenticação e 404 quando um usuário não é encontrado.
Para evitar a exposição direta das senhas nas respostas de consulta, os valores são substituídos por asteriscos. Entretanto, em uma aplicação real, é necessário armazenar as senhas de maneira segura, utilizando funções como password_hash()e password_verify().
