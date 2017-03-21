<?php

namespace Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170321225057 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql('CREATE TABLE procuration_managed_areas (id INT AUTO_INCREMENT NOT NULL, adherent_id INT UNSIGNED DEFAULT NULL, codes LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:simple_array)\', UNIQUE INDEX UNIQ_117496A025F06C53 (adherent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE procuration_managed_areas ADD CONSTRAINT FK_117496A025F06C53 FOREIGN KEY (adherent_id) REFERENCES adherents (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE procuration_requests ADD found_proxy_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE procuration_requests ADD CONSTRAINT FK_9769FD842F1B6663 FOREIGN KEY (found_proxy_id) REFERENCES procuration_proxies (id) ON DELETE SET NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9769FD842F1B6663 ON procuration_requests (found_proxy_id)');
        $this->addSql('ALTER TABLE procuration_proxies ADD found_request_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE procuration_proxies ADD CONSTRAINT FK_9B5E777A6BE28CC8 FOREIGN KEY (found_request_id) REFERENCES procuration_requests (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9B5E777A6BE28CC8 ON procuration_proxies (found_request_id)');
    }

    public function down(Schema $schema)
    {
        $this->addSql('ALTER TABLE procuration_proxies DROP FOREIGN KEY FK_9B5E777A6BE28CC8');
        $this->addSql('DROP INDEX UNIQ_9B5E777A6BE28CC8 ON procuration_proxies');
        $this->addSql('ALTER TABLE procuration_proxies DROP found_request_id');
        $this->addSql('ALTER TABLE procuration_requests DROP FOREIGN KEY FK_9769FD842F1B6663');
        $this->addSql('DROP INDEX UNIQ_9769FD842F1B6663 ON procuration_requests');
        $this->addSql('ALTER TABLE procuration_requests DROP found_proxy_id');
        $this->addSql('DROP TABLE procuration_managed_areas');
    }
}
