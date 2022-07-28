#Создаем новую базу

Шаг 1. В терминале в директории проекта запускаем миграцию

```
php artisan migrate:fresh --seed
```

Шаг 2.  Запускаем seed для создания основных пользователей (ачарьи, помощники, админы)

```
php artisan db:seed --class=YourNameSeeder
```
YourNameSeeder - имя нужного файла (DhrtiSeeder, AsitimaSeeder)

Шаг 3.  Запускаем seed для создания 100 садхак

```
php artisan db:seed --class=TestSeeder
```

Шаг 4. Добавляем Ачарью во Львов в Гео
