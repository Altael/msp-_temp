# Avatars

## файлы

* [Avatar.vue](../../resources/js/components/Avatar.vue)

## classes

* _.appAvatar_ - добавляем всегда
* _.appUser-avatar_ - аватарка в блоке "О Пользователе" слева вверху
* _.appLists-avatarImage_ - аватарка в списках
* _.appProfile-avatar_ - аватарка в профиле

## php
```
<avatar class="appAvatar appProfile-avatar" src="{{ $profile->image ? $profile->image : '/images/no-avatar.jpg'}}"></avatar>
```

## js
```
<avatar class="appAvatar appUser-avatar appLists-avatarImage appProfile-avatar" :src="user.profile.image ? user.profile.image : '/images/no-avatar.jpg'"></avatar>
```

## css 
```
.appAvatar {
    border-radius: 100%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 8px;
    border: 1px solid #fff;
    flex-grow: 0;
    flex-shrink: 0;
}
.appProfile-avatar {
    width: 96px;
    height: 96px;
}
.appUser-avatar {
    width: 42px;
    height: 42px;
}
.appLists-avatarImage {
    width: 30px;
    height: 30px;
    margin-right: 0;
}
```
