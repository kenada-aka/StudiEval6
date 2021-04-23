<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210422182846 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX uniq_268b9c9d1be62e47');
        $this->addSql('CREATE INDEX IDX_268B9C9D1BE62E47 ON agent (id_mission_id)');
        $this->addSql('DROP INDEX uniq_4c62e6381be62e47');
        $this->addSql('CREATE INDEX IDX_4C62E6381BE62E47 ON contact (id_mission_id)');
        $this->addSql('DROP INDEX uniq_466f2ffc1be62e47');
        $this->addSql('CREATE INDEX IDX_466F2FFC1BE62E47 ON target (id_mission_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX IDX_466F2FFC1BE62E47');
        $this->addSql('CREATE UNIQUE INDEX uniq_466f2ffc1be62e47 ON target (id_mission_id)');
        $this->addSql('DROP INDEX IDX_4C62E6381BE62E47');
        $this->addSql('CREATE UNIQUE INDEX uniq_4c62e6381be62e47 ON contact (id_mission_id)');
        $this->addSql('DROP INDEX IDX_268B9C9D1BE62E47');
        $this->addSql('CREATE UNIQUE INDEX uniq_268b9c9d1be62e47 ON agent (id_mission_id)');
    }
}
