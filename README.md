# Частичное решение задания для PHP-разработчика — Разработка API

## Описание задачи

Необходимо написать простейшее API для каталога товаров. Приложение должно содержать:
- Категории товаров
- Конкретные товары, которые принадлежат к какой-то категории (один товар может принадлежать нескольким категориям)
- Пользователей, которые могут авторизоваться

Возможные действия:
- Получение списка всех категорий
- Получение списка товаров в конкретной категории
- Авторизация пользователей
- Добавление/Редактирование/Удаление категории (для авторизованных пользователей)
- Добавление/Редактирование/Удаление товара (для авторизованных пользователей)

## Технические требования
1. Приложение должно быть написано на PHP
2. Приложение не должно быть написано с помощью какого-либо фреймворка, однако можно устанавливать для него различные пакеты через compоser
3. Результаты запросов должны быть представлены в формате JSON
4. Результат задания должен быть выложен на github, должна быть инструкция по запуску проекта. Также необходимо пояснить, сколько на каждую часть проекта ушло времени

## Критерии оценки
- Архитектурная организация API
- Грамотное применение ООП и паттернов проектирования
- Корректная обработка внештатных ситуаций
- Код-стайл и соблюдение стандартов
- Покрытие кода тестами (функциональными или unit)

## Запуск
- Для запуска требуется Vagrant
```bash
vagrant plugin install vagrant-hostmanager
vagrant up
```
- Если запуск осуществляется на ОС Linux
```bash
echo "192.168.84.137  store.test" >> /etc/hosts
```

- Заходим на http://store.test

# Описание API

# Product store

## User login [/api/login]

### Login [POST]

+ Request (application/json)

        {
            "username": "username",
            "password": "password"
        }

+ Response 200 (application/json)

    + Headers
    
            Authorization: AuthTokenString

    + Body

            {
                 "token": "AuthTokenString"
            }

+ Response 422 (application/json)

    + Body

            {
                "username": [
                  "The username must be at least 3 characters.",
                  "The username field is required."
                  ],
                "password": [
                   "The password must be at least 8 characters.",
                ]
            }
            
+ Response 422 (application/json)

    + Body

            {
                "username": [
                  "Incorrect credentials!",
                ]
            }

## User login [/api/logout]

### Logout [POST]

+ Request (application/json)
    
    + Header
        
            Authorization: null

+ Response 401 (application/json)

    + Body
    
            {
              "error": "You unauthorized!"
            }

+ Request (application/json)
    
    + Header
        
            Authorization: CorrentAuthTokenString

+ Response 200 (application/json)

    + Header
        
            Authorization: 
            
    + Body
    
            {
                "message": "Successfully logged out"
            }

## List of categories [/api/categories]

### Categories [GET]

+ Response 200 (application/json)

    + Body
    
            [
                {
                    "id":1,
                    "name":"product category 1"
                },
                {
                    "id":2,
                    "name":"product category 2"
                },
                {
                    "id":3,
                    "name":"product category 3"
                },
                {
                    "id":4,
                    "name":"product category 4"
                }
            ]

## List of categories [/api/category/{id}/products]

### Products [GET]

+ Response 200 (application/json)

    + Body
    
            [
                {
                    "id":1,
                    "name":"product 1"
                },
                {
                    "id":2,
                    "name":"product 2"
                },
                {
                    "id":3,
                    "name":"product 3"
                },
                {
                    "id":4,
                    "name":"product 4"
                }
            ]

+ Response 404 (application/json)

    + Body

            {
                "error": "Category not found!"
            }
 
 
 post /api/product/add
 post /api/category/add
 
 put /api/product/{id}
 put /api/category/{id}
 
 delete /api/product/{id}
 delete /api/category/{id}
