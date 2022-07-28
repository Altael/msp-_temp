# Template для PHPStorm


## Код темплейта

```html
<div class="dhrtDropdown menuWidthAuto dhrtDropdown-menuAlignmentLeft withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown" data-position="down" data-indent-down="16" data-indent-up="16">
    <div class="dhrtDropdown-back"></div> 
    <!--noindex--><a id="$btn$Link" href="#$btn$" data-target="$btn$" class="dhrtDropdown-link" rel="nofollow" data-toggle="dhrtDropdown" role="button" aria-haspopup="true" aria-expanded="false">
         <span class="dhrtDropdown-icon"></span>$item_selected$
    </a><!--/noindex-->
    <div class="dhrtDropdown-menu" id="$btn$" aria-labelledby="$btn$Link">
        <!--noindex--><a href="#" rel="nofollow" class="dhrtDropdown-item noClose">
            $item1$
        </a><!--/noindex-->
        <div class="dhrtDropdown-submenu openOnHover dhrtDropdown-item toRight withArrow arrowBold withLink">
            <!--noindex--><a href="#" rel="nofollow" data-target="#" data-toggle="dhrtDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                $item2$
            </a><!--/noindex-->
            <div class="dhrtDropdown-menu">
                <div class="dhrtDropdown-submenu openOnHover dhrtDropdown-item toRight withArrow arrowBold withLink">
                    <!--noindex--><a href="#" rel="nofollow" data-target="#" data-toggle="dhrtDropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="pyberIcon pyberIcon-radio-button"></span>Category 1</a><!--/noindex-->
                    <div class="dhrtDropdown-menu">
                        <div class="dhrtDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="pyberIcon pyberIcon-file-fill"></span>Some contract on form 1</a><!--/noindex-->
                        </div>
                        <div class="dhrtDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="icon"></span>Some contract on form 2</a><!--/noindex-->
                        </div>
                        <div class="dhrtDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="icon"></span>Some contract on form 3</a><!--/noindex-->
                        </div>
                    </div>
                </div>
                <div class="dhrtDropdown-submenu openOnHover dhrtDropdown-item toRight withArrow arrowBold withLink">
                    <!--noindex--><a href="#" rel="nofollow" data-target="#" data-toggle="dhrtDropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="pyberIcon pyberIcon-radio-button"></span>Category 2</a><!--/noindex-->
                    <div class="dhrtDropdown-menu">
                        <div class="dhrtDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="icon"></span>Some contract on form 1</a><!--/noindex-->
                        </div>
                        <div class="dhrtDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="icon"></span>Some contract on form 2</a><!--/noindex-->
                        </div>
                        <div class="crmDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="icon"></span>Some contract on form 3</a><!--/noindex-->
                        </div>
                    </div>
                </div>
                <div class="dhrtDropdown-submenu openOnHover dhrtDropdown-item toRight withArrow arrowBold withLink">
                    <!--noindex--><a href="#" rel="nofollow" data-target="#" data-toggle="dhrtDropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="pyberIcon pyberIcon-radio-button"></span>Category 3</a><!--/noindex-->
                    <div class="dhrtDropdown-menu">
                        <div class="dhrtDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="icon"></span>Some contract on form 1</a><!--/noindex-->
                        </div>
                        <div class="dhrtDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="icon"></span>Some contract on form 2</a><!--/noindex-->
                        </div>
                        <div class="dhrtDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="icon"></span>Some contract on form 3</a><!--/noindex-->
                        </div>
                    </div>
                </div>
                <div class="dhrtDropdown-submenu openOnHover dhrtDropdown-item toRight withArrow arrowBold withLink">
                    <!--noindex--><a href="#" rel="nofollow" data-target="#" data-toggle="crmDropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="pyberIcon pyberIcon-radio-button"></span>Category 4</a><!--/noindex-->
                    <div class="dhrtDropdown-menu">
                        <div class="dhrtDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="icon"></span>Some contract on form 1</a><!--/noindex-->
                        </div>
                        <div class="dhrtDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="icon"></span>Some contract on form 2</a><!--/noindex-->
                        </div>
                        <div class="dhrtDropdown-item withLink">
                            <!--noindex--><a href="#" rel="nofollow"><span class="icon"></span>Some contract on form 3</a><!--/noindex-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>
```
vue-js
```
<object-dropdown v-model="filters.unit"
                 class="withArrow arrowBold arrowSmall dhrtDropdown-menuPositionDown menuWidthAuto"
                 :options='unitsList'
                 label="name" 
                 :placeholder="'Choose unit'"
/>
```


## Файлы

* [css](../../public/css/dropdown.css)
* [js](../../public/js/dropdown.js)

## Пример использования

```
<div class="dhrtDropdown menuWidthAuto dhrtDropdown-menuPositionDown dhrtDropdown-menuAlignmentLeft" data-position="down" data-indent-down="16" data-indent-up="16">
    <div class="dhrtDropdown-back"></div>
    <!--noindex--><a href="#appRequestsTools" data-target="appRequestsTools" class="dhrtDropdown-link" rel="nofollow" data-toggle="dhrtDropdown" role="button" aria-haspopup="true" aria-expanded="false">
        <span class="appIcons msppIcons-more-vertical"></span>
    </a><!--/noindex-->
    <div class="dhrtDropdown-menu" aria-labelledby="appRequestsToolsLink">
        <!--noindex--><a href="#" rel="nofollow" class="dhrtDropdown-item" v-if="request.status" @click.prevent="cancelLesson(request)">
            Отменить
        </a><!--/noindex-->
        <!--noindex--><a class="dhrtDropdown-item" rel="nofollow" href="#" @click.prevent="deleteLesson(request)">
            Удалить
        </a><!--/noindex-->
        <div class="dhrtDropdown-submenu openOnHover  dhrtDropdown-item toLeft withArrow arrowBold withLink" v-if="acaryas.length">
            <!--noindex--><a href="#" rel="nofollow" data-target="#" data-toggle="dhrtDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Делигировать
            </a><!--/noindex-->
            <div class="dhrtDropdown-menu">
                <div class="dhrtDropdown-item withoutLink link" v-for="acarya of acaryas" @click.prevent="delegate(request, acarya)">
                    {{ acarya.displayName }}
                </div>
            </div>
        </div>
    </div>
</div>
```
