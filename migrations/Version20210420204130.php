<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210420204130 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent ADD agents_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D709770DC FOREIGN KEY (agents_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_268B9C9D709770DC ON agent (agents_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE agent DROP CONSTRAINT FK_268B9C9D709770DC');
        $this->addSql('DROP INDEX IDX_268B9C9D709770DC');
        $this->addSql('ALTER TABLE agent DROP agents_id');
    }
}
