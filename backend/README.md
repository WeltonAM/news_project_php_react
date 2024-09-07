```
├── src/
│ ├── Domain/
│ ├──── Error/
│ │ └────── ErroValidacao.php
│ ├──── Shared/
│ │ ├────── Data.php
│ │ ├────── Email.php
│ │ ├────── Entidade.php
│ │ ├────── Id.php
│ │ ├────── NomePessoa.php
│ │ ├────── SenhaForte.php
│ │ ├────── SenhaHash.php
│ │ ├────── TextoSimples.php
│ │ └────── Validador.php
│ ├──── User/
│ │ ├────── Model/
│ │ ├──────── Usuairo.php
│ │ ├────── Provider/
│ │ ├──────── ProvedorCriptografia.php
│ │ ├──────── ProvedorBcrypt.php
│ │ ├──────── RepositorioUsuario.php
│ │ ├────── Service/
│ │ ├──────── LoginUsuario.php
│ │ └──────── CadastrarUsuario.php
│ ├──── News/
│ │ ├────── Model/
│ │ ├──────── Noticia.php
│ │ ├────── Provider/
│ │ ├──────── RepositorioNoticia.php
│ │ ├────── Service/
│ │ ├──────── CriarNoticia.php
│ │ ├──────── EditarNoticia.php
│ │ ├──────── DeletarNoticia.php
│ │ ├──────── BuscarNoticia.php
│ │ └──────── BuscarNoticiaUsuario.php
│ ├─── Comment/
│ │ ├────── Model/
│ │ ├──────── Comentario.php
│ │ ├────── Provider/
│ │ ├──────── RepositorioComentario.php
│ │ ├────── Service/
│ │ ├──────── CriarComentario.php
│ │ ├──────── EditarComentario.php
│ │ └──────── DeletarComentario.php
│ └────────── BuscarComentarioNoticia.php
├── routes/
├── storage/
├── tests/
│ ├─── Data/
│ │ └──── UsuarioBuilder.php
│ ├─── Domain/
│ │  ├──── Shared/
│ │  │ ├────── DataTest.php
│ │  │ ├────── EmailTest.php
│ │  │ ├────── EntidadeTest.php
│ │  │ ├────── IdTest.php
│ │  │ ├────── NomePessoaTest.php
│ │  │ ├────── SenhaForteTest.php
│ │  │ ├────── SenhaHashTest.php
│ │  │ ├────── TextoSimplesTest.php
│ │  │ └────── ValidadorTest.php
│ │  └──── User/
│ │   └────── UsuarioTest.php/
│ └──── Utils/
│   └──── Teste.php

```
