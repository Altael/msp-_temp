<template>
    <div class="appLogin">
        <div class="appLogin-title">{{ __('Login') }}</div>
        <div class="appLogin-buttons">
            <a :href="'/auth/yandex' + (typeof $route.query.sadvipra !== 'undefined' ? '?sadvipra' : '')" class="appLogin-buttonsButton" data-social="Yandex">
                <div class="appLogin-buttonsButtonIcon">
                    Y
                </div>
                <div class="appLogin-buttonsButtonName">Yandex</div>
            </a>
            <a :href="'/auth/mailru' + (typeof $route.query.sadvipra !== 'undefined' ? '?sadvipra' : '')" class="appLogin-buttonsButton" data-social="Mailru">
                <div class="appLogin-buttonsButtonIcon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12.042 23.648c-7.813 0-12.042-4.876-12.042-11.171 0-6.727 4.762-12.125 13.276-12.125 6.214 0 10.724 4.038 10.724 9.601 0 8.712-10.33 11.012-9.812 6.042-.71 1.108-1.854 2.354-4.053 2.354-2.516 0-4.08-1.842-4.08-4.807 0-4.444 2.921-8.199 6.379-8.199 1.659 0 2.8.876 3.277 2.221l.464-1.632h2.338c-.244.832-2.321 8.527-2.321 8.527-.648 2.666 1.35 2.713 3.122 1.297 3.329-2.58 3.501-9.327-.998-12.141-4.821-2.891-15.795-1.102-15.795 8.693 0 5.611 3.95 9.381 9.829 9.381 3.436 0 5.542-.93 7.295-1.948l1.177 1.698c-1.711.966-4.461 2.209-8.78 2.209zm-2.344-14.305c-.715 1.34-1.177 3.076-1.177 4.424 0 3.61 3.522 3.633 5.252.239.712-1.394 1.171-3.171 1.171-4.529 0-2.917-3.495-3.434-5.246-.134z"/></svg>
                </div>
                <div class="appLogin-buttonsButtonName">Mail.ru</div>
            </a>
            <a :href="'/auth/vkontakte' + (typeof $route.query.sadvipra !== 'undefined' ? '?sadvipra' : '')" class="appLogin-buttonsButton" data-social="Vkontakte">
                <div class="appLogin-buttonsButtonIcon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path class="st0" d="M13.162 18.994c.609 0 .858-.406.851-.915-.031-1.917.714-2.949 2.059-1.604 1.488 1.488 1.796 2.519 3.603 2.519h3.2c.808 0 1.126-.26 1.126-.668 0-.863-1.421-2.386-2.625-3.504-1.686-1.565-1.765-1.602-.313-3.486 1.801-2.339 4.157-5.336 2.073-5.336h-3.981c-.772 0-.828.435-1.103 1.083-.995 2.347-2.886 5.387-3.604 4.922-.751-.485-.407-2.406-.35-5.261.015-.754.011-1.271-1.141-1.539-.629-.145-1.241-.205-1.809-.205-2.273 0-3.841.953-2.95 1.119 1.571.293 1.42 3.692 1.054 5.16-.638 2.556-3.036-2.024-4.035-4.305-.241-.548-.315-.974-1.175-.974h-3.255c-.492 0-.787.16-.787.516 0 .602 2.96 6.72 5.786 9.77 2.756 2.975 5.48 2.708 7.376 2.708z"/></svg>
                </div>
                <div class="appLogin-buttonsButtonName">Vkontakte</div>
            </a>
            <a :href="'/auth/facebook' + (typeof $route.query.sadvipra !== 'undefined' ? '?sadvipra' : '')" class="appLogin-buttonsButton" data-social="Facebook">
                <div class="appLogin-buttonsButtonIcon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"/></svg>
                </div>
                <div class="appLogin-buttonsButtonName">Facebook</div>
            </a>
            <a :href="'/auth/google' + (typeof $route.query.sadvipra !== 'undefined' ? '?sadvipra' : '')" class="appLogin-buttonsButton" data-social="Google">
                <div class="appLogin-buttonsButtonIcon">
                    <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1000 1000" enable-background="new 0 0 1000 1000" xml:space="preserve"><metadata> Svg Vector Icons : http://www.onlinewebfonts.com/icon </metadata>
                        <g><g><path d="M61.8,259.3c0,81.5,27.2,140.3,80.9,174.9c44,28.4,94.9,32.6,121.5,32.6c6.4,0,11.6-0.3,15.2-0.5c0,0-8.4,54.8,32.2,108.9h-1.9C239.4,575.2,10,589.9,10,778.5c0,191.8,210.7,201.6,253,201.6c3.3,0,5.3-0.1,5.3-0.1c0.4,0,3.4,0.1,8.6,0.1c27.1,0,97.2-3.4,162.3-35.1c84.5-40.9,127.3-112.3,127.3-212c0-96.2-65.3-153.5-112.9-195.4c-29.1-25.6-54.2-47.6-54.2-69.1c0-21.8,18.4-38.2,41.6-59C478.5,376,514,328.1,514,237.7c0-79.5-10.3-132.9-73.9-166.8c6.6-3.4,30.1-5.8,41.6-7.5c34.4-4.7,84.8-10,84.8-38.1v-5.4H315.6C313.1,20,61.8,29.2,61.8,259.3L61.8,259.3z M466.9,751.1c4.8,76.7-60.8,133.3-159.4,140.4c-100.1,7.4-182.5-37.7-187.3-114.4c-2.3-36.9,13.9-72.9,45.6-101.7c32.1-29.1,76.3-47.1,124.3-50.6c5.7-0.3,11.3-0.7,16.9-0.7C399.6,624.3,462.4,678.7,466.9,751.1z M401.4,206.8c24.6,86.6-12.5,177.1-71.8,193.9c-6.8,1.9-13.8,2.8-21,2.8c-54.2,0-108-54.9-127.9-130.6c-11.1-42.3-10.2-79.6,2.6-115.2c12.5-35.2,35.1-58.8,63.5-66.8c6.8-1.9,13.9-2.9,21-2.9C333.2,87.9,375.3,115.1,401.4,206.8z M826.3,390.9V227.2H717.2v163.7H553.5V500h163.7v163.7h109.1V500H990V390.9H826.3L826.3,390.9z"/></g></g>
                        </svg>
                </div>

                <div class="appLogin-buttonsButtonName">Google+</div>
            </a>
        </div>
    </div>
</template>
<script>

</script>
