<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210420215957 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agent DROP CONSTRAINT fk_268b9c9d4efa5b4c');
        $this->addSql('DROP INDEX idx_268b9c9d4efa5b4c');
        $this->addSql('ALTER TABLE agent RENAME COLUMN id_mission TO id_mission_id');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9D1BE62E47 FOREIGN KEY (id_mission_id) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_268B9C9D1BE62E47 ON agent (id_mission_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE agent DROP CONSTRAINT FK_268B9C9D1BE62E47');
        $this->addSql('DROP INDEX IDX_268B9C9D1BE62E47');
        $this->addSql('ALTER TABLE agent RENAME COLUMN id_mission_id TO id_mission');
        $this->addSql('ALTER TABLE agent ADD CONSTRAINT fk_268b9c9d4efa5b4c FOREIGN KEY (id_mission) REFERENCES mission (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_268b9c9d4efa5b4c ON agent (id_mission)');
    }
}
