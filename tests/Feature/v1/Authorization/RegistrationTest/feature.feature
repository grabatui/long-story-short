#language: ru

Функционал:
  Регистрация
  Предыстория:
    Когда в базе данных есть пользователь с email "username@test.test" с паролем "123123"

  Сценарий: С пустыми данными
    Когда мы делаем post-запрос в "/api/v1/authorization/register" с данными из "data/1.empty.request.json"
    Тогда должен быть получен статус 400
    И в ответе есть ошибка поля "email" с сообщением "Это поле отсутствует."
    И в ответе есть ошибка поля "name" с сообщением "Это поле отсутствует."
    И в ответе есть ошибка поля "password" с сообщением "Это поле отсутствует."
    И в ответе есть ошибка поля "password_repeat" с сообщением "Это поле отсутствует."

  Сценарий: С неполными данными
    Когда мы делаем post-запрос в "/api/v1/authorization/register" с данными из "data/2.notFull.request.json"
    Тогда должен быть получен статус 400
    И в ответе есть ошибка поля "password" с сообщением "Это поле отсутствует."
    И в ответе есть ошибка поля "password_repeat" с сообщением "Это поле отсутствует."

  Сценарий: С уже существующим пользователем
    Когда мы делаем post-запрос в "/api/v1/authorization/register" с данными из "data/3.emailAlreadyExists.request.json"
    Тогда должен быть получен статус 400
    И в ответе есть ошибка поля "email" с сообщением "Такой Email уже существует"

  Сценарий: Невалидный email
    Когда мы делаем post-запрос в "/api/v1/authorization/register" с данными из "data/4.emailNotValid.request.json"
    Тогда должен быть получен статус 400
    И в ответе есть ошибка поля "email" с сообщением "Значение адреса электронной почты недопустимо."

  Сценарий: Слишком короткие пароли
    Когда мы делаем post-запрос в "/api/v1/authorization/register" с данными из "data/5.tooShortPassword.request.json"
    Тогда должен быть получен статус 400
    И в ответе есть ошибка поля "password" с сообщением "Значение слишком короткое. Должно быть равно 7 символам или больше."
    И в ответе есть ошибка поля "password_repeat" с сообщением "Значение слишком короткое. Должно быть равно 7 символам или больше."

  Сценарий: Слишком короткие пароли
    Когда мы делаем post-запрос в "/api/v1/authorization/register" с данными из "data/6.notTheSamePassword.request.json"
    Тогда должен быть получен статус 400
    И в ответе есть ошибка поля "password_repeat" с сообщением "Пароли должны совпадать"

  Сценарий: Успех
    Когда мы делаем post-запрос в "/api/v1/authorization/register" с данными из "data/7.success.request.json"
    Тогда должен быть получен статус 200
