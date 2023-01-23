<?php

namespace App\Tests\Feature;

use App\Core\Persistence\Entity\User;
use Doctrine\Persistence\ConnectionRegistry;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException;
use RuntimeException;
use Symfony\Component\DomCrawler\Crawler;

trait RequestResponseTrait
{
    private Crawler $crawler;

    private ?string $defaultUsername = null;
    private ?string $defaultPassword = null;

    private ?string $accessToken = null;

    /**
     * @When в базе данных есть пользователь с email :email с паролем :password
     */
    public function whenThereIsUserInDatabaseWithUsernameAndPassword(string $email, string $password): void
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword(
            $this->hasher->hashPassword($user, $password)
        );
        $user->setName('Test Name');

        $this->getEntityManager()->getRepository(User::class)->save($user, true);

        $this->defaultUsername = $email;
        $this->defaultPassword = $password;
    }

    /**
     * @When мы авторизованы
     * @throws JWTEncodeFailureException
     */
    public function weAreAuthorized(): void
    {
        if (!$this->defaultUsername || !$this->defaultPassword) {
            throw new RuntimeException('User is not exists');
        }

        $this->accessToken = $this->JWTEncoder->encode([
            'username' => $this->defaultUsername,
            'password' => $this->defaultPassword,
        ]);
    }

    /**
     * @When мы делаем get-запрос в :path
     */
    public function weDoGetRequestToPath(string $path): void
    {
        $server = [];
        if ($this->accessToken) {
            $server['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $this->accessToken);
        }

        $this->crawler = $this->getClient()->xmlHttpRequest('GET', $path, [], [], $server);
    }

    /**
     * @Then должен быть получен статус :status
     */
    public function shouldBeReceivedStatus(int $status): void
    {
        if ($this->getClient()->getResponse()->getStatusCode() !== $status) {
            throw new RuntimeException(
                sprintf(
                    'Ожидался статус %d, пришёл статус %d',
                    $status,
                    $this->getClient()->getResponse()->getStatusCode()
                )
            );
        }
    }

    /**
     * @Then должен быть получен валидный ответ
     */
    public function shouldBeReceivedValidResponse(): void
    {
        if ($this->getClient()->getResponse()->getStatusCode() !== 200) {
            throw new RuntimeException(
                sprintf(
                    'Ошибка ответа %d: %s',
                    $this->getClient()->getResponse()->getStatusCode(),
                    $this->getClient()->getResponse()->getContent()
                )
            );
        }
    }

    /**
     * @Then в ответе пришло сообщение :message
     */
    public function thereIsTheMessageInTheResponse(string $message): void
    {
        $data = json_decode($this->getClient()->getResponse()->getContent(), true);

        if (!array_key_exists('message', $data)) {
            throw new RuntimeException('Ответ имеет невалидный формат');
        }

        if ($message != $data['message']) {
            throw new RuntimeException(
                sprintf(
                    'Сообщение не сходится: "%s" вместо "%s"',
                    $data['message'],
                    $message
                )
            );
        }
    }

    /**
     * @Then в ответе есть поле :field со значением :value
     */
    public function thereIsFieldWithValueInTheResponse(string $field, string $value): void
    {
        $data = json_decode($this->getClient()->getResponse()->getContent(), true);

        if (!array_key_exists('data', $data)) {
            throw new RuntimeException('Ответ имеет невалидный формат');
        }

        $data = $data['data'];

        if (
            !array_key_exists($field, $data)
            || $data[$field] != $this->processScalarValueFromString($value)
        ) {
            throw new RuntimeException(
                sprintf(
                    'Значение поля "%s" не сходится: "%s" вместо "%s"',
                    $field,
                    $this->processScalarValueToStrong($data[$field] ?? null),
                    $value
                )
            );
        }
    }

    private function getEntityManager(): ConnectionRegistry
    {
        return $this->getKernel()->getContainer()->get('doctrine');
    }

    private function processScalarValueFromString(string $value): string|int|bool|null
    {
        if (is_numeric($value)) {
            return (int) $value;
        }

        if (in_array($value, ['true', 'false'])) {
            return (bool) $value;
        }

        if ($value === 'null') {
            return null;
        }

        return $value;
    }

    private function processScalarValueToStrong(mixed $value): string
    {
        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if (is_null($value)) {
            return 'null';
        }

        return (string) $value;
    }
}
