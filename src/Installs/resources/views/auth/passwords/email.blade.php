@extends('default::core.layouts.auth')

@section('htmlheader_title')
    Password recovery
@endsection

@section('content')
    <div id="content" class="container">

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-7 col-lg-8 hidden-xs hidden-sm">
                <h1 class="txt-color-red login-header-big">SmartAdmin</h1>
                <div class="hero">

                    <div class="pull-left login-desc-box-l">
                        <h4 class="paragraph-header">It's Okay to be Smart. Experience the simplicity of SmartAdmin, everywhere you go!</h4>
                        <div class="login-app-icons">
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm">Frontend Template</a>
                            <a href="javascript:void(0);" class="btn btn-danger btn-sm">Find out more</a>
                        </div>
                    </div>

                    <img src="{{ Theme::asset('img/demo/iphoneview.png') }}" class="pull-right display-image" alt="" style="width:210px">

                </div>

                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <h5 class="about-heading">About SmartAdmin - Are you up to date?</h5>
                        <p>
                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.
                        </p>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                        <h5 class="about-heading">Not just your average template!</h5>
                        <p>
                            Et harum quidem rerum facilis est et expedita distinctio. Nam libero tempore, cum soluta nobis est eligendi voluptatem accusantium!
                        </p>
                    </div>
                </div>

            </div>
            <div class="col-xs-12 col-sm-12 col-md-5 col-lg-4">

                @if (count($errors) > 0)
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger fade in">
                            <button class="close" data-dismiss="alert">×</button>
                            <i class="fa-fw fa fa-times"></i>
                            <strong>Error!</strong> {{ $error }}
                        </div>
                    @endforeach
                @endif

                <div class="well no-padding">
                    <form action="{{ url('/password/email') }}" method="post" id="login-form" class="smart-form client-form">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <header>
                            Forgot Password
                        </header>

                        <fieldset>

                            <section>
                                <label class="label">Enter your email address</label>
                                <label class="input"> <i class="icon-append fa fa-envelope"></i>
                                    <input type="email" name="email" value="{{ old('email') }}"/>
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-envelope txt-color-teal"></i> Please enter email address for password reset</b></label>
                            </section>
                            <section>
                                    <span class="timeline-seperator text-center text-primary"> <span class="font-sm">OR</span>
                            </section>
                            <section>
                                <label class="label">Your Username</label>
                                <label class="input"> <i class="icon-append fa fa-user"></i>
                                    <input type="text" name="username">
                                    <b class="tooltip tooltip-top-right"><i class="fa fa-user txt-color-teal"></i> Enter your username</b> </label>
                                <div class="note">
                                    <a href="{{ url('/login') }}">Login!</a>
                                </div>
                            </section>

                        </fieldset>
                        <footer>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-refresh"></i> Reset Password
                            </button>
                        </footer>
                    </form>

                </div>

            </div>
        </div>
    </div>
@endsection