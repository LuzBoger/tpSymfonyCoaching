<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241220161127 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE follow_up (id INT AUTO_INCREMENT NOT NULL, comments VARCHAR(255) NOT NULL, rating INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE program (id INT AUTO_INCREMENT NOT NULL, user_program_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, INDEX IDX_92ED778499DFC1E6 (user_program_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE session (id INT AUTO_INCREMENT NOT NULL, program_id INT DEFAULT NULL, follow_up_id INT DEFAULT NULL, date DATETIME NOT NULL, status VARCHAR(255) NOT NULL, INDEX IDX_D044D5D43EB8070A (program_id), UNIQUE INDEX UNIQ_D044D5D410CBCEA6 (follow_up_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_session (user_id INT NOT NULL, session_id INT NOT NULL, INDEX IDX_8849CBDEA76ED395 (user_id), INDEX IDX_8849CBDE613FECDF (session_id), PRIMARY KEY(user_id, session_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE program ADD CONSTRAINT FK_92ED778499DFC1E6 FOREIGN KEY (user_program_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D43EB8070A FOREIGN KEY (program_id) REFERENCES program (id)');
        $this->addSql('ALTER TABLE session ADD CONSTRAINT FK_D044D5D410CBCEA6 FOREIGN KEY (follow_up_id) REFERENCES follow_up (id)');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT FK_8849CBDEA76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_session ADD CONSTRAINT FK_8849CBDE613FECDF FOREIGN KEY (session_id) REFERENCES session (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE program DROP FOREIGN KEY FK_92ED778499DFC1E6');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D43EB8070A');
        $this->addSql('ALTER TABLE session DROP FOREIGN KEY FK_D044D5D410CBCEA6');
        $this->addSql('ALTER TABLE user_session DROP FOREIGN KEY FK_8849CBDEA76ED395');
        $this->addSql('ALTER TABLE user_session DROP FOREIGN KEY FK_8849CBDE613FECDF');
        $this->addSql('DROP TABLE follow_up');
        $this->addSql('DROP TABLE program');
        $this->addSql('DROP TABLE session');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE user_session');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
