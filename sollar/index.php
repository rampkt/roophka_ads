<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Homepage - Start Bootstrap Template</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/shop-homepage.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation" style="margin-bottom:0px;background-color:#fff;border:1px solid #fff;">
        <div class="container" style="height:100px;">
            <!-- Brand and toggle get grouped for better mobile display -->
           <div class="row">
             <div class="col-sm-3 col-lg-3 col-md-3">           
		         <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
				<img src="images/logo.png">
				</a>
				</div>
            </div>
			
			<div class="col-sm-6 col-lg-6 col-md-6"> 
			<input type="text" name="sub" id="sub" class="input-lg-texttop" placeholder="Search ...">
			</div>
			
			
			<div class="collapse navbar-collapse pull-right" id="bs-example-navbar-collapse-1" style="padding-top:30px;">
                <ul class="nav navbar-nav">
				 
				    <li class="coldisplay">
                        <a href="#">Home</a>
                    </li>
                    <li class="coldisplay">
                        <a href="#">Secure Vision</a>
                    </li>
                    <li class="coldisplay">
                        <a href="#">Sunset Lights</a>
                    </li>
					<li class="coldisplay">
                        <a href="#">Solar Products</a>
                    </li>
					
                    <li>
                        <a href="#"><img src="images/cart.png">&nbsp;Cart</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);"  data-toggle="modal" data-target="#myModal" id="menureg"><img src="images/user.png">&nbsp;Register</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-toggle="modal" data-target="#myModal" id="menulogin">Login</a>
                    </li>
                </ul>
            </div>
          </div>


		  
          </div>  
        </div>
        <!-- /.container -->
    </nav>
<div class="topheader">
   <div class="container">
	<div class="col-md-12 ">
        <div class="row" style="text-align:center;padding-top:10px;">
		           
				   <div class="col-md-2" >&nbsp;</div>
		                  
                    <div class="col-md-2 coltophide" >
                        <a href="#">
						<div><img src="images/whome.png"></div>
						<div>HOME</div>
						</a>
                    </div>
                    <div class="col-md-2 coltophide">
					    <a href="#">
						<div><img src="images/weye.png"></div>
						<div>SECURE VISION</div>
						</a>
                    </div>
                    <div class="col-md-2 coltophide">
                         <a href="#">
						<div><img src="images/wlight.png"></div>
						<div>SENSET LIGHTS</div>
						</a>
                    </div>
					<div class="col-md-2 coltophide">
                        <a href="#">
						<div><img src="images/wprds.png"></div>
						<div>SOLAR PRODUCTS</div>
						</a>
                    </div>
					<div class="col-md-2" >&nbsp;</div>
				
	    </div>
		</div>
	</div>
</div>	
    <!-- Page Content -->
    <div class="container">

	    <div class="col-md-12 slidertop">
        <div class="row">
            <div class="col-md-6">

                <div class="row carousel-holder">

                    <div class="col-md-12">
                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style="margin-left:-15px;">
                            <ol class="carousel-indicators">
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="item active">
                                    <img class="slide-image" src="images/slide/img1.jpg" alt="" style="height:370px;">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="images/slide/img2.jpg" alt="" style="height:370px;">
                                </div>
                                <div class="item">
                                    <img class="slide-image" src="images/slide/img3.jpg" alt="" style="height:370px;">
                                </div>
                            </div>
                            <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    </div>

                </div>
               
			  
			   </div>
			    <div class="col-md-6 txtcntr">
                <p class="lead">ADVANCED SEARCH</p>
                <div class="list-group">
                    <input type="text" name="category" id="category" class="input-lg-textgray" placeholder="By Category">
                </div>
				<div class="list-group">
                    <input type="text" name="products" id="products" class="input-lg-textgray" placeholder="By Products">
                </div>
				<div class="list-group">
                    <input type="text" name="brand" id="brand" class="input-lg-textgray" placeholder="By Brands">
                </div>
				<div class="list-group">
                    <input type="text" name="name" id="name" class="input-lg-textgray" placeholder="By Names">
                </div>
				<div class="list-group">
                    <input type="submit" name="search" id="search" value="Search" class="btn btn-small btn-success">
                </div>
            </div>
			 </div>  
			  </div> 
			    <div class="col-md-12">
                <div class="row">
				<div class="adsbox" >
                  <div class="ribbon" >
                   <a href="#"><strong>RECENT PRODUCTS</strong></a>
                     </div>
					 <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/sollarfan.jpg" alt="">
							
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

					 <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/light.jpg" alt="">
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/sollarfan.jpg" alt="">
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

                     <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/light.jpg" alt="">
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

					 <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/sollarfan.jpg" alt="">
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/light.jpg" alt="">
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

				</div>
				
			   </div>
			  </div>
			    
			    <div class="col-md-12">
                <div class="row">
				<div class="adsbox" >
                  <div class="ribbon" >
                   <a href="#"><strong>POPULAR PRODUCTS</strong></a>
                     </div>
					 <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/sollarfan.jpg" alt="">
							
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

					 <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/light.jpg" alt="">
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/sollarfan.jpg" alt="">
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

                     <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/light.jpg" alt="">
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

					 <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/sollarfan.jpg" alt="">
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
						<div class="cartcss"><img src="images/cart.png" alt=""></div>
                            <img src="images/light.jpg" alt="">
                            <div class="caption">
                                <h5><a href="#">Third Product</a>
                                </h5>
								<h5><strong class="pricecss">Rs.1000</strong></h5>
                            </div>
                            <div class="ratings">
							
                                <p>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star"></span>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                </p>
								<p class="pull-right">
								<a href="#" class="btn btn-small btn-success" style="padding:0px 5px;font-size:12px;">Buy Now</a>
								</p>
								<p>31 reviews</p>
								
								
                            </div>
                        </div>
                    </div>

				</div>
				
			   </div>
			  </div>
			  
			  <div class="col-md-12">
                <div class="row">
				 <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="images/banner1.png" alt="">
                        </div>
                    </div>
					<div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="images/banner2.png" alt="">
                        </div>
                    </div>
					<div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                            <img src="images/banner3.png" alt="">
                        </div>
                    </div>
					
			   </div>
			  </div>
			  
			   <div class="col-md-12">
                <div class="row">
				<div class="adsbox3" >
                  <div class="ribbon" >
                   <a href="#"><strong>OUR PARTNERS</strong></a>
                     </div>
					 <div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
                            <img src="images/partner/partner-1.png" alt="">
                        </div>
                    </div>
					<div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
                            <img src="images/partner/partner-2.png" alt="">
                        </div>
                    </div>
					<div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
                            <img src="images/partner/partner-3.png" alt="">
                        </div>
                    </div>
					<div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
                            <img src="images/partner/partner-1.png" alt="">
                        </div>
                    </div>
					<div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
                            <img src="images/partner/partner-2.png" alt="">
                        </div>
                    </div>
					<div class="col-sm-2 col-lg-2 col-md-2 rib-btm">
                        <div class="thumbnail">
                            <img src="images/partner/partner-3.png" alt="">
                        </div>
                    </div>
					 
					 
				</div>
				
			   </div>
			  </div>
			  
			  
			  </div>
    <!-- /.container -->
<div class="wrapper">
    <div class="container" >

        <!-- Footer -->
        <footer>
		<div class="row">
		 <div class="col-lg-12">
    	   
		   <div class="col-sm-3 col-lg-3 col-md-3">
        	<h3>CONTACT US</h3>
            <div class="clearfix">&nbsp;</div>
            <p><strong>Office:</strong> 5th Cross Street , Brindavan Nagar, Valasaravakkam, chennai 600087. </p>
            <!--<p><strong>Phone:</strong> 044 42840257</p>-->
            <p class="margin-clear"><strong>Email:</strong> info@roophka.com</p>
			
          </div>
		   <div class="col-sm-3 col-lg-3 col-md-3">
        	<h3>LINKS</h3>
            <div class="clearfix">&nbsp;</div>
            <ul class="footer-menu">
            	<li><a href="#">About Us</a></li>
				<li><a href="#">Contact Us</a></li>
                <li><a href="#">Terms &amp; Condition</a></li>
				<li><a href="#">Track Order</a></li>
				<li><a href="#">Location</a></li>
            </ul>
        </div>
        <div class="col-sm-3 col-lg-3 col-md-3">
        	<h3>POLICES</h3>
            <div class="clearfix">&nbsp;</div>
            <ul class="footer-menu">
            	<li><a href="#">Privacy Policy</a></li>
				<li><a href="#">Return &amp; Cancellation Policy</a></li>
                <li><a href="#">Refund Policy</a></li>
				<li><a href="#">Shipment Policy</a></li>
			</ul>
        </div>
        <div class="col-sm-3 col-lg-3 col-md-3">
        	<h3>INFORMATION</h3>
            <div class="clearfix">&nbsp;</div>
            <p align="justify"><strong>Earn while you browse: </strong>Earn money while you browse. No age will stop your earning. Just sit in home and earn money. As well you can get your need also in here. We just not advertise the product. It was also your daily need and best of that.</p>
        </div>
		  
		  
		</div>
		
		</div>
		
            
        </footer>

    </div>
    <!-- /.container -->
</div>
<div class="wrappercenter">
    <div class="container" >
	 <div class="row">
	  <div class="col-lg-12">
	     <div class="row">
		 <div class="col-sm-4 col-lg-4 col-md-4">
        	<span class='st_sharethis_large' displayText='ShareThis'></span>
            <span class='st_facebook_large' displayText='Facebook'></span>
            <span class='st_twitter_large' displayText='Tweet'></span>
            <span class='st_linkedin_large' displayText='LinkedIn'></span>
            <span class='st_pinterest_large' displayText='Pinterest'></span>
            <span class='st_email_large' displayText='Email'></span>
        </div>
		<div class="col-sm-4 col-lg-4 col-md-4">
		 <div class="row">
		   <div class="col-sm-2 col-lg-2 col-md-2" style="margin-top:-10px;">
		   <img src="images/newsletter.png"/>
		   </div>
		   
		   <div class="col-sm-10 col-lg-10 col-md-10">
        	<div class="newsbold"><strong>SIGN UP FOR OUR NEWSLETTER</strong></div>
            <div class="newssmall">Get the special offers and deals</div>
		   </div>
		 </div>
        </div>
		<div class="col-sm-4 col-lg-4 col-md-4">
        	<div>
			<input type="text" name="sub" id="sub" class="input-lg-text">
			<input type="submit" value="Subscribe" class="btn btn-small btn-success">
			</div>
            
        </div>
		 </div>
		 
	   </div>
	 </div>
	</div>
</div>
<div class="wrapperdark">
    <div class="container" >
	        <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; 2016 <span>Roophka</span>.All Rights Reserved.</p>
                </div>
            </div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">
        <div class="col-sm-12 col-lg-12 col-md-12">
		 <div class="row">
		 <div class="col-sm-6 col-lg-6 col-md-6 popleft">
		 <div class="imght"><img src="images/pop.png"></div>
		 <div>
		 <ul>
		 <li><img src="images/tick.png"> Non-polluting</li>
		 <li><img src="images/tick.png"> Renewable</li>
		 <li><img src="images/tick.png"> Low maintenance</li>
		 </ul>
		 </div>
		 </div>
		 
		 <div class="col-sm-6 col-lg-6 col-md-6 poprght">
		 <div>
		 <div class="tab"><a href="javascript:void(0);" id="tablogin">Login</a></div>
		 <div class="tab"><a href="javascript:void(0);" id="tabreg" class="active">Sign up</a></div>
		 </div>
		 
		 <div id="login" style="display:none">
		   
		   <div class="regtexttop">
		   <input type="email" name="email" id="email" placeholder="Email Id" class="txt-reg">
		   </div>
		   <div class="regtexttop">
		   <input type="password" name="password" id="password" placeholder="Password" class="txt-reg">
		   </div>
		   <br>
		   <div>
		   <input type="submit" name="submit" value="Login" class="btn btn-lg btn-success btncss">
		   </div>
		   
		   <div style="padding-top:10px;"><a href="#" class="forgotcss">Forgot Password? </a></div>
		   
		 </div>
		 
		 
		 <div id="register">
		   <div class="regtexttop">
		   <input type="text" name="username" id="username" placeholder="Your Name" class="txt-reg">
		   </div>
		   <div class="regtexttop">
		   <input type="email" name="email" id="email" placeholder="Email Id" class="txt-reg">
		   </div>
		   <div class="regtexttop">
		   <input type="password" name="password" id="password" placeholder="Password" class="txt-reg">
		   </div>
		   <br>
		   <div>
		   <input type="submit" name="submit" value="Register" class="btn btn-lg btn-success btncss">
		   </div>
		   
		   <div class="smalltext">By signing up you agree to our <a href="#">T&C </a> and <a href="#">Privacy Policy</a>.</div>
		   
		 </div>
		 
		 
		 
		 </div>
		 
		</div>
      </div>
     
    </div>
  </div>
</div>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

<script>
$( "#tablogin" ).click(function() {
  $("#tablogin").addClass('active');
  $("#tabreg").removeClass('active');
  $("#login").show();
  $("#register").hide();
});
$( "#tabreg" ).click(function() {
  $("#tabreg").addClass('active');
  $("#tablogin").removeClass('active');
  $("#login").hide();
  $("#register").show();
});

$( "#menulogin" ).click(function() {
  $("#tablogin").addClass('active');
  $("#tabreg").removeClass('active');
  $("#login").show();
  $("#register").hide();
});
$( "#menureg" ).click(function() {
  $("#tabreg").addClass('active');
  $("#tablogin").removeClass('active');
  $("#login").hide();
  $("#register").show();
});

</script>
    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
<script type="text/javascript">var switchTo5x=true;</script>
<script type="text/javascript" id="st_insights_js" src="http://w.sharethis.com/button/buttons.js?publisher=17cf6d1e-12fd-4d78-9d65-7a501364882c"></script>
<script type="text/javascript">stLight.options({publisher: "17cf6d1e-12fd-4d78-9d65-7a501364882c", doNotHash: false, doNotCopy: false, hashAddressBar: false});</script>
</body>

</html>
