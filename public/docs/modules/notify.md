#Notifications - всплывающие сообщения

##Документация

* [Страница разработчика](https://github.com/shakee93/vue-toasted)
* [Demo](https://shakee93.github.io/vue-toasted/)

##файлы кастомные

* [css](../../public/css/toasted.css)

##Пример использования

```
Vue.toasted.show(`<div>Delegated to ${acarya.displayName}.</div>`, {
    position: "top-center",
    type: 'show',
    duration: null,
    closeOnSwipe: true,
    action : [
        {
            text : 'Ok',
            onClick : (e, toastObject) => {
                toastObject.goAway(0);
            }
        }

    ]
});
```
