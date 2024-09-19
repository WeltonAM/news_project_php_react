```
├── src/
│ ├── App/
│ │ ├── Adapters/
│ │ │ ├── User/
│ │ │ │ ├── LoginController.php
│ │ │ │ ├── UsuarioMiddleware.php
│ │ │ │ └── CadastrarUsuarioController.php
│ │ │ │
│ │ │ ├── Comment/
│ │ │ │ └── ComentarioController.php
│ │ │ │
│ │ │ └── News/
│ │ │   └── NoticiaController.php
│ │ │
│ │ ├── External/
│ │ │ ├── DataBase/
│ │ │ │ └── RepositorioUsuarioMySQL.php
│ │ │ │ └── RepositorioNoticiaMySQL.php
│ │ │ │ └── RepositorioComentarioMySQL.php
│ │ │ │
│ │ │ └── Auth/
│ │ │   ├── ProvedorJWT.php
│ │ │   └── ProvedorBcrypt.php
│ │ │
│ │ └── app.php
│ │
│ ├── Domain/
│ │ ├── Error/
│ │ │ └─── ErroValidacao.php
│ │ │
│ │ ├── Shared/
│ │ │ ├─── CasoDeUso.php
│ │ │ ├─── Data.php
│ │ │ ├─── Email.php
│ │ │ ├─── Entidade.php
│ │ │ ├─── Id.php
│ │ │ ├─── NomePessoa.php
│ │ │ ├─── SenhaForte.php
│ │ │ ├─── SenhaHash.php
│ │ │ ├─── TextoSimples.php
│ │ │ └─── Validador.php
│ │ │
│ │ ├── User/
│ │ │ ├──── Model/
│ │ │ │ └───── Usuairo.php
│ │ │ ├──── Provider/
│ │ │ │ ├───── ProvedorCriptografia.php
│ │ │ │ ├───── ProvedorToken.php
│ │ │ │ └───── RepositorioUsuario.php
│ │ │ └──── Service/
│ │ │   ├─── LoginUsuario.php
│ │ │   └─── CadastrarUsuario.php
│ │ │
│ │ ├── News/
│ │ │ ├──── Model/
│ │ │ │ └───── Noticia.php
│ │ │ ├──── Provider/
│ │ │ │ └───── RepositorioNoticia.php
│ │ │ └──── Service/
│ │ │   ├─── CadastrarNoticia.php
│ │ │   └─── EditarNoticia.php
│ │ │
│ │ └── Comment/
│ │   ├──── Model/
│ │   │ └───── Comentario.php
│ │   ├──── Provider/
│ │   │ └───── RepositorioComentario.php
│ │   └──── Service/
│ │     ├─── CriarComentario.php
│ │     └─── EditarComentario.php
│ │
│ ├── Infra/
│ │ ├── Database/
│ │ │ ├── MYSQL/
│ │ │ │ ├── MysqlPDO.php
│ │ │ │ │
│ │ │ │ ├── Migrations/
│ │ │ │ │ └── create_user_table.php
│ │ │ │ │
│ │ │ │ └── Seeders/
│ │ │ │   └── user_seeder.php
│ │ │ └── Redis/
│ │ │   ├── Migrations/
│ │ │   │ └── create_user_table.php
│ │ │   │
│ │ │   └── Seeders/
│ │ │     └── user_seeder.php
│ │ │
│ │ ├── config.php
│ │ │
│ │ └── Providers/
│ │
│ ├── storage/
│ │
│ ├── tests/
│ │ ├─── Data/
│ │ │ └──── UsuarioBuilder.php
│ │ ├─── Domain/
│ │ │  ├──── Shared/
│ │ │  │ ├────── DataTest.php
│ │ │  │ ├────── EmailTest.php
│ │ │  │ ├────── EntidadeTest.php
│ │ │  │ ├────── IdTest.php
│ │ │  │ ├────── NomePessoaTest.php
│ │ │  │ ├────── SenhaForteTest.php
│ │ │  │ ├────── SenhaHashTest.php
│ │ │  │ ├────── TextoSimplesTest.php
│ │ │  │ └────── ValidadorTest.php
│ │ │  │
│ │ │  ├──── User/
│ │ │  │ ├────── UsuarioTest.php/
│ │ │  │ ├────── LoginUsuarioTest.php
│ │ │  │ └────── CadastrarUsuarioTest.php
│ │ │  │
│ │ │  └──── Infra/
│ │ │    └────── test_db_connection.php
│ │ │
│ │ └──── Utils/
│ │   └──── Teste.php
│ │
│ └──── public/
│   └──── index.php
│
├──── init.php
├──── bootstrap.php
├──── composer.json
├──── composer.lock
├──── README.md
├──── phpunit.xml
├──── .env
├──── .env.sample
├──── .gitignore
├──── .vendor/
```

## How to run

Copy the `.env.sample` file to `.env` and fill the values.

```bash
$ composer install
$ composer migrate
$ composer db:seed
$ composer serve
```
