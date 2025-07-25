CREATE TABLE `users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `username` VARCHAR(50) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `candidates` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `party` VARCHAR(50) DEFAULT NULL,
  `description` TEXT,
  `created_by` INT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `fk_candidates_created_by` (`created_by`),
  CONSTRAINT `fk_candidates_created_by` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `customers` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `cpf` VARCHAR(14) NOT NULL,
  `candidate_id` INT DEFAULT NULL,
  `created_by` INT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `candidate_id` (`candidate_id`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `customers_ibfk_1` FOREIGN KEY (`candidate_id`) REFERENCES `candidates` (`id`),
  CONSTRAINT `customers_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE `addresses` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `customer_id` INT DEFAULT NULL,
  `neighborhood` VARCHAR(100) DEFAULT NULL,
  `cep` VARCHAR(20) DEFAULT NULL,
  `necessity` TEXT,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

CREATE TABLE api_tokens (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  token VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);
-- dados para a tabela `users`

INSERT INTO `users` (`id`, `username`, `password`, `created_at`) VALUES
(1, 'admin', '$2y$10$/QymJI5nOoQb6ewfhBxq3OnYGnCt1nnN/Zn.6.x3IF6iUeGL4hYVu', '2025-04-17 18:47:06'),
(2, 'usuario2', '$2y$10$/QymJI5nOoQb6ewfhBxq3OnYGnCt1nnN/Zn.6.x3IF6iUeGL4hYVu', '2025-04-18 17:02:51');



INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1000', 'Stella Alves', 'Et Partido', 'Adipisci sed odio assumenda.', '1', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1001', 'Emilly Fernandes', 'Possimus Partido', 'Earum perferendis possimus accusamus.', '1', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1002', 'Marcela Pires', 'Explicabo Partido', 'Deserunt distinctio repellat earum id beatae autem.', '1', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1003', 'Diogo Correia', 'Laudantium Partido', 'Omnis beatae iste quibusdam dolorem in quas error.', '1', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1004', 'Dr. Luiz Henrique da Cruz', 'Harum Partido', 'Nostrum doloribus nulla earum ut suscipit repudiandae.', '1', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1005', 'Alice Fernandes', 'Occaecati Partido', 'Itaque reiciendis voluptatum dolores.', '1', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1006', 'Sabrina Sales', 'Eos Partido', 'Ad temporibus enim quasi nesciunt.', '1', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1007', 'Pedro Henrique Martins', 'Quaerat Partido', 'Atque distinctio a hic.', '1', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1008', 'Kamilly Silva', 'Id Partido', 'Sit non rem dolore.', '1', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1009', 'Bernardo Viana', 'Sint Partido', 'Quo voluptate asperiores numquam labore nisi autem in.', '1', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1010', 'Giovanna Duarte', 'Voluptatem Partido', 'Quos error reiciendis ullam neque.', '2', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1011', 'Srta. Isabella Peixoto', 'Mollitia Partido', 'Qui sit aperiam quisquam quos.', '2', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1012', 'Felipe Silveira', 'Esse Partido', 'Distinctio accusamus dicta delectus ducimus molestias maiores.', '2', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1013', 'Sr. Nathan Farias', 'Iste Partido', 'Nulla dolore autem iusto repudiandae sint molestiae distinctio.', '2', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1014', 'Fernanda Viana', 'Consectetur Partido', 'Voluptatum minima debitis eligendi accusamus earum.', '2', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1015', 'Natália Duarte', 'Temporibus Partido', 'Nobis eveniet eveniet beatae consectetur.', '2', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1016', 'Gabrielly Ramos', 'Repellat Partido', 'Hic voluptas temporibus.', '2', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1017', 'Otávio Correia', 'Repudiandae Partido', 'Itaque dolores illum minima.', '2', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1018', 'Thomas Azevedo', 'Modi Partido', 'Ea dolores commodi facere vitae accusantium minima.', '2', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1019', 'Gabriela da Cunha', 'Ipsa Partido', 'Ad similique ratione quas doloribus quod exercitationem.', '2', '2025-04-18 20:44:31');
INSERT INTO `candidates` (`id`, `name`, `party`, `description`, `created_by`, `created_at`) VALUES ('1020', 'Kamilly Nogueira', 'Numquam Partido', 'A doloribus quod assumenda.', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2000', 'Catarina Farias', '05814697393', '1003', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2001', 'Larissa Moreira', '37059461299', '1008', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2002', 'Sra. Raquel Melo', '03758641217', '1003', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2003', 'Kamilly Cavalcanti', '97103258686', '1000', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2004', 'Murilo Mendes', '61297035461', '1006', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2005', 'Mariane Novaes', '52163048780', '1009', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2006', 'Luigi Sales', '41238970532', '1005', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2007', 'Isis Melo', '12085394698', '1007', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2008', 'Diego Pinto', '12789430560', '1001', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2009', 'Ana Dias', '21467985309', '1002', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2010', 'Ana Beatriz Pinto', '67501934207', '1001', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2011', 'Lorena da Rocha', '60847913520', '1002', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2012', 'Dra. Ana Júlia Freitas', '80796524149', '1000', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2013', 'Luiz Miguel da Cunha', '51264790830', '1007', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2014', 'Catarina Almeida', '68925470101', '1000', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2015', 'Sr. Benjamin Rezende', '59086147348', '1005', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2016', 'João Guilherme Lopes', '68519304206', '1002', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2017', 'Murilo Souza', '04257138904', '1006', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2018', 'Larissa Barros', '70265319480', '1008', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2019', 'Marcela Mendes', '46590187339', '1008', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2020', 'Srta. Maysa da Costa', '25078491341', '1005', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2021', 'Eduardo Cavalcanti', '73412058653', '1003', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2022', 'Yago Silveira', '15796082485', '1003', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2023', 'Nicolas Martins', '04678153217', '1007', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2024', 'João Felipe Moraes', '97453206170', '1000', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2025', 'Yago Moraes', '92034871669', '1000', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2026', 'Olivia Barbosa', '53804716920', '1002', '1', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2027', 'Dr. Yuri Barbosa', '14389270532', '1015', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2028', 'Guilherme da Mota', '90312876521', '1017', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2029', 'Lucca Costela', '28170469350', '1018', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2030', 'Vinicius Moreira', '90587146249', '1012', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2031', 'Caio Sales', '16458237090', '1010', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2032', 'Júlia Correia', '61953478093', '1020', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2033', 'João Guilherme Melo', '02634197543', '1017', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2034', 'Dra. Maria Julia Silveira', '85162049794', '1016', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2035', 'Lucas Gabriel Caldeira', '69321570470', '1019', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2036', 'Pedro Lucas Freitas', '64891350784', '1016', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2037', 'Kaique da Costa', '58490216711', '1020', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2038', 'Emanuelly Silveira', '45170632835', '1020', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2039', 'Noah da Mata', '06923874122', '1018', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2040', 'Sr. Thales Cardoso', '70846935210', '1019', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2041', 'Sr. Joaquim da Rosa', '53126078940', '1014', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2042', 'Sofia Pinto', '40571362907', '1012', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2043', 'Maria Luiza Lopes', '47596312837', '1015', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2044', 'Ana Lívia Fernandes', '17836452026', '1016', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2045', 'Diego Santos', '96715348057', '1012', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2046', 'Yuri Novaes', '73814952014', '1010', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2047', 'Thales Cunha', '65017298401', '1020', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2048', 'Clara Melo', '49350268124', '1018', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2049', 'Sr. Murilo Rocha', '86942305189', '1010', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2050', 'Nicole Caldeira', '71034956299', '1011', '2', '2025-04-18 20:44:31');
INSERT INTO `customers` (`id`, `name`, `cpf`, `candidate_id`, `created_by`, `created_at`) VALUES ('2051', 'Letícia Costela', '12695483791', '1017', '2', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2000', 'Passarela de Mendes', '81005-458', 'Commodi aut ad earum reprehenderit vel.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2001', 'Condomínio Castro', '95660175', 'Aperiam modi exercitationem ducimus perspiciatis.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2002', 'Trevo de Lopes', '83300-476', 'Perspiciatis vel esse eum amet beatae totam.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2003', 'Pátio Francisco Jesus', '33650-444', 'Reiciendis hic assumenda commodi veritatis.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2004', 'Vila Isabella Gomes', '61344285', 'Aspernatur est fuga ipsa dolorem nulla.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2005', 'Largo Aragão', '08255-261', 'Odio eum dolorem inventore saepe.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2006', 'Parque de Aragão', '95874-370', 'Veniam tenetur inventore nostrum ex corrupti ut.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2007', 'Trecho de Ribeiro', '96629-224', 'Facilis recusandae et ipsam.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2008', 'Campo Luigi Araújo', '90967-585', 'Vel nulla dolores placeat ab ea ullam.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2009', 'Rua Brenda Pires', '27029138', 'Ratione occaecati minus odio excepturi possimus.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2010', 'Conjunto Cardoso', '37047957', 'Natus repellendus ipsum porro quidem totam dignissimos.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2011', 'Recanto João Lucas Mendes', '60023-589', 'Vel ex doloribus reprehenderit doloribus inventore possimus.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2012', 'Parque de Ferreira', '22450-826', 'Praesentium cumque veniam architecto aliquid voluptate.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2013', 'Praça Juan Moura', '79977392', 'Vero consequuntur ipsa placeat saepe maxime.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2014', 'Colônia Moraes', '63141-824', 'Consectetur molestias ipsa veritatis.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2015', 'Via Theo Lopes', '77589-012', 'Eaque porro officia aliquam occaecati.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2016', 'Vila de da Luz', '72343763', 'Modi adipisci nulla quia impedit.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2017', 'Distrito de Pereira', '69027-965', 'Dolore quaerat hic eveniet voluptatum maxime quos.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2018', 'Vila de Caldeira', '32823524', 'Officia magnam velit ipsa eligendi quidem iure.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2019', 'Via Pietra Moura', '09495608', 'Illo modi tempore illo maxime.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2020', 'Viela Gomes', '02171-264', 'Mollitia similique expedita occaecati illum sint nesciunt.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2021', 'Morro Porto', '58373-770', 'Libero aliquam numquam velit dolor cumque.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2022', 'Colônia de Pereira', '32271356', 'Deleniti et eum optio odio.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2023', 'Praça Cardoso', '73906-174', 'Tenetur necessitatibus magnam modi.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2024', 'Residencial Correia', '74540803', 'Commodi at magni.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2025', 'Trevo Augusto Fogaça', '34476-892', 'Iure aspernatur quasi dolorum.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2026', 'Morro Beatriz da Rocha', '38337-673', 'Dolore praesentium excepturi natus nisi.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2027', 'Lago Anthony Cavalcanti', '02908-259', 'Fuga voluptas voluptates quas.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2028', 'Lago Teixeira', '02335867', 'Quasi sit praesentium sint deleniti dolorum.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2029', 'Fazenda de Gonçalves', '92379-889', 'Minima suscipit atque ipsam quod laboriosam in.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2030', 'Trevo Rodrigues', '55864-028', 'Neque doloribus libero est.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2031', 'Vila de Correia', '31752378', 'Possimus numquam culpa minus.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2032', 'Condomínio Ribeiro', '87797-386', 'Perspiciatis possimus doloremque adipisci repellendus iure.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2033', 'Trecho de Silva', '61788-416', 'Labore saepe veniam.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2034', 'Lago Lima', '07923-798', 'Vero molestiae eum iusto non quia cupiditate cumque.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2035', 'Jardim de Duarte', '78684585', 'Architecto voluptatem voluptas officiis officia.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2036', 'Pátio Miguel da Rosa', '08257-776', 'Mollitia sunt dolor quisquam.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2037', 'Sítio Cavalcanti', '27369-995', 'Enim odit doloribus neque.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2038', 'Setor Bruno Gomes', '42844252', 'Nemo natus quas.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2039', 'Passarela Ian da Mota', '14130-405', 'Aliquid ad consectetur nobis velit non.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2040', 'Parque de Freitas', '80147267', 'Ducimus quibusdam tempore ea qui iste.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2041', 'Viaduto de da Cruz', '83825-219', 'Eum at deleniti temporibus recusandae.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2042', 'Vale Lucas Pinto', '68648-423', 'Cum optio amet nobis maxime.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2043', 'Sítio Barbosa', '05790567', 'Id consectetur illo nesciunt atque.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2044', 'Lago Felipe Monteiro', '66557-311', 'Expedita et iste vel iusto.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2045', 'Lagoa de Moraes', '24620875', 'Dignissimos itaque iusto perferendis illo.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2046', 'Praça Luiz Felipe Monteiro', '04116-846', 'Soluta doloribus culpa vero.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2047', 'Trevo de Ramos', '40865042', 'Odit repellendus quia aliquam.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2048', 'Alameda de Cunha', '66032737', 'Est recusandae praesentium sed quisquam.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2049', 'Trevo de Cunha', '39143-257', 'Recusandae error facere eos.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2050', 'Viaduto Rodrigo Alves', '82896-985', 'Magnam sequi commodi consequatur eveniet eveniet voluptatum.', '2025-04-18 20:44:31');
INSERT INTO `addresses` (`customer_id`, `neighborhood`, `cep`, `necessity`, `created_at`) VALUES ('2051', 'Vale de da Cunha', '48055883', 'Placeat dolor qui incidunt temporibus.', '2025-04-18 20:44:31');