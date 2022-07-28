# Информационное окно

Раскрывается на весь экран. 

В верхней строке 
слева - заголовок, который передается в переменной title (функция перевода внутри компонента)
справа - крестик закрытия

рассчитано на видео-инструкци (по умолчанию) либо текст (параметр :with-text="true")

во внутрь компонента передается любое содержимое

состоит из кнопки infoBlock и модального окна infoBlockModal

##кнопка 
— это иконка
по умолчанию msppIcons-help-circle
в другом случае передается параметром "icon" 

## Файлы

*[css](../../../resources/sass/main.scss)
в файле main.scss блок .infoBlock

###компонент
*[app.js](../../../resources/js/app.js)
Vue.component('info', require('./components/tools/Info').default);

*[vue](../../../resources/js/components/tools/Info.vue)

## Template для PHPStorm

```html
<info :with-text="false" title="How to register" icon="msppIcons-arrow-up-right">
    $END$
</info>

```

## Пример видео

<iframe width="640" height="360" src="https://drive.google.com/file/d/1-10UgDHeW4oE2aQoGKE5xLrae1mvqu5f/preview"></iframe>

