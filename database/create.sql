CREATE TABLE Livro (
LivroISBN VARCHAR(255),
LivroNome VARCHAR(255),
LivroCodigo SERIAL PRIMARY KEY
);

CREATE TABLE Autor (
AutorCodigo SERIAL PRIMARY KEY,
AutorNome VARCHAR(255)
);

CREATE TABLE Telefone (
TelefoneCodigo SERIAL PRIMARY KEY,
TelefoneNumero VARCHAR(255)
);

CREATE TABLE Endereco (
EnderecoCodigo SERIAL PRIMARY KEY,
EnderecoCEP VARCHAR(255),
EnderecoEstado VARCHAR(255),
EnderecoCidade VARCHAR(255)
);

CREATE TABLE Usuario (
UsuarioCodigo SERIAL PRIMARY KEY,
UsuarioCPF VARCHAR(255),
UsuarioCredito VARCHAR(255),
UsuarioEmail VARCHAR(255),
UsuarioNome VARCHAR(255),
UsuarioSenha VARCHAR(255)
);

CREATE TABLE Genero (
GeneroCodigo SERIAL PRIMARY KEY,
GeneroValor VARCHAR(255)
);

CREATE TABLE LivroUsuario (
LivroUsuarioCodigo SERIAL PRIMARY KEY,
LivroCodigo INT,
UsuarioCodigo INT,
UsuarioLivroEstado INT
);

CREATE TABLE LivroAutor (
AutorCodigo INT,
LivroCodigo INT
);

CREATE TABLE UsuarioDados (
UsuarioDadosCodigo SERIAL PRIMARY KEY, 
UsuarioCodigo INT,
TelefoneCodigo INT,
EnderecoCodigo INT
);

CREATE TABLE LivroGenero (
GeneroCodigo INT,
LivroCodigo INT
);

CREATE TABLE RecomendacaoGenero (
UsuarioCodigo INT,
GeneroCodigo INT
);

CREATE TABLE Troca (
TrocaCodigo SERIAL PRIMARY KEY,
LivroUsuarioCodigo INT,
UsuarioDestino INT
);


