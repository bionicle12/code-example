@extends('layout.app')

@section('title', $page->getContent()->getMeta()->getTitle())
@section('description', $page->getContent()->getMeta()->getDescription())
@section('image', $page->getContent()->getMeta()->getImageLink())

@section('content')
    @if ($page->getContent())
        {!! $page->getContent()->getContent() !!}
    @else
        {{ __('Sorry, we didn\'t make this page yet') }}
    @endif
@endsection
