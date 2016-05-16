@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')
        <!-- page start-->
<div class="row">
    <div class="col-md-3">
        <section class="panel">
            <div class="panel-body">
                <input type="text" placeholder="Keyword Search" class="form-control">
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
                Category
            </header>
            <div class="panel-body">
                <ul class="nav prod-cat">
                    <li>
                        <a href="#" class="active"><i class=" icon-angle-right"></i> Dress</a>
                        <ul class="nav">
                            <li class="active"><a href="#">- Shirt</a></li>
                            <li><a href="#">- Pant</a></li>
                            <li><a href="#">- Shoes</a></li>
                        </ul>
                    </li>
                    <li><a href="#"><i class=" icon-angle-right"></i> Bags & Purses</a></li>
                    <li><a href="#"><i class=" icon-angle-right"></i> Beauty</a></li>
                    <li><a href="#"><i class=" icon-angle-right"></i> Coat & Jacket</a></li>
                    <li><a href="#"><i class=" icon-angle-right"></i> Jeans</a></li>
                    <li><a href="#"><i class=" icon-angle-right"></i> Jewellery</a></li>
                    <li><a href="#"><i class=" icon-angle-right"></i> Electronics</a></li>
                    <li><a href="#"><i class=" icon-angle-right"></i> Sports</a></li>
                    <li><a href="#"><i class=" icon-angle-right"></i> Technology</a></li>
                    <li><a href="#"><i class=" icon-angle-right"></i> Watches</a></li>
                    <li><a href="#"><i class=" icon-angle-right"></i> Accessories</a></li>
                </ul>
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
                Price Range
            </header>
            <div class="panel-body sliders">
                <div id="slider-range" class="slider"></div>
                <div class="slider-info">
                    <span id="slider-range-amount"></span>
                </div>
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
                Best Seller
            </header>
            <div class="panel-body">
                <div class="best-seller">
                    <article class="media">
                        <a class="pull-left thumb p-thumb">
                            <img src="etsb/img/product1.jpg">
                        </a>
                        <div class="media-body">
                            <a href="#" class=" p-head">Item One Tittle</a>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </article>
                    <article class="media">
                        <a class="pull-left thumb p-thumb">
                            <img src="etsb/img/product2.png">
                        </a>
                        <div class="media-body">
                            <a href="#" class=" p-head">Item Two Tittle</a>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </article>
                    <article class="media">
                        <a class="pull-left thumb p-thumb">
                            <img src="etsb/img/product3.png">
                        </a>
                        <div class="media-body">
                            <a href="#" class=" p-head">Item Three Tittle</a>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                        </div>
                    </article>
                </div>
            </div>
        </section>
    </div>
    <div class="col-md-9">

        <section class="panel">
            <div class="panel-body">
                <div class="col-md-6">
                    <div class="pro-img-details">
                        <img src="etsb/img/product-list/pro-thumb-big.jpg" alt=""/>
                    </div>
                    <div class="pro-img-list">
                        <a href="#">
                            <img src="etsb/img/product-list/pro-thumb-1.jpg" alt="">
                        </a>
                        <a href="#">
                            <img src="etsb/img/product-list/pro-thumb-2.jpg" alt="">
                        </a>
                        <a href="#">
                            <img src="etsb/img/product-list/pro-thumb-3.jpg" alt="">
                        </a>
                        <a href="#">
                            <img src="etsb/img/product-list/pro-thumb-1.jpg" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4 class="pro-d-title">
                        <a href="#" class="">
                            Leopard Shirt Dress
                        </a>
                    </h4>
                    <p>
                        Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor, The best product descriptions address your ideal buyer directly and personally. The best product descriptions address your ideal buyer directly and personally.
                    </p>
                    <div class="product_meta">
                        <span class="posted_in"> <strong>Categories:</strong> <a rel="tag" href="#">Jackets</a>, <a rel="tag" href="#">Men</a>, <a rel="tag" href="#">Shirts</a>, <a rel="tag" href="#">T-shirt</a>.</span>
                        <span class="tagged_as"><strong>Tags:</strong> <a rel="tag" href="#">mens</a>, <a rel="tag" href="#">womens</a>.</span>
                    </div>
                    <div class="m-bot15"> <strong>Price : </strong> <span class="amount-old">$544</span>  <span class="pro-price"> $300.00</span></div>
                    <div class="form-group">
                        <label>Quantity</label>
                        <input type="quantiy" placeholder="1" class="form-control quantity">
                    </div>
                    <p>
                        <button class="btn btn-round btn-danger" type="button"><i class="icon-shopping-cart"></i> Add to Cart</button>
                    </p>
                </div>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading tab-bg-dark-navy-blue">
                <ul class="nav nav-tabs ">
                    <li class="active">
                        <a data-toggle="tab" href="#description">
                            Description
                        </a>
                    </li>
                    <li>
                        <a data-toggle="tab" href="#reviews">
                            Reviews
                        </a>
                    </li>

                </ul>
            </header>
            <div class="panel-body">
                <div class="tab-content tasi-tab">
                    <div id="description" class="tab-pane active">
                        <h4 class="pro-d-head">Product Description</h4>
                        <p> Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor, The best product descriptions address your ideal buyer directly and personally. The best product descriptions address your ideal buyer directly and personally. </p>
                        <p> Praesent ac condimentum felis. Nulla at nisl orci, at dignissim dolor, The best product descriptions address your ideal buyer directly and personally. The best product descriptions address your ideal buyer directly and personally. The best product descriptions address your ideal buyer directly and personally. The best product descriptions address your ideal buyer directly and personally. </p>
                    </div>
                    <div id="reviews" class="tab-pane">
                        <article class="media">
                            <a class="pull-left thumb p-thumb">
                                <img src="etsb/img/avatar-mini.jpg">
                            </a>
                            <div class="media-body">
                                <a href="#" class="cmt-head">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</a>
                                <p> <i class="icon-time"></i> 1 hours ago</p>
                            </div>
                        </article>
                        <article class="media">
                            <a class="pull-left thumb p-thumb">
                                <img src="etsb/img/avatar-mini2.jpg">
                            </a>
                            <div class="media-body">
                                <a href="#" class="cmt-head">Nulla vel metus scelerisque ante sollicitudin commodo</a>
                                <p> <i class="icon-time"></i> 23 mins ago</p>
                            </div>
                        </article>
                        <article class="media">
                            <a class="pull-left thumb p-thumb">
                                <img src="etsb/img/avatar-mini3.jpg">
                            </a>
                            <div class="media-body">
                                <a href="#" class="cmt-head">Donec lacinia congue felis in faucibus. </a>
                                <p> <i class="icon-time"></i> 15 mins ago</p>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <div class="row product-list">
            <div class="col-md-4">
                <section class="panel">
                    <div class="pro-img-box">
                        <img src="etsb/img/product-list/pro-1.jpg" alt=""/>
                        <a href="#" class="adtocart">
                            <i class="icon-shopping-cart"></i>
                        </a>
                    </div>

                    <div class="panel-body text-center">
                        <h4>
                            <a href="#" class="pro-title">
                                Leopard Shirt Dress
                            </a>
                        </h4>
                        <p class="price">$300.00</p>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel">
                    <div class="pro-img-box">
                        <img src="etsb/img/product-list/pro1.jpg" alt=""/>
                        <a href="#" class="adtocart">
                            <i class="icon-shopping-cart"></i>
                        </a>
                    </div>

                    <div class="panel-body text-center">
                        <h4>
                            <a href="#" class="pro-title">
                                Leopard Shirt Dress
                            </a>
                        </h4>
                        <p class="price">$300.00</p>
                    </div>
                </section>
            </div>
            <div class="col-md-4">
                <section class="panel">
                    <div class="pro-img-box">
                        <img src="etsb/img/product-list/pro2.jpg" alt=""/>
                        <a href="#" class="adtocart">
                            <i class="icon-shopping-cart"></i>
                        </a>
                    </div>

                    <div class="panel-body text-center">
                        <h4>
                            <a href="#" class="pro-title">
                                Leopard Shirt Dress
                            </a>
                        </h4>
                        <p class="price">$300.00</p>
                    </div>
                </section>
            </div>

        </div>
    </div>
</div>
<!-- page end-->
@stop
