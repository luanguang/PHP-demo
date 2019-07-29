### 安卓与ios光标相同写法
```javascript
# 安卓和pc显示正常
$form.find('textarea').val(text).trigger('focus');

# 安卓和ios都显示正常写法
$form.find('textarea').focus().val(text);
```

### 不允许空格提交
```javascript
# 和php的trim函数类似的功能
$('#post-name-field').blur(function () {
    $(this).val($(this).val().trim());
});
```
