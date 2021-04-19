<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210419220838 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE guest DROP CONSTRAINT fk_acb79a3579f37ae5');
        $this->addSql('DROP INDEX uniq_acb79a3579f37ae5');
        $this->addSql('ALTER TABLE guest DROP id_user_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE guest ADD id_user_id INT NOT NULL');
        $this->addSql('ALTER TABLE guest ADD CONSTRAINT fk_acb79a3579f37ae5 FOREIGN KEY (id_user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_acb79a3579f37ae5 ON guest (id_user_id)');
    }
}
