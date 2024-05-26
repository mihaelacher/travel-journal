@if ($errors->any())
    <div id="sessionErrorList">{{implode(',', $errors->all())}}</div>
@endif
