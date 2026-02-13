<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260213223951 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Category (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(100) NOT NULL, image VARCHAR(255) NOT NULL, updatedAt DATETIME DEFAULT NULL)');
        $this->addSql('CREATE TABLE category_dossier (category_id INTEGER NOT NULL, dossier_id INTEGER NOT NULL, PRIMARY KEY (category_id, dossier_id), CONSTRAINT FK_FA90A04912469DE2 FOREIGN KEY (category_id) REFERENCES Category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_FA90A049611C0C56 FOREIGN KEY (dossier_id) REFERENCES Dossier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_FA90A04912469DE2 ON category_dossier (category_id)');
        $this->addSql('CREATE INDEX IDX_FA90A049611C0C56 ON category_dossier (dossier_id)');
        $this->addSql('CREATE TABLE Client (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, address VARCHAR(100) DEFAULT NULL, city VARCHAR(50) DEFAULT NULL, country VARCHAR(50) DEFAULT NULL)');
        $this->addSql('CREATE TABLE Dossier (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) NOT NULL, createdDate DATETIME NOT NULL, active BOOLEAN NOT NULL, content CLOB NOT NULL, client_id INTEGER NOT NULL, author_id INTEGER NOT NULL, CONSTRAINT FK_F2F5D9AB19EB6921 FOREIGN KEY (client_id) REFERENCES Client (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_F2F5D9ABF675F31B FOREIGN KEY (author_id) REFERENCES User (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_F2F5D9AB19EB6921 ON Dossier (client_id)');
        $this->addSql('CREATE INDEX IDX_F2F5D9ABF675F31B ON Dossier (author_id)');
        $this->addSql('CREATE TABLE User (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, username VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, roles CLOB NOT NULL, enabled BOOLEAN NOT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Category');
        $this->addSql('DROP TABLE category_dossier');
        $this->addSql('DROP TABLE Client');
        $this->addSql('DROP TABLE Dossier');
        $this->addSql('DROP TABLE User');
    }
}
