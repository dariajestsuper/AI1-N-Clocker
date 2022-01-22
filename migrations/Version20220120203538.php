<?php

declare(strict_types=1);

namespace DoctrineMigrations;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use App\Entity\User;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220120203538 extends AbstractMigration implements ContainerAwareInterface
{
    use ContainerAwareTrait;
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->connection->executeQuery('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $user = new User();
        $user->setEmail('email@emai.com');
        $passwordHasher = $this->container->get('security.password_hasher');
        $pass = $passwordHasher->hashPassword(
        $user,
        'admin');
        $user->setPassword($pass);
        $user->setRoles(["ROLE_USER","ROLE_ADMIN"]);
        $em = $this->container->get('doctrine.orm.entity_manager');
        $em->persist($user);
        $em->flush();
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE user');
    }
}
