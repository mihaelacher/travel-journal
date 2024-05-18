<div class="row">
    <div class="input-field col s12">
        <input id="{{$name}}" type="text" class="datepicker" name="{{$name}}" value="{{$value}}"/>
        <label for="{{$name}}">{{!empty($value) ? '' : $labelText}}</label>
    </div>
</div>
