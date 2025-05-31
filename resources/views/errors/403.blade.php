@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Forbidden'))\
@section('description', __('Oops! The page you are looking for seems to have wandered off into the digital void. Let\'s get you back home.'))

