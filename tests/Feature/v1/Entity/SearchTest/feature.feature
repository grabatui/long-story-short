#language: ru

Функционал:
  Поиск сущностей по подстроке
  Предыстория:
    Когда в базе данных есть пользователь с email "username@test.test" с паролем "123123"
    И в базе данных есть фильмы из "data/movies.json"

  Сценарий: С неизвестным типом
    Когда мы делаем get-запрос в "/api/v1/entity/search" с данными '{"term":"test"}'
    Тогда должен быть получен статус 400
    И в ответе есть ошибка поля "type" с сообщением "Это поле отсутствует."

  Сценарий: С неверным типом
    Когда мы делаем get-запрос в "/api/v1/entity/search" с данными '{"term":"test","type":"unknown"}'
    Тогда должен быть получен статус 400
    И в ответе есть ошибка поля "type" с сообщением "unknown не найден среди `all,movies,series`"

  Сценарий: С пустой подстрокой
    Когда мы делаем get-запрос в "/api/v1/entity/search?type=all" с данными '{"type":"all"}'
    Тогда должен быть получен статус 400
    И в ответе есть ошибка поля "term" с сообщением "Это поле отсутствует."

  Сценарий: Успех с конкретным результатом
    Когда в elastic при "POST" запросе в "movies/_search" с данными "data/1.one.request.json" отдаются данные из "data/1.one.response.json"
    И мы делаем get-запрос в "/api/v1/entity/search" с данными '{"term":"Alone entity title","type":"all"}'
    Тогда должен быть получен статус 200
    И в ответе "1" элемент
    И в ответе есть поле "items.0.id" со значением "1"
    И в ответе есть поле "items.0.title" со значением "Alone entity title"
    И в ответе есть поле "items.0.premiered_year" со значением "1900"
    И в ответе есть поле "items.0.poster" со значением "/images/posters/some-poster-name.jpg"

  Сценарий: Успех с несколькими результатами
    Когда в elastic при "POST" запросе в "movies/_search" с данными "data/2.several.request.json" отдаются данные из "data/2.several.response.json"
    И мы делаем get-запрос в "/api/v1/entity/search" с данными '{"term":"title","type":"all"}'
    Тогда должен быть получен статус 200
    И в ответе "2" элемента
    И в ответе есть поле "items.0.id" со значением "2"
    И в ответе есть поле "items.0.title" со значением "First entity title"
    И в ответе есть поле "items.1.id" со значением "3"
    И в ответе есть поле "items.1.title" со значением "Second entity title"
