<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200828093746 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE model3_d CHANGE file_path file_path VARCHAR(255) DEFAULT \'path-to-file.zip\' NOT NULL, CHANGE preview_path preview_path VARCHAR(255) DEFAULT \'path-to-image.png\' NOT NULL, CHANGE rotations rotations JSON NOT NULL, CHANGE type type VARCHAR(10) DEFAULT \'gltf\' NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
        $this->addSql('ALTER TABLE model3_d CHANGE file_path file_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'path-to-file.zip\'\'\' NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE preview_path preview_path VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT \'\'\'path-to-image.png\'\'\' NOT NULL COLLATE `utf8mb4_unicode_ci`, CHANGE rotations rotations LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_bin`, CHANGE type type VARCHAR(10) CHARACTER SET utf8mb4 DEFAULT \'\'\'gltf\'\'\' NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
