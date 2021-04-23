<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422153145 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speciality DROP CONSTRAINT fk_f3d7a08e64cf9d9e');
        $this->addSql('DROP INDEX idx_f3d7a08e64cf9d9e');
        $this->addSql('ALTER TABLE speciality RENAME COLUMN id_agent_id TO agents_id');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08E709770DC FOREIGN KEY (agents_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F3D7A08E709770DC ON speciality (agents_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE speciality DROP CONSTRAINT FK_F3D7A08E709770DC');
        $this->addSql('DROP INDEX IDX_F3D7A08E709770DC');
        $this->addSql('ALTER TABLE speciality RENAME COLUMN agents_id TO id_agent_id');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT fk_f3d7a08e64cf9d9e FOREIGN KEY (id_agent_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f3d7a08e64cf9d9e ON speciality (id_agent_id)');
    }
}
