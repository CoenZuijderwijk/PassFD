<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200205100644 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE clothing_piece ADD user_id INT NOT NULL, ADD uri MEDIUMTEXT NOT NULL, DROP image_file_name');
        $this->addSql('ALTER TABLE clothing_piece ADD CONSTRAINT FK_67C3971DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_67C3971DA76ED395 ON clothing_piece (user_id)');
        $this->addSql('ALTER TABLE user ADD username VARCHAR(255) NOT NULL, ADD roles JSON NOT NULL, ADD face_image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE clothing_piece DROP FOREIGN KEY FK_67C3971DA76ED395');
        $this->addSql('DROP INDEX IDX_67C3971DA76ED395 ON clothing_piece');
        $this->addSql('ALTER TABLE clothing_piece ADD image_file_name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP user_id, DROP uri');
        $this->addSql('ALTER TABLE user DROP username, DROP roles, DROP face_image');
    }
}
