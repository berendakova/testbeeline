<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029191317 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE workers_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE workers (id INT NOT NULL,
                            parent_id INT DEFAULT NULL,
                            name VARCHAR(255) NOT NULL,
                            PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B82D7DC0727ACA70 ON workers (parent_id)');
        $this->addSql('ALTER TABLE workers ADD CONSTRAINT FK_B82D7DC0727ACA70 FOREIGN KEY (parent_id) REFERENCES workers (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE workers_id_seq CASCADE');
        $this->addSql('ALTER TABLE workers DROP CONSTRAINT FK_B82D7DC0727ACA70');
        $this->addSql('DROP TABLE workers');
    }
}
