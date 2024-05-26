<div class="row">
    <div class="input-field col s12">
        <input
            placeholder="{{'Enter ' . $text ?? \App\Services\Utils\StrUtil::formatInputText($name)}}"
            id="{{$name}}"
            type="{{$type}}"
            class="validate"
            name="{{$name}}"
            value="{{$value}}"
        >
        <label for="{{$name}}">{{\App\Services\Utils\StrUtil::formatInputText($name, true)}}</label>
    </div>
</div>
