@extends('layouts.admin')

@section('title', trans('general.title.new', ['type' => trans_choice('my-blog::general.posts', 1)]))

@section('content')
    <div class="card">
        {!! Form::open([
            'route' => 'my-blog.posts.store',
            'id' => 'post',
            '@submit.prevent' => 'onSubmit',
            '@keydown' => 'form.errors.clear($event.target.name)',
            'files' => true,
            'role' => 'form',
            'class' => 'form-loading-button',
            'novalidate' => true
        ]) !!}

            <div class="card-body">
                <div class="row">
                    {{ Form::textGroup('name', trans('general.name'), 'fa fa-font') }}

                    {{ Form::selectRemoteAddNewGroup('category_id', trans_choice('general.categories', 1), 'fa fa-folder', $categories, null, ['path' => route('modals.categories.create') . '?type=post', 'remote_action' => route('categories.index'). '?search=type:post']) }}

                    {{ Form::textareaGroup('description', trans('general.description')) }}

                    {{ Form::radioGroup('enabled', trans('general.enabled'), true) }}
                </div>
            </div>

            <div class="card-footer">
                <div class="row save-buttons">
                    {{ Form::saveButtons('my-blog.posts.index') }}
                </div>
            </div>
        {!! Form::close() !!}
    </div>
@endsection

@push('scripts_start')
    <script src="{{ asset('modules/MyBlog/Resources/assets/js/my-blog.min.js?v=' . module_version('my-blog')) }}"></script>
@endpush
