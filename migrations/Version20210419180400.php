<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419180400 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE speciality ADD agent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE speciality ADD CONSTRAINT FK_F3D7A08E3414710B FOREIGN KEY (agent_id) REFERENCES agent (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_F3D7A08E3414710B ON speciality (agent_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE speciality DROP CONSTRAINT FK_F3D7A08E3414710B');
        $this->addSql('DROP INDEX IDX_F3D7A08E3414710B');
        $this->addSql('ALTER TABLE speciality DROP agent_id');
    }
}
