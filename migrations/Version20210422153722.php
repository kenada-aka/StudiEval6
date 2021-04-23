<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422153722 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE speciality_agent (speciality_id INT NOT NULL, agent_id INT NOT NULL, PRIMARY KEY(speciality_id, agent_id))');
        $this->addSql('CREATE INDEX IDX_F42FD6963B5A08D7 ON speciality_agent (speciality_id)');
        $this->addSql('CREATE INDEX IDX_F42FD6963414710B ON speciality_agent (agent_id)');
        $this->addSql('ALTER TABLE speciality_agent ADD CONSTRAINT FK_F42FD6963B5A08D7 FOREIGN KEY (speciality_id) REFERENCES speciality (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE speciality_agent ADD CONSTRAINT FK_F42FD6963414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE speciality DROP CONSTRAINT fk_f3d7a08e709770dc');
        $this->addSql('DROP INDEX idx_f3d7a08e709770dc');
        $this->addSql('ALTER TABLE speciality DROP agents_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE speciality_agent');
        $this->addSql('ALTER TABLE speciality ADD agents_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT fk_f3d7a08e709770dc FOREIGN KEY (agents_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_f3d7a08e709770dc ON speciality (agents_id)');
    }
}
