<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220924160912 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE application_file_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE applications_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE application_file (id INT NOT NULL, name_file_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7B735E989BA03CD2 ON application_file (name_file_id)');
        $this->addSql('CREATE TABLE applications (id INT NOT NULL, title VARCHAR(255) DEFAULT NULL, text TEXT DEFAULT NULL, status TEXT DEFAULT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE application_file ADD CONSTRAINT FK_7B735E989BA03CD2 FOREIGN KEY (name_file_id) REFERENCES applications (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA heroku_ext');
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE application_file_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE applications_id_seq CASCADE');
        $this->addSql('ALTER TABLE application_file DROP CONSTRAINT FK_7B735E989BA03CD2');
        $this->addSql('DROP TABLE application_file');
        $this->addSql('DROP TABLE applications');
    }
}
