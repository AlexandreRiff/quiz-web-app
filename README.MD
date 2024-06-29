# <center>Quiz</center>

![Tela Inicial](./docs/imgs/quiz-tela-inicial.gif)
![Painel de Administração](./docs/imgs/quiz-painel-admin.gif)

## 📖 Descrição

Este projeto é um quiz desenvolvido em PHP. Ele permite que os usuários participem de quizzes, respondendo perguntas de múltipla escolha e recebendo uma pontuação com base em suas respostas.

## ⚙️ Funcionalidades

- Interface amigável para responder quizzes.
- Painel de administração para criação, edição e exclusão de perguntas.
- Avaliação automática e exibição da pontuação.

## 🛠️ Tecnologias Utilizadas

- PHP
- MySQL
- HTML5
- CSS3
- JavaScript
- Bootstrap
- Docker

## 💻 Pré-requisitos

- Docker e Docker Compose Instalado.

## 🚀 Instalação

1. Clone o repositório para a sua máquina local:

```bash
git clone https://github.com/AlexandreRiff/web-quiz.git
```

2. Navegue até o diretório do projeto:

```bash
cd web-quiz
```

3. Execute o docker:

```bash
cd docker/dev && docker-compose up -d --build
```

## ☕️ Uso

- Acesse a aplicação no seu navegador:

```
http://localhost/quiz
```

- Para acessar o painel de administração:

```
http://localhost/quiz/adminPanel
```

Utilize as seguintes credenciais:

- Usuário: admin@email.com
- Senha: admin
