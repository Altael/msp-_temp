#Шрифт из иконок


## Подготавливаемся для импорта

- На сайте https://icomoon.io/app/#/select 
в меню набора иконок "mspp-icons"
выбираем "Remove Set"
 
## Находим json-файл

- Копируем файл public/fonts/mspp-icons-v1.0/selection.json 

Примечание. Если файл selection.json отсутствует, то можно взять последнюю версию в архиве public/fonts/mspp-icons-v1.0.zip

## Загружаем последнюю версию набора иконок

- На сайте https://icomoon.io/app/#/select выбираем в меню "New Empty Set"
- В меню созданного набора иконок "Untitled Set" выбираем "Import to Set"
- Выбираем json-файл из предыдущего шага
- На вопрос системы "Your icon selection was loaded. Would you like to load all the settings stored in your selection file?" отвечаем "Yes"
- Появится набор иконок "msp-icons"

## Добавление иконки

Используем svg-файлы иконок

- В меню набора "msp-icons" выбираем "Import to Set"
- Указываем svg-файл иконки 
- Чтобы добавить выбранную иконку в набор, необходимо выбрать инструмент "Select" в панели инструментов (сверху, слева - кнопка со стрелкой) и щелкнуть на добавленную иконку


## Изменяем название иконки и теги

- В панели инструментов выбираем инструмент "Edit" и щелкаем по нужной иконке
- В поле "Names" вводим корректное название

## Экспортируем набор иконок 

- Внизу экрана справа нажимаем "Generate Font"
- В настройках набора проверяем настройки "Preferences" 
  Важно!!! Font Name: msp-icons
           Class Prefix: msppIcons-
- Кнопкой "Download" сохраняем архив в /public/fonts/
- Удаляем директорию /public/fonts/msp-icons-v1.0
- Распаковываем скачанный архив в /public/fonts/msp-icons-v1.0            

## Просматриваем существующие иконки

- Открываем в браузере файл public/fonts/msp-icons-v1.0/demo.html
