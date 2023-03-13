<?php

namespace App\Tests\Feature\Traits;

use App\Core\Persistence\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use JsonException;
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
    public function thereIsUserInDatabaseWithUsernameAndPassword(string $email, string $password): void
    {
        $user = new User();
        $user->setEmail($email);
        $user->setPassword(
            $this->hasher->hashPassword($user, $password)
        );
        $user->setName('Test Name');

        $this->userRepository->save($user, true);

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
     * @When мы делаем get-запрос в :path с данными :data
     */
    public function weDoGetRequestWithQueryToPath(string $path, string $jsonData): void
    {
        try {
            $jsonData = json_decode($jsonData, true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new RuntimeException('Невалидный json в данных');
        }

        $this->weDoGetRequestToPath($path . '?' . http_build_query($jsonData));
    }

    /**
     * @When мы делаем get-запрос в :path
     */
    public function weDoGetRequestToPath(string $path): void
    {
        $server = ['CONTENT_TYPE' => 'application/json'];
        if ($this->accessToken) {
            $server['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $this->accessToken);
        }

        $this->crawler = $this->getClient()->xmlHttpRequest('GET', $path, [], [], $server);
    }

    /**
     * @When мы делаем post-запрос в :path с данными из :dataPath
     */
    public function weDoPostRequestToPathWithDataFrom(string $path, string $dataPath): void
    {
        $data = $this->getAndCheckDataFilePath($dataPath);

        $this->doPostRequestWithData($path, $data);
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

        $dataValue = $this->receiveValueFromDataByField($field, $data);

        if ($dataValue != $this->processScalarValueFromString($value)) {
            throw new RuntimeException(
                sprintf(
                    'Значение поля "%s" не сходится: "%s" вместо "%s"',
                    $field,
                    $this->processScalarValueToStrong($dataValue),
                    $value
                )
            );
        }
    }

    /**
     * @Then в ответе есть ошибка поля :field с сообщением :message
     */
    public function thereIsErrorWithMessageInTheResponse(string $field, string $message): void
    {
        $data = json_decode($this->getClient()->getResponse()->getContent(), true);

        if (!array_key_exists('errors', $data)) {
            throw new RuntimeException('Ответ имеет невалидный формат');
        }

        $errors = $data['errors'];

        if (empty($errors)) {
            throw new RuntimeException('Ответ имеет невалидный формат');
        }

        foreach ($errors as $error) {
            if ($error['path'] === $field) {
                $fieldErrorMessage = str_replace('"', '', $error['message']);

                if ($fieldErrorMessage !== $message) {
                    throw new RuntimeException(
                        sprintf(
                            'Сообщение ошибки поля "%s" не сходится: "%s" вместо "%s"',
                            $field,
                            $error['message'],
                            $message
                        )
                    );
                }

                return;
            }
        }

        throw new RuntimeException(
            sprintf('Ошибка "%s" не найдена', $field)
        );
    }

    protected function getEntityManager(): ManagerRegistry
    {
        return $this->getKernel()->getContainer()->get('doctrine');
    }

    protected function doPostRequestWithData(string $path, array|string $data): void
    {
        $server = ['CONTENT_TYPE' => 'application/json'];
        if ($this->accessToken) {
            $server['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $this->accessToken);
        }

        $this->crawler = $this->getClient()
            ->xmlHttpRequest('POST', $path, [], [], $server, is_array($data) ? json_encode($data) : $data);
    }

    protected function getDefaultUser(): ?User
    {
        if (!$this->defaultUsername) {
            return null;
        }

        return $this->userRepository->findOneBy(['email' => $this->defaultUsername]);
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

    private function receiveValueFromDataByField(string $field, array $data): mixed
    {
        if (str_contains($field, '.')) {
            $fieldParts = explode('.', $field);

            do {
                $fieldPart = array_shift($fieldParts);

                if (!array_key_exists($fieldPart, $data)) {
                    return null;
                }

                $data = $data[$fieldPart];
            } while (!empty($fieldParts));

            return $data;
        }

        return array_key_exists($field, $data) ? $data[$field] : null;
    }
}
