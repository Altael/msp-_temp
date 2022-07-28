#Tooltip

## Синтаксис

у любого объекта применяем атрибут title="""

## Для обычных title

Добавляем в основные файлы

- app.blade.php
- user.blade.php

```
<script>
    $('[title]').tooltip();
</script>
```

## Для страниц с загрузкой данных из ajax

```
axios.get(... {
    
    this.$nextTick(() => {
        $('.classOfPage [title]').tooltip();
    });
});
```
