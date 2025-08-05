# Blog-API
REST API приложение для управления пользователями, постами и комментариями.

## 📚 Документация API

Документация Swagger доступна по корневому пути: `/`

## Технологии

-   **Backend**: Laravel 12
-   **База данных**: MySQL
-   **Документация**: Swagger (пакет darkaonline/l5-swagger)
-   **Тесты**: PHPUnit (26 тестов, включая Requests)

## 🚀 Функционал

### Основные сущности

-   Пользователи
-   Посты
-   Комментарии

### Тестирование

Добавлены 26 для GRUD операций из них 3 unit-теста для requests
Для запуска тестирования используйте команду:

```bash
php artisan test
```

## Установка

1. Клонировать репозиторий:

```bash
git clone https://github.com/ManasArs13/blog-api.git && cd blog-api
```

2. Установить зависимости:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

3. Запустить Laravel Sail:

```bash
sail build --no-cache
./vendor/bin/sail composer install
./vendor/bin/sail up -d
```

4. Запустить миграции (для удобства тестирования созданы тестовые данные, используя Factories и Seeders):

```bash
php artisan migrate --seed
```

