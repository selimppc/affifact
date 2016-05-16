@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')
        <!-- page start-->
<div class="row">
    <aside class="profile-nav col-lg-3">
        <section class="panel">
            <div class="user-heading round">
                <a href="#">
                    <img src="etsb/img/profile-avatar.jpg" alt="">
                </a>
                <h1>Jonathan Smith</h1>
                <p>jsmith@flatlab.com</p>
            </div>

            <ul class="nav nav-pills nav-stacked">
                <li><a href="profile.html"> <i class="icon-user"></i> Profile</a></li>
                <li><a href="profile-activity.html"> <i class="icon-calendar"></i> Recent Activity <span class="label label-danger pull-right r-activity">9</span></a></li>
                <li  class="active"><a href="profile-edit.html"> <i class="icon-edit"></i> Edit profile</a></li>
            </ul>

        </section>
    </aside>
    <aside class="profile-info col-lg-9">
        <section class="panel">
            <div class="bio-graph-heading">
                Aliquam ac magna metus. Nam sed arcu non tellus fringilla fringilla ut vel ispum. Aliquam ac magna metus.
            </div>
            <div class="panel-body bio-graph-info">
                <h1> Profile Info</h1>
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">About Me</label>
                        <div class="col-lg-10">
                            <textarea name="" id="" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">First Name</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="f-name" placeholder=" ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Last Name</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="l-name" placeholder=" ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Country</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="c-name" placeholder=" ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Birthday</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="b-day" placeholder=" ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Occupation</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="occupation" placeholder=" ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Email</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="email" placeholder=" ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Mobile</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="mobile" placeholder=" ">
                        </div>
                    </div>
                    <div class="form-group">
                        <label  class="col-lg-2 control-label">Website URL</label>
                        <div class="col-lg-6">
                            <input type="text" class="form-control" id="url" placeholder="http://www.demowebsite.com ">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-offset-2 col-lg-10">
                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-default">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
        <section>
            <div class="panel panel-primary">
                <div class="panel-heading"> Sets New Password & Avatar</div>
                <div class="panel-body">
                    <form class="form-horizontal" role="form">
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Current Password</label>
                            <div class="col-lg-6">
                                <input type="password" class="form-control" id="c-pwd" placeholder=" ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">New Password</label>
                            <div class="col-lg-6">
                                <input type="password" class="form-control" id="n-pwd" placeholder=" ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Re-type New Password</label>
                            <div class="col-lg-6">
                                <input type="password" class="form-control" id="rt-pwd" placeholder=" ">
                            </div>
                        </div>

                        <div class="form-group">
                            <label  class="col-lg-2 control-label">Change Avatar</label>
                            <div class="col-lg-6">
                                <input type="file" class="file-pos" id="exampleInputFile">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-lg-offset-2 col-lg-10">
                                <button type="submit" class="btn btn-info">Save</button>
                                <button type="button" class="btn btn-default">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </aside>
</div>

<!-- page end-->
@stop