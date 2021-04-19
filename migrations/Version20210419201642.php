<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419201642 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE admin_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('DROP INDEX uniq_880e0d7683a00e68');
        $this->addSql('DROP INDEX uniq_880e0d76f85e0677');
        $this->addSql('DROP INDEX uniq_880e0d763124b5b6');
        $this->addSql('ALTER TABLE admin DROP username');
        $this->addSql('ALTER TABLE admin DROP roles');
        $this->addSql('ALTER TABLE admin DROP lastname');
        $this->addSql('ALTER TABLE admin DROP firstname');
        $this->addSql('ALTER TABLE admin DROP password');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE admin_id_seq CASCADE');
        $this->addSql('ALTER TABLE admin ADD username VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE admin ADD roles JSON NOT NULL');
        $this->addSql('ALTER TABLE admin ADD lastname VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE admin ADD firstname VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE admin ADD password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX uniq_880e0d7683a00e68 ON admin (firstname)');
        $this->addSql('CREATE UNIQUE INDEX uniq_880e0d76f85e0677 ON admin (username)');
        $this->addSql('CREATE UNIQUE INDEX uniq_880e0d763124b5b6 ON admin (lastname)');
    }
}
