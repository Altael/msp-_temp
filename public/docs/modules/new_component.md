#Создаем новый компонент

Например, компонент для работы с дневниками 

##Шаг 1. 

``` 
app/Http/Controllers/ViewsController.php
```

``` 
public function diary()
    {
        return view('diary.index');
    }
``` 

##Шаг 2. 

``` 
routes/web.php
```

``` 
Route::get('/diary', 'ViewsController@diary');
``` 

##Шаг 3. 

``` 
resources/js/app.js
```

``` 
Vue.component('diary', require('./components/Diary').default);
``` 

##Шаг 4. 

``` 
app/Http/Controllers/User/HomeController.php
```

``` 
public function diary()
    {
        return view('diary.index');
    }
``` 

##Шаг 5. Создаем index

``` 
resources/views/diary/index.blade.php
```

``` 
@extends(\Illuminate\Support\Str::endsWith(url()->current(), 'user/diary') ? 'layouts.user' : 'layouts.app')

@section('body_class', 'appPageDiary')

@section('page', __('Diary'))

@section('content')
    <diary user-id="{{ auth()->id() }}"></diary>
@endsection

``` 

##Шаг 6. Создаем файл resources/js/components/Diary.vue

``` 
<template>
    <div></div> 
</template>

<script>
    export default {

        props: ['userId'],

        data() {
            return {

            }
        }
    }
</script>```
