<div class="">
    @if ($type == 'text' || $type == 'date' || $type == 'number')
        <input type="{{ $type }}" name="{{ $name }}" value="{{isset($value)?$value:''}}" {{isset($attr)?$attr:''}} class="form-control"  placeholder="{{ $name }}" />
    @endif

    @if ($type == 'file')
        <div class="input_file_body" data-toggle="modal" data-target="#fileManagerModal" >
            <div class="overlay"></div>
            @if(isset($value))

                @if (isset($value_names) && is_array($value_names) && count($value_names) > 0)
                    @for ($i = 0; $i < count($value_names); $i++)
                        <img src="/{{ $value_names[$i] }}" style="height: 50px;margin: 5px;" alt="preview">
                    @endfor
                @else
                    <img src="/{{ $value }}" style="height: 50px;margin: 5px;" alt="preview">
                @endif
            @else
                <img src="" style="height: 50px;margin: 5px;" alt="preview">
            @endif
            <input type="text" name="{{ $name }}" value="{{isset($value)?$value:''}}" class="form-control" {{isset($attr)?$attr:''}}  placeholder="Choose File {{ $name }}" />
        </div>
    @endif

    <span class="text-danger {{ $name }}"></span>
</div>


