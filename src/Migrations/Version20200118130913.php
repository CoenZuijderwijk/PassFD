<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200118130913 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE user_clothing_piece');
        $this->addSql('ALTER TABLE clothing_piece ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE clothing_piece ADD CONSTRAINT FK_67C3971DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_67C3971DA76ED395 ON clothing_piece (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_clothing_piece (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, clothing_piece_id INT NOT NULL, INDEX IDX_C464844A76ED395 (user_id), INDEX IDX_C4648444ED27AA3 (clothing_piece_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_clothing_piece ADD CONSTRAINT FK_C4648444ED27AA3 FOREIGN KEY (clothing_piece_id) REFERENCES clothing_piece (id)');
        $this->addSql('ALTER TABLE user_clothing_piece ADD CONSTRAINT FK_C464844A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE clothing_piece DROP FOREIGN KEY FK_67C3971DA76ED395');
        $this->addSql('DROP INDEX IDX_67C3971DA76ED395 ON clothing_piece');
        $this->addSql('ALTER TABLE clothing_piece DROP user_id');
    }
}
