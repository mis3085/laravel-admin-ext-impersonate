<li class="pull-right">
    <a href="javascript:void" class="{{ $class }} fa fa-undo" > {{ $label }}</a>
    <form action="{{ route('admin.handle-action') }}" method="POST" id="{{ $name }}">
        <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
        <input type="hidden" name="_action" value="{{ $name }}"/>
    </form>
</li>
