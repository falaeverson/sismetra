-- MySQL dump 10.13  Distrib 5.7.17, for Linux (x86_64)
--
-- Host: 192.168.33.10    Database: sismetra
-- ------------------------------------------------------
-- Server version	5.5.53-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `paises`
--

DROP TABLE IF EXISTS `paises`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `paises` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=245 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paises`
--

LOCK TABLES `paises` WRITE;
/*!40000 ALTER TABLE `paises` DISABLE KEYS */;
INSERT INTO `paises` VALUES (1,'Afeganistão'),(2,'África do Sul'),(3,'Åland, Ilhas'),(4,'Albânia'),(5,'Alemanha'),(6,'Andorra'),(7,'Angola'),(8,'Anguilla'),(9,'Antárctida'),(10,'Antigua e Barbuda'),(11,'Antilhas Holandesas'),(12,'Arábia Saudita'),(13,'Argélia'),(14,'Argentina'),(15,'Arménia'),(16,'Aruba'),(17,'Austrália'),(18,'Áustria'),(19,'Azerbeijão'),(20,'Bahamas'),(21,'Bahrain'),(22,'Bangladesh'),(23,'Barbados'),(24,'Bélgica'),(25,'Belize'),(26,'Benin'),(27,'Bermuda'),(28,'Bielo-Rússia'),(29,'Bolívia'),(30,'Bósnia-Herzegovina'),(31,'Botswana'),(32,'Bouvet, Ilha'),(33,'Brasil'),(34,'Brunei'),(35,'Bulgária'),(36,'Burkina Faso'),(37,'Burundi'),(38,'Butão'),(39,'Cabo Verde'),(40,'Cambodja'),(41,'Camarões'),(42,'Canadá'),(43,'Cayman, Ilhas'),(44,'Cazaquistão'),(45,'Centro-africana, República'),(46,'Chade'),(47,'Checa, República'),(48,'Chile'),(49,'China'),(50,'Chipre'),(51,'Christmas, Ilha'),(52,'Cocos, Ilhas'),(53,'Colômbia'),(54,'Comores'),(55,'Congo, República do'),(56,'Congo, República Democrática do (antigo Zaire)'),(57,'Cook, Ilhas'),(58,'Coreia do Sul'),(59,'Coreia, República Democrática da (Coreia do Norte)'),(60,'Costa do Marfim'),(61,'Costa Rica'),(62,'Croácia'),(63,'Cuba'),(64,'Dinamarca'),(65,'Djibouti'),(66,'Dominica'),(67,'Dominicana, República'),(68,'Egipto'),(69,'El Salvador'),(70,'Emiratos Árabes Unidos'),(71,'Equador'),(72,'Eritreia'),(73,'Eslováquia'),(74,'Eslovénia'),(75,'Espanha'),(76,'Estados Unidos da América'),(77,'Estónia'),(78,'Etiópia'),(79,'Faroe, Ilhas'),(80,'Fiji'),(81,'Filipinas'),(82,'Finlândia'),(83,'França'),(84,'Gabão'),(85,'Gâmbia'),(86,'Gana'),(87,'Geórgia'),(88,'Geórgia do Sul e Sandwich do Sul, Ilhas'),(89,'Gibraltar'),(90,'Grécia'),(91,'Grenada'),(92,'Gronelândia'),(93,'Guadeloupe'),(94,'Guam'),(95,'Guatemala'),(96,'Guernsey'),(97,'Guiana'),(98,'Guiana Francesa'),(99,'Guiné-Bissau'),(100,'Guiné-Conacri'),(101,'Guiné Equatorial'),(102,'Haiti'),(103,'Heard e Ilhas McDonald, Ilha'),(104,'Honduras'),(105,'Hong Kong'),(106,'Hungria'),(107,'Iémen'),(108,'Índia'),(109,'Indonésia'),(110,'Iraque'),(111,'Irão'),(112,'Irlanda'),(113,'Islândia'),(114,'Israel'),(115,'Itália'),(116,'Jamaica'),(117,'Japão'),(118,'Jersey'),(119,'Jordânia'),(120,'Kiribati'),(121,'Kuwait'),(122,'Laos'),(123,'Lesoto'),(124,'Letónia'),(125,'Líbano'),(126,'Libéria'),(127,'Líbia'),(128,'Liechtenstein'),(129,'Lituânia'),(130,'Luxemburgo'),(131,'Macau'),(132,'Macedónia, República da'),(133,'Madagáscar'),(134,'Malásia'),(135,'Malawi'),(136,'Maldivas'),(137,'Mali'),(138,'Malta'),(139,'Malvinas, Ilhas (Falkland)'),(140,'Man, Ilha de'),(141,'Marianas Setentrionais'),(142,'Marrocos'),(143,'Marshall, Ilhas'),(144,'Martinica'),(145,'Maurícia'),(146,'Mauritânia'),(147,'Mayotte'),(148,'Menores Distantes dos Estados Unidos, Ilhas'),(149,'México'),(150,'Myanmar (antiga Birmânia)'),(151,'Micronésia, Estados Federados da'),(152,'Moçambique'),(153,'Moldávia'),(154,'Mónaco'),(155,'Mongólia'),(156,'Montenegro'),(157,'Montserrat'),(158,'Namíbia'),(159,'Nauru'),(160,'Nepal'),(161,'Nicarágua'),(162,'Níger'),(163,'Nigéria'),(164,'Niue'),(165,'Norfolk, Ilha'),(166,'Noruega'),(167,'Nova Caledónia'),(168,'Nova Zelândia (Aotearoa)'),(169,'Oman'),(170,'Países Baixos (Holanda)'),(171,'Palau'),(172,'Palestina'),(173,'Panamá'),(174,'Papua-Nova Guiné'),(175,'Paquistão'),(176,'Paraguai'),(177,'Peru'),(178,'Pitcairn'),(179,'Polinésia Francesa'),(180,'Polónia'),(181,'Porto Rico'),(182,'Portugal'),(183,'Qatar'),(184,'Quénia'),(185,'Quirguistão'),(186,'Reino Unido da Grã-Bretanha e Irlanda do Norte'),(187,'Reunião'),(188,'Roménia'),(189,'Ruanda'),(190,'Rússia'),(191,'Saara Ocidental'),(192,'Samoa Americana'),(193,'Samoa (Samoa Ocidental)'),(194,'Saint Pierre et Miquelon'),(195,'Salomão, Ilhas'),(196,'São Cristóvão e Névis (Saint Kitts e Nevis)'),(197,'San Marino'),(198,'São Tomé e Príncipe'),(199,'São Vicente e Granadinas'),(200,'Santa Helena'),(201,'Santa Lúcia'),(202,'Senegal'),(203,'Serra Leoa'),(204,'Sérvia'),(205,'Seychelles'),(206,'Singapura'),(207,'Síria'),(208,'Somália'),(209,'Sri Lanka'),(210,'Suazilândia'),(211,'Sudão'),(212,'Suécia'),(213,'Suíça'),(214,'Suriname'),(215,'Svalbard e Jan Mayen'),(216,'Tailândia'),(217,'Taiwan'),(218,'Tajiquistão'),(219,'Tanzânia'),(220,'Terras Austrais e Antárticas Francesas (TAAF)'),(221,'Território Britânico do Oceano Índico'),(222,'Timor-Leste'),(223,'Togo'),(224,'Toquelau'),(225,'Tonga'),(226,'Trindade e Tobago'),(227,'Tunísia'),(228,'Turks e Caicos'),(229,'Turquemenistão'),(230,'Turquia'),(231,'Tuvalu'),(232,'Ucrânia'),(233,'Uganda'),(234,'Uruguai'),(235,'Usbequistão'),(236,'Vanuatu'),(237,'Vaticano'),(238,'Venezuela'),(239,'Vietname'),(240,'Virgens Americanas, Ilhas'),(241,'Virgens Britânicas, Ilhas'),(242,'Wallis e Futuna'),(243,'Zâmbia'),(244,'Zimbabwe');
/*!40000 ALTER TABLE `paises` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_consultas`
--

DROP TABLE IF EXISTS `phpzon_consultas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_consultas` (
  `id_cons` int(11) NOT NULL AUTO_INCREMENT,
  `funcionario_cons` int(11) NOT NULL,
  `medico_cons` int(11) NOT NULL,
  `id_sit_cons` int(11) NOT NULL DEFAULT '1',
  `tipo_cons` int(11) NOT NULL,
  `data_cons` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data_hora_aten_cons` varchar(20) NOT NULL,
  `obs_cons` text,
  `lixeira_cons` int(1) NOT NULL DEFAULT '0',
  `arquivada_cons` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_cons`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_consultas`
--

LOCK TABLES `phpzon_consultas` WRITE;
/*!40000 ALTER TABLE `phpzon_consultas` DISABLE KEYS */;
/*!40000 ALTER TABLE `phpzon_consultas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_estado_civil`
--

DROP TABLE IF EXISTS `phpzon_estado_civil`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_estado_civil` (
  `id_esci` int(11) NOT NULL AUTO_INCREMENT,
  `nome_esci` varchar(30) NOT NULL,
  PRIMARY KEY (`id_esci`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_estado_civil`
--

LOCK TABLES `phpzon_estado_civil` WRITE;
/*!40000 ALTER TABLE `phpzon_estado_civil` DISABLE KEYS */;
INSERT INTO `phpzon_estado_civil` VALUES (1,'CASADO (A)'),(2,'SOLTEIRO (A)'),(3,'VIUVO (A)'),(4,'DIVORCIADO (A)'),(5,'SEPARADO (A)');
/*!40000 ALTER TABLE `phpzon_estado_civil` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_ficha_clinica`
--

DROP TABLE IF EXISTS `phpzon_ficha_clinica`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_ficha_clinica` (
  `ficha_id` int(11) NOT NULL AUTO_INCREMENT,
  `ficha_cod_cons` int(11) NOT NULL DEFAULT '9999',
  `ficha_cod_fun` int(11) NOT NULL DEFAULT '9999',
  `ficha_drt` int(11) DEFAULT NULL,
  `ficha_tipo_exa` int(11) NOT NULL,
  `ficha_data` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ficha_pa` varchar(10) NOT NULL,
  `ficha_peso` varchar(10) NOT NULL,
  `ficha_altu` varchar(10) NOT NULL,
  `ficha_imc` varchar(10) NOT NULL,
  `ficha_obes` varchar(50) NOT NULL,
  `ficha_obs` text NOT NULL,
  `ficha_data_hemo` date NOT NULL,
  `ficha_valor_hemo` varchar(10) NOT NULL,
  `ficha_situ_hemo` varchar(1) NOT NULL,
  `ficha_data_coles` date NOT NULL,
  `ficha_valor_coles` varchar(10) NOT NULL,
  `ficha_situ_coles` varchar(1) NOT NULL,
  `ficha_data_trig` date NOT NULL,
  `ficha_valor_trig` varchar(10) NOT NULL,
  `ficha_situ_trig` varchar(1) NOT NULL,
  `ficha_data_glic` date NOT NULL,
  `ficha_valor_glic` varchar(10) NOT NULL,
  `ficha_situ_glic` varchar(1) NOT NULL,
  `ficha_data_clsa` date NOT NULL,
  `ficha_valor_clsa` varchar(10) NOT NULL,
  `ficha_situ_clsa` varchar(1) NOT NULL,
  `ficha_data_prfe` date NOT NULL,
  `ficha_valor_prfe` varchar(10) NOT NULL,
  `ficha_situ_prfe` varchar(1) NOT NULL,
  `ficha_data_smur` date NOT NULL,
  `ficha_valor_smur` varchar(10) NOT NULL,
  `ficha_situ_smur` varchar(1) NOT NULL,
  `ficha_data_sohe` date NOT NULL,
  `ficha_valor_sohe` varchar(10) NOT NULL,
  `ficha_situ_sohe` varchar(1) NOT NULL,
  `ficha_data_soto` date NOT NULL,
  `ficha_valor_soto` varchar(10) NOT NULL,
  `ficha_situ_soto` varchar(1) NOT NULL,
  `ficha_data_rxtp` date NOT NULL,
  `ficha_valor_rxtp` varchar(10) NOT NULL,
  `ficha_situ_rxtp` varchar(1) NOT NULL,
  `ficha_data_rxcl` date NOT NULL,
  `ficha_valor_rxcl` varchar(10) NOT NULL,
  `ficha_situ_rxcl` varchar(1) NOT NULL DEFAULT '',
  `ficha_data_rxto` date NOT NULL,
  `ficha_valor_rxto` varchar(10) NOT NULL,
  `ficha_situ_rxto` varchar(1) NOT NULL,
  `ficha_data_ecg` date NOT NULL,
  `ficha_valor_ecg` varchar(10) NOT NULL,
  `ficha_situ_ecg` varchar(1) NOT NULL,
  `ficha_data_eeg` date NOT NULL,
  `ficha_valor_eeg` varchar(10) NOT NULL,
  `ficha_situ_eeg` varchar(1) NOT NULL,
  `ficha_data_audi` date NOT NULL,
  `ficha_valor_audi` varchar(10) NOT NULL,
  `ficha_situ_audi` varchar(1) NOT NULL,
  `ficha_data_vdrl` date NOT NULL,
  `ficha_valor_vdrl` varchar(10) NOT NULL,
  `ficha_situ_vdrl` varchar(1) NOT NULL,
  `ficha_data_ava_ofta` date NOT NULL,
  `ficha_valor_ava_ofta` varchar(10) NOT NULL,
  `ficha_situ_ava_ofta` varchar(1) NOT NULL,
  `ficha_data_acu_visu` date NOT NULL,
  `ficha_valor_acu_visu` varchar(10) NOT NULL,
  `ficha_situ_acu_visu` varchar(1) NOT NULL,
  `ficha_data_ava_card` date NOT NULL,
  `ficha_valor_ava_card` varchar(10) NOT NULL,
  `ficha_situ_ava_card` varchar(1) NOT NULL,
  `ficha_data_ava_espe` date NOT NULL,
  `ficha_valor_ava_espe` varchar(10) NOT NULL,
  `ficha_situ_ava_espe` varchar(1) NOT NULL,
  PRIMARY KEY (`ficha_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_ficha_clinica`
--

LOCK TABLES `phpzon_ficha_clinica` WRITE;
/*!40000 ALTER TABLE `phpzon_ficha_clinica` DISABLE KEYS */;
/*!40000 ALTER TABLE `phpzon_ficha_clinica` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_funcao`
--

DROP TABLE IF EXISTS `phpzon_funcao`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_funcao` (
  `id_funcao` int(11) NOT NULL AUTO_INCREMENT,
  `id_funcao_set` int(5) NOT NULL,
  `titulo_funcao` varchar(50) NOT NULL,
  `descricao_funcao` text NOT NULL,
  PRIMARY KEY (`id_funcao`)
) ENGINE=MyISAM AUTO_INCREMENT=123 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_funcao`
--

LOCK TABLES `phpzon_funcao` WRITE;
/*!40000 ALTER TABLE `phpzon_funcao` DISABLE KEYS */;
INSERT INTO `phpzon_funcao` VALUES (47,17,'TEC. SEGURANÃ‡A DO TRABALHO',''),(43,3,'GERENTE DE PRODUÃ‡ÃƒO',''),(62,8,'MARCENEIRO',''),(61,39,'AUXILIAR DE E.T.E',''),(60,4,'DESENHISTA MECÃ‚NICO',''),(59,4,'LIDER DA MANUTENÃ‡ÃƒO',''),(58,17,'BOMBEIRO CIVIL INDUSTRIAL',''),(57,6,'FONOAUDIOLOGA',''),(71,25,'OPERADOR DE MAQUINA TEXTIL BALER',''),(56,6,'MÃ‰DICA',''),(55,17,'SERVIÃ‡OS GERAIS',''),(54,8,'PEDREIRO',''),(53,13,'GOVERNANTA',''),(52,5,'ELETRICISTA',''),(51,5,'AUXILIAR DE  ELETRICISTA',''),(50,3,'LIDER DA PREPARAÃ‡ÃƒO DE BALER',''),(49,18,'MOTORISTA',''),(45,3,'COORDENADOR DA PRODUÃ‡ÃƒO',''),(46,3,'LIDER DA FIAÃ‡ÃƒO DE BALER',''),(42,4,'TORNEIRO MECANICO',''),(41,4,'SOLDADOR',''),(35,9,'LÃDER DO ALMOXARIFADO',''),(26,4,'MECÂNICO DE MANUTENÇÃO',''),(27,4,'MECÃ‚NICO DE MANUTENÃ‡ÃƒO',''),(29,11,'AUXILIAR DE COZINHA',''),(30,11,'CHEFE DE COZINHA',''),(31,11,'NUTRICIONISTA',''),(32,4,'APRENDIZ DE MECÃ‚NICA INDUSTRIAL',''),(33,8,'AUX. DE JARDINEIRO',''),(34,5,'APRENDIZ DE ELETRICISTA',''),(17,2,'DIRETORA ADMINISTRATIVA',''),(72,25,'LIDER DE FIACAO DE BALER',''),(21,2,'ANALISTA ORCAMENTARIO',''),(19,2,'DIRETOR EXECUTIVO',''),(39,3,'LIMPEZA E CONSERVAÃ‡ÃƒO',''),(24,3,'OPERADOR DE MAQUINA TEXTIL/BALER',''),(20,2,'SUP. RECURSOS HUMANOS',''),(40,3,'EMBALADOR',''),(36,4,'SOLDADORA JUNIOR',''),(37,6,'ENFERMEIRA ',''),(38,5,'LIDER DA MANUTENCAO ELETRICA',''),(18,2,'AUXILIAR DE CONTABILIDADE',''),(22,39,'QUIMICA INDUSTRIAL',''),(23,2,'AUXILIAR DE ESCRITORIO',''),(1,3,'FIANDEIRO',''),(7,3,'CONTROLE DE QUALIDADE',''),(28,4,'MECÃ‚NICO DA FIAÃ‡ÃƒO',''),(3,2,'ENC. CONTAS A PAGAR',''),(4,2,'DIRETORA',''),(5,2,'SUPERVISORA DO R.H',''),(112,40,'ASSISTENTE ADM',''),(8,2,'AUXILIAR DE T.I.',''),(9,2,'CONTADORA',''),(10,2,'ASSISTENTE DE DIRETORIA',''),(11,2,'SETOR DE COMPRAS',''),(12,13,'MORDOMO',''),(13,2,'COPEIRA',''),(14,2,'FATURAMENTO',''),(15,2,'SUB. GERENTE INDUSTRIAL',''),(16,2,'ATENDIMENTO AO PUBLICO',''),(64,3,'PREPARADOR DE EMULSÃƒO',''),(105,11,'AUX. COZINHA',''),(108,4,'AUX. MECÃ‚NICO',''),(115,41,'LIDER DA MECÃ‚NICA DA FIAÃ‡ÃƒO',''),(70,15,'CARREGADOR DE ARMAZEM',''),(73,22,'ANALISTA DE ESCRITURACAO FISCAL',''),(75,3,'LIDER DA PREPARACAO DE BALER',''),(84,22,'CONTADORA',''),(85,25,'OPERADOR DE MÃQUINA TEXTIL',''),(82,25,'FIANDEIRO',''),(83,24,'INSPETOR DE QUALIDADE',''),(86,24,'AUXILIAR DE LABORATORIO',''),(87,15,'PRENSISTA',''),(88,31,'EMBALADOR A MÃƒO',''),(89,15,'LIDER ARMAZEM DE FIBRAS',''),(90,3,'AUX DE LIMPEZA',''),(91,25,'FIANDEIRO APRENDIZ',''),(92,25,'AUX DE FIACAO',''),(93,11,'ESTOQUISTA DE ALIMENTO',''),(94,31,'OPERADOR DE EMPILHADEIRA',''),(95,4,'AUX. MECANICO DE EMPILHADEIRA',''),(96,31,'LIDER DA EMBALAGEM DE BALER',''),(109,4,'LUBRIFICADOR',''),(104,4,'APLAINADOR',''),(106,11,'AUX. LIMPEZA',''),(110,22,'ANALISTA ORÃ‡AMENTÃRIO',''),(111,2,'COMPRADOR ',''),(113,9,'AUX. ALMOXARIFADO',''),(114,6,'FISIOTERAPEUTA',''),(116,3,'AUXILIAR DA PREPARAÃ‡ÃƒO',''),(117,15,'AUXILIAR DE PRENSISTA',''),(118,24,'AUXILIAR DE CONTROLE DE QUALIDADE',''),(119,8,'PEDREIRO AUXILIAR',''),(120,8,'CARPINTEIRO',''),(121,4,'PINTOR',''),(122,25,'LIDER DA FIAÃ‡ÃƒO DE BALER','');
/*!40000 ALTER TABLE `phpzon_funcao` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_funcionario`
--

DROP TABLE IF EXISTS `phpzon_funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_funcionario` (
  `id_fun` int(11) NOT NULL AUTO_INCREMENT,
  `drt_fun` varchar(10) DEFAULT NULL,
  `nome_fun` varchar(100) NOT NULL,
  `cpf_fun` varchar(15) NOT NULL DEFAULT '',
  `rg_fun` varchar(10) NOT NULL DEFAULT '',
  `civil_fun` int(1) DEFAULT NULL,
  `sexo_fun` int(1) NOT NULL,
  `setor_fun` int(1) DEFAULT NULL,
  `funcao_fun` int(1) DEFAULT NULL,
  `data` date DEFAULT NULL,
  `situacao_fun` int(1) NOT NULL,
  `obs_fun` text,
  `endereco_fun` varchar(100) DEFAULT NULL,
  `numero_fun` varchar(8) NOT NULL,
  `bairro_fun` varchar(60) DEFAULT NULL,
  `cidade_fun` varchar(60) DEFAULT NULL,
  `estado_fun` varchar(20) DEFAULT NULL,
  `cep_fun` varchar(10) DEFAULT '00.000-000',
  `fone_fun` varchar(12) NOT NULL,
  `celular_1_fun` varchar(12) NOT NULL,
  `celular_2_fun` varchar(12) DEFAULT NULL,
  `email_fun` varchar(30) NOT NULL,
  PRIMARY KEY (`id_fun`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_funcionario`
--

LOCK TABLES `phpzon_funcionario` WRITE;
/*!40000 ALTER TABLE `phpzon_funcionario` DISABLE KEYS */;
/*!40000 ALTER TABLE `phpzon_funcionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_medico`
--

DROP TABLE IF EXISTS `phpzon_medico`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_medico` (
  `id_med` int(11) NOT NULL AUTO_INCREMENT,
  `nome_med` varchar(250) DEFAULT NULL,
  `especialidade_med` varchar(250) NOT NULL,
  `area_atuacao_med` varchar(250) NOT NULL,
  `sexo_med` varchar(1) NOT NULL,
  `civil_med` int(1) NOT NULL,
  `endereco_med` varchar(255) NOT NULL,
  `numero_med` varchar(10) NOT NULL,
  `bairro_med` varchar(40) NOT NULL,
  `cidade_med` varchar(30) NOT NULL,
  `estado_med` varchar(20) NOT NULL,
  `cep_med` varchar(10) NOT NULL,
  `fone_med` varchar(15) NOT NULL,
  `celular_1_med` varchar(15) NOT NULL,
  `celular_2_med` varchar(15) NOT NULL,
  `email_med` varchar(60) NOT NULL,
  `data` date DEFAULT '0000-00-00',
  `data_atu` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_med`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_medico`
--

LOCK TABLES `phpzon_medico` WRITE;
/*!40000 ALTER TABLE `phpzon_medico` DISABLE KEYS */;
INSERT INTO `phpzon_medico` VALUES (6,'MARIA TRICIA CARNEIRO PIRES GOMES','MEDICA','MEDICA DO TRABALHO','F',1,'','','','','','','','','','','2013-01-01','2013-11-01 12:49:33');
/*!40000 ALTER TABLE `phpzon_medico` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_menu`
--

DROP TABLE IF EXISTS `phpzon_menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_menu` (
  `id_menu` int(11) NOT NULL AUTO_INCREMENT,
  `id_dropdown` int(4) NOT NULL DEFAULT '0',
  `nome_menu` varchar(50) NOT NULL,
  `link_menu` varchar(100) NOT NULL,
  `orden_menu` int(3) DEFAULT NULL,
  `status_menu` char(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_menu`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_menu`
--

LOCK TABLES `phpzon_menu` WRITE;
/*!40000 ALTER TABLE `phpzon_menu` DISABLE KEYS */;
INSERT INTO `phpzon_menu` VALUES (8,0,'Usuario','usuario',1,'1'),(9,0,'Historico','historico',2,'1'),(10,0,'Menu','menu',3,'1'),(11,0,'Medico','medico',4,'1'),(12,0,'Funcionario','funcionario',5,'1'),(13,0,'Setor','setor',6,'1'),(14,0,'Funcao','funcao',7,'1'),(15,0,'Ficha Clinica','ficha_clinica',8,'1'),(16,0,'Marcar Consulta','marcar_consulta',8,'1'),(17,0,'Historico de Consulta','historico_de_consulta',9,'1'),(18,0,'Consultas Marcadas','consultas_marcadas',10,'1'),(19,0,'Selecionar Cracha','selecionar_cracha',11,'1'),(20,0,'Gera Cracha','gera_cracha',12,'1');
/*!40000 ALTER TABLE `phpzon_menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_password`
--

DROP TABLE IF EXISTS `phpzon_password`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_password` (
  `id_password` int(11) NOT NULL AUTO_INCREMENT,
  `id_user_password` int(11) NOT NULL,
  `senha_password` varchar(32) NOT NULL,
  PRIMARY KEY (`id_password`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_password`
--

LOCK TABLES `phpzon_password` WRITE;
/*!40000 ALTER TABLE `phpzon_password` DISABLE KEYS */;
INSERT INTO `phpzon_password` VALUES (1,1,'e10adc3949ba59abbe56e057f20f883e');
/*!40000 ALTER TABLE `phpzon_password` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_setor`
--

DROP TABLE IF EXISTS `phpzon_setor`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_setor` (
  `id_set` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_set` varchar(50) NOT NULL,
  `descricao_set` text NOT NULL,
  PRIMARY KEY (`id_set`)
) ENGINE=MyISAM AUTO_INCREMENT=43 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_setor`
--

LOCK TABLES `phpzon_setor` WRITE;
/*!40000 ALTER TABLE `phpzon_setor` DISABLE KEYS */;
INSERT INTO `phpzon_setor` VALUES (17,'SEGURANCA DO TRABALHO','SETOR RESPONSAVEL PELA SEGURANCA DOS FUNCIONARIOS E DO AMBIENTE DE TRABALHO DOS COLABORADORES.'),(22,'FISCAL',''),(4,'MANUTENCAO MECANICA','SETOR RESPONSAVEL PELOS CONSERTOS E  MANUTENCAO DAS MAQUINAS.\r\n'),(5,'MANUTENCAO ELETRICA','SETOR RESPONSÃVEL PELA MANUTENCAO ELETRICA DAS MAQUINAS E DE TODA A ORGANIZACAO DE  ESTRUTURA ELETRICA E AUTOMACAO INDUSTRIAL.'),(6,'SAUDE OCUPACIONAL','SETOR RESPONSAVEL PELA SAUDE OCUPACIONAL DOS COLABORADORES. '),(7,'PORTARIA','SETOR RESPONSÃVEL PELA ENTRADA E SAIDA DE CARGAS E FUNCIONARIOS.'),(2,'ADMINISTRACAO','SETOR RESPONSAVEL PELA ADMINISTRACAO, ATENDIMENTO AO PUBLICO,  COMPRAS,CONTABILIDADE E SERVICOS DA ORGANIZACAO.'),(3,'PREPARACAO DE BALER',''),(31,'EMBALAGEM DE BALER',''),(15,'ARMAZEM DE FIBRAS','SETOR RESPONSAVEL PELO ARMAZENAMENTO DA FIBRA DE SISAL.'),(8,'CONSERVACAO E JARDINAGEM','SETOR RESPONSAVEL PELA  CONSERVACAO E  LIMPEZA DOS JARDINS'),(9,'ALMOXARIFADO','SETOR RESPONSÃVEL PELO ARMAZENAMENTO DO MATERIAL DE PRODUÃ‡ÃƒO, ESCRITÃ“RIO, LIMPEZA E OUTROS.'),(24,'CONTROLE DE QUALIDADE',''),(25,'FIACAO DE BALER',''),(11,'UNIDADE DE NUTRICAO E ALIMENTACAO','SETOR RESPONSAVEL PELA  ALIMENTACAO DOS COLABORADORES.'),(13,'CASA DA PRAIA','RESIDENCIA DA DIRETORIA'),(18,'TRANSPORTE','SETOR RESPONSÃVEL POR CONDUZIR OS VEÃCULOS DA EMPRESA, TRANSPORTAR PESSOAS E MERCADORIAS, FAZER SERVIÃ‡OS BANCÃRIOS, BUSCA DE MERCADORIAS COMPRADAS NO COMERCIO.'),(39,'E.T.E FLUENTES','ESTAÃ‡ÃƒO DE TRATAMENTO'),(40,'EXPORTAÃ‡ÃƒO, PORTO, FATUR.',''),(41,'MECÃ‚NICA DA FIAÃ‡ÃƒO',''),(42,'LIDER DE PREPARAÃ‡ÃƒO','');
/*!40000 ALTER TABLE `phpzon_setor` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_sexo`
--

DROP TABLE IF EXISTS `phpzon_sexo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_sexo` (
  `id_sexo` int(11) NOT NULL AUTO_INCREMENT,
  `nome_sexo` varchar(15) NOT NULL,
  `cod_sexo` varchar(1) NOT NULL,
  PRIMARY KEY (`id_sexo`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_sexo`
--

LOCK TABLES `phpzon_sexo` WRITE;
/*!40000 ALTER TABLE `phpzon_sexo` DISABLE KEYS */;
INSERT INTO `phpzon_sexo` VALUES (1,'MASCULINO','M'),(2,'FEMININO','F');
/*!40000 ALTER TABLE `phpzon_sexo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_situacao_ficha`
--

DROP TABLE IF EXISTS `phpzon_situacao_ficha`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_situacao_ficha` (
  `id_sit_fic` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_sit_fic` varchar(50) NOT NULL,
  PRIMARY KEY (`id_sit_fic`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_situacao_ficha`
--

LOCK TABLES `phpzon_situacao_ficha` WRITE;
/*!40000 ALTER TABLE `phpzon_situacao_ficha` DISABLE KEYS */;
INSERT INTO `phpzon_situacao_ficha` VALUES (1,'Atendimento em espera'),(2,'Atendimento em andamento'),(3,'Atendimento realizado'),(4,'Atendimento cancelado');
/*!40000 ALTER TABLE `phpzon_situacao_ficha` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_situacao_funcionario`
--

DROP TABLE IF EXISTS `phpzon_situacao_funcionario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_situacao_funcionario` (
  `id_sit_fun` int(11) NOT NULL,
  `titulo_sit_fun` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_situacao_funcionario`
--

LOCK TABLES `phpzon_situacao_funcionario` WRITE;
/*!40000 ALTER TABLE `phpzon_situacao_funcionario` DISABLE KEYS */;
INSERT INTO `phpzon_situacao_funcionario` VALUES (1,'ADMITIDO'),(2,'DEMITIDO');
/*!40000 ALTER TABLE `phpzon_situacao_funcionario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_tipo_exame`
--

DROP TABLE IF EXISTS `phpzon_tipo_exame`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_tipo_exame` (
  `id_exa` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_exa` varchar(60) NOT NULL,
  PRIMARY KEY (`id_exa`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_tipo_exame`
--

LOCK TABLES `phpzon_tipo_exame` WRITE;
/*!40000 ALTER TABLE `phpzon_tipo_exame` DISABLE KEYS */;
INSERT INTO `phpzon_tipo_exame` VALUES (1,'ADMISSIONAL'),(2,'PERI&Oacute;DICO'),(3,'RET. TRABALHO'),(4,'MUD. FUN&Ccedil;&Atilde;O'),(5,'DEMISSIONAL'),(6,'ESPECIAL');
/*!40000 ALTER TABLE `phpzon_tipo_exame` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `phpzon_user`
--

DROP TABLE IF EXISTS `phpzon_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `phpzon_user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name_user` varchar(50) NOT NULL,
  `login_user` varchar(10) NOT NULL,
  `email_user` varchar(30) NOT NULL,
  `status_user` char(1) NOT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `phpzon_user`
--

LOCK TABLES `phpzon_user` WRITE;
/*!40000 ALTER TABLE `phpzon_user` DISABLE KEYS */;
INSERT INTO `phpzon_user` VALUES (1,'PhpZon Copyrigth','phpzon','email@gmail.com','1');
/*!40000 ALTER TABLE `phpzon_user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-02-26  0:03:15
