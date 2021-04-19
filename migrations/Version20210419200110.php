<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419200110 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE admin_id_seq CASCADE');
        $this->addSql('ALTER TABLE admin ADD username VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE admin ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE admin ADD lastname VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE admin ADD firstname VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE admin ADD password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76F85E0677 ON admin (username)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D763124B5B6 ON admin (lastname)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D7683A00E68 ON admin (firstname)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE admin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP INDEX UNIQ_880E0D76F85E0677');
        $this->addSql('DROP INDEX UNIQ_880E0D763124B5B6');
        $this->addSql('DROP INDEX UNIQ_880E0D7683A00E68');
        $this->addSql('ALTER TABLE admin DROP username');
        $this->addSql('ALTER TABLE admin DROP roles');
        $this->addSql('ALTER TABLE admin DROP lastname');
        $this->addSql('ALTER TABLE admin DROP firstname');
        $this->addSql('ALTER TABLE admin DROP password');
    }
}
