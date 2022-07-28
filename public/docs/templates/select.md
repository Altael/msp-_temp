#Замена стандартного select

## Код html

```
<dropdown v-model="filters.lesson" class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto" :options='lessonNumbers' />
```


## Файлы

* [vue](../../resources/js/components/Dropdown.vue)
* [Стандартний dropdown](dropdown.md)

## Код vue

```
<template>

    <div class="dhrtDropdown" data-position="down" data-indent-down="16" data-indent-up="16">
        <div class="dhrtDropdown-back"></div>
        <a href="#" class="dhrtDropdown-link" rel="nofollow" data-toggle="dhrtDropdown" role="button" aria-haspopup="true" aria-expanded="false">
            {{ options[value] }}
        </a>
        <div class="dhrtDropdown-menu">
            <a href="#" v-for="(value, key) of options" @click.prevent="set(key)" rel="nofollow" class="dhrtDropdown-item">{{ value }}</a>
        </div>
    </div>

</template>

<script>
    export default {
        props: ['value', 'options'],

        methods: {
            set (value) {
                this.$emit('input', value);
            }
        }
    }
</script>

```
