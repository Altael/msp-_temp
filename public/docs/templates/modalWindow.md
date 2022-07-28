# Template для PHPStorm

## Файлы

* [css](../../css/modalWindow.css)

## Код темплейта

```html
<div class="dhrtModalWindow">
    <div class="dhrtModalWindow-back"></div>
    <div class="dhrtModalWindow-content">
        <div class="dhrtModalWindow-contentTools"><div class="dhrtModalWindow-contentClose">&times;</div></div>
        <div class="dhrtModalWindow-head">$windowName$</div>
        <div class="dhrtModalWindow-body">
            <div class="dhrtScroll-wrapperOuter">
                <div class="dhrtScroll-wrapperInner">
                    <div class="dhrtModalWindow-bodyContent">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="dhrtModalWindow-footer">
            <div class="dhrtModalWindow-footerButtons">
                <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerClose">{{ __('Close') }}</div>
                <div class="dhrtModalWindow-footerButton dhrtModalWindow-footerSave">{{ __('Save') }}</div>
            </div>
        </div>
    </div>
</div>
```
