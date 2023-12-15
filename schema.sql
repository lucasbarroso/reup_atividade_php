DROP TABLE IF EXISTS pessoa;

CREATE TABLE IF NOT EXISTS pessoa (
  id    SERIAL      NOT NULL PRIMARY KEY,
  nome  VARCHAR(45) NOT NULL,
  idade INTEGER         NULL
);

INSERT INTO pessoa (id, nome, idade) VALUES
(1, 'João', 30),
(2, 'Maria', 25),
(3, 'Carlos', 40),
(5, 'João Almeida', 31),
(6, 'João Bosco', 30),
(7, 'João Vitor', 32),
(8, 'João iweohqh', 36),
(9, 'João asijdp', 35);
