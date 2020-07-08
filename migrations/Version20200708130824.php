<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200708130824 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE accounts (uuid UUID NOT NULL, first_name VARCHAR(255) NOT NULL, last_name VARCHAR(255) NOT NULL, document_number VARCHAR(16) NOT NULL, document_type VARCHAR(5) NOT NULL, email VARCHAR(100) NOT NULL, password TEXT NOT NULL, balance INT NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE TABLE operations (uuid UUID NOT NULL, account_uuid UUID DEFAULT NULL, transaction_uuid UUID DEFAULT NULL, type VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_281453485DECD70C ON operations (account_uuid)');
        $this->addSql('CREATE INDEX IDX_28145348333C6E07 ON operations (transaction_uuid)');
        $this->addSql('CREATE TABLE transactions (uuid UUID NOT NULL, payer_uuid UUID DEFAULT NULL, payee_uuid UUID DEFAULT NULL, amount INT NOT NULL, authentication VARCHAR(150) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(uuid))');
        $this->addSql('CREATE INDEX IDX_EAA81A4C38D8EA9A ON transactions (payer_uuid)');
        $this->addSql('CREATE INDEX IDX_EAA81A4C260BD8B9 ON transactions (payee_uuid)');
        $this->addSql('ALTER TABLE operations ADD CONSTRAINT FK_281453485DECD70C FOREIGN KEY (account_uuid) REFERENCES accounts (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE operations ADD CONSTRAINT FK_28145348333C6E07 FOREIGN KEY (transaction_uuid) REFERENCES transactions (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C38D8EA9A FOREIGN KEY (payer_uuid) REFERENCES accounts (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transactions ADD CONSTRAINT FK_EAA81A4C260BD8B9 FOREIGN KEY (payee_uuid) REFERENCES accounts (uuid) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operations DROP CONSTRAINT FK_281453485DECD70C');
        $this->addSql('ALTER TABLE transactions DROP CONSTRAINT FK_EAA81A4C38D8EA9A');
        $this->addSql('ALTER TABLE transactions DROP CONSTRAINT FK_EAA81A4C260BD8B9');
        $this->addSql('ALTER TABLE operations DROP CONSTRAINT FK_28145348333C6E07');
        $this->addSql('DROP TABLE accounts');
        $this->addSql('DROP TABLE operations');
        $this->addSql('DROP TABLE transactions');
    }
}
