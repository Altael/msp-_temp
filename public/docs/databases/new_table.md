#Создание новой таблицы

Пример
Таблица для ежедневных практик "Daily Practices"

название таблицы: 
daily_practices 
(множественное число с подчеркиванием в качестве разделителя слов)

###Шаг 1. Создаем миграцию

```
php artisan make:migration CreateDailyPracticesTable
```
Внимание! 
Название таблицы во множественном числе без подчеркиваний


###Шаг 2. Создаем модель

```
php artisan make:model DailyPractice
```
Внимание! Название модели в единственном числе

###Шаг 3. В миграцию добавляем поля

между 

```
$table->bigIncrements('id'); 
```
и 
```
$table->timestamps();
```

####Поле связи с родительской таблицей

```
  $table->bigInteger('user_id');
  $table->foreign('user_id')->references('id')
      ->on('users')->onDelete('cascade')->onUpdate('cascade');
```

####Шаг 4. Добавляем в модель родительской таблицы User связи

```
public function dailyPractices()
    {
        return $this->hasMany(DailyPractice::class, 'user_id');
    }
```

####Шаг 5. Пересоздаем базу

[Выполняем инструкциию создания данных](datas.md)

