@extends('layout.master')
@section('sidebar')
    @parent
    @include('layout.sidebar')
@stop

@section('content')
    !-- page start-->
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
                                <img src="img/product1.jpg">
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
                    <div class="pro-sort">
                        <label class="pro-lab">Sort By</label>
                        <select class="styled" >
                            <option>Default Sorting</option>
                            <option>Popularity</option>
                            <option>Average Rating</option>
                            <option>Newness</option>
                            <option>Price Low to High</option>
                            <option>Price High to Low</option>
                        </select>
                    </div>
                    <div class="pro-sort">
                        <label class="pro-lab">Show</label>
                        <select class="styled" >
                            <option>Result Per Page</option>
                            <option>2 Per Page</option>
                            <option>4 Per Page</option>
                            <option>6 Per Page</option>
                            <option>8 Per Page</option>
                            <option>10 Per Page</option>
                        </select>
                    </div>

                    <div class="pull-right">
                        <ul class="pagination pagination-sm pro-page-list">

                            <li><a href="#">1</a></li>
                            <li><a href="#">2</a></li>
                            <li><a href="#">3</a></li>
                            <li><a href="#">»</a></li>
                        </ul>
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
                <div class="col-md-4">
                    <section class="panel">
                        <div class="pro-img-box">
                            <img src="etsb/img/product-list/pro3.jpg" alt=""/>
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
                            <img src="etsb/img/product-list/pro3.jpg" alt=""/>
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
            </div>
        </div>
    </div>
    <!-- page end-->
@stop
