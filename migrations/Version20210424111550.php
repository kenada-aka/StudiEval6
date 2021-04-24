<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210424111550 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_9067f23c8572d9b2');
        $this->addSql('CREATE INDEX IDX_9067F23C8572D9B2 ON mission (id_speciality_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX IDX_9067F23C8572D9B2');
        $this->addSql('CREATE UNIQUE INDEX uniq_9067f23c8572d9b2 ON mission (id_speciality_id)');
    }
}
