#Права доступа

##Проверка роли пользователя 

```
@if (auth()->check() && auth()->user()->hasRole('sadhaka|margii'))
@endif 
```

``` 
if (!auth()->user()->hasRole('acarya')) return abort('Unauthorized');
```

###Шаг 1

Функция разделения интерфейса

```
app/Http/Middleware/RedirectIfUser.php
```

###Шаг 2

Добавляем новую роль в сид

```
database/seeds/RolesTableSeeder.php
```

###Шаг 3

распределяем права в меню

для садках и марги
```
resources/views/layouts/user.blade.php
``` 
для всех остальных
```
resources/views/layouts/app.blade.php
``` 


