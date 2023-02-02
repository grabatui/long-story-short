<?php

namespace App\Tests\Feature;

use App\Core\Persistence\Repository\UserRepository;
use App\Tests\Feature\Traits\RequestResponseTrait;
use Behat\Behat\Context\Context;
use Doctrine\ORM\Tools\SchemaTool;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use LogicException;
use ReflectionClass;
use RuntimeException;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

abstract class AbstractFeatureContext implements Context
{
    use RequestResponseTrait;

    private static KernelInterface $kernel;
    private static KernelBrowser $kernelBrowser;

    public function __construct(
        protected JWTEncoderInterface $JWTEncoder,
        protected UserPasswordHasherInterface $hasher,
        protected UserRepository $userRepository
    ) {}

    /**
     * @BeforeSuite
     */
    public static function beforeSuite(): void
    {
        self::$kernel = self::makeKernel();
        self::$kernelBrowser = self::$kernel->getContainer()->get('test.client');
    }

    /**
     * @BeforeScenario
     */
    public static function beforeScenario(): void
    {
        // Reset tables
        $entityManager = self::$kernel->getContainer()->get('doctrine')->getManager();

        $metaData = $entityManager->getMetadataFactory()->getAllMetadata();

        $schemaTool = new SchemaTool($entityManager);
        $schemaTool->dropSchema($metaData);
        $schemaTool->updateSchema($metaData, true);
    }

    protected function getKernel(): KernelInterface
    {
        return self::$kernel;
    }

    protected function getClient(): KernelBrowser
    {
        return self::$kernelBrowser;
    }

    protected function getContainer(): Container
    {
        return $this->getKernel()->getContainer()->get('test.service_container');
    }

    protected function getClassPath(): string
    {
        $reflection = new ReflectionClass(get_called_class());

        return dirname(
            $reflection->getFileName()
        );
    }

    private static function makeKernel(): KernelInterface
    {
        $kernelClass = self::getKernelClass();

        if (isset($_ENV['APP_DEBUG'])) {
            $debug = $_ENV['APP_DEBUG'];
        } elseif (isset($_SERVER['APP_DEBUG'])) {
            $debug = $_SERVER['APP_DEBUG'];
        } else {
            $debug = true;
        }

        $kernel = new $kernelClass('test', $debug);
        $kernel->boot();

        return $kernel;
    }

    private static function getKernelClass(): string
    {
        if (!isset($_SERVER['KERNEL_CLASS']) && !isset($_ENV['KERNEL_CLASS'])) {
            throw new LogicException(
                sprintf(
                    'You must set the KERNEL_CLASS environment variable to the fully-qualified class name of your Kernel in phpunit.xml / phpunit.xml.dist or override the "%1$s::createKernel()" or "%1$s::getKernelClass()" method.',
                    static::class
                )
            );
        }

        if (!class_exists($class = $_ENV['KERNEL_CLASS'] ?? $_SERVER['KERNEL_CLASS'])) {
            throw new RuntimeException(
                sprintf(
                    'Class "%s" doesn\'t exist or cannot be autoloaded. Check that the KERNEL_CLASS value in phpunit.xml matches the fully-qualified class name of your Kernel or override the "%s::createKernel()" method.',
                    $class,
                    static::class
                )
            );
        }

        return $class;
    }
}
